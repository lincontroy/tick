<?php

namespace App\Http\Controllers;


use App\Models\Payment;
use App\Models\Ticket;
use App\Models\MpesaTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Event;
use DB;

class PaymentController extends Controller
{

    public function checkPayment($reference)
{
    // Find pending transaction
    $payment = \DB::table('payments')->where('reference', $reference)->first();
    if (!$payment) {
        return ['error' => 'Transaction not found'];
    }

    // --- Get Token ---
    $tokenRes = Http::withBasicAuth(env('MPESA_CONSUMER_KEY'), env('MPESA_CONSUMER_SECRET'))
        ->get('https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
    $accessToken = $tokenRes->json()['access_token'];

    $timestamp = now()->format('YmdHis');
    $password = base64_encode(env('MPESA_SHORTCODE') . env('MPESA_PASSKEY') . $timestamp);

    // --- Query STK ---
    $res = Http::withToken($accessToken)
        ->post('https://api.safaricom.co.ke/mpesa/stkpushquery/v1/query', [
            "BusinessShortCode" => env('MPESA_SHORTCODE'),
            "Password" => $password,
            "Timestamp" => $timestamp,
            "CheckoutRequestID" => $payment->reference, // 🔴 if you saved CheckoutRequestID, use it here
        ]);

    $data = $res->json();

    if (isset($data['ResultCode']) && $data['ResultCode'] == '0') {
        // ✅ Payment successful
        \DB::table('payments')->where('id', $payment->id)->update([
            'status' => 'completed',
            'mpesa_receipt' => $data['MpesaReceiptNumber'] ?? 'N/A',
            'updated_at' => now(),
        ]);

        // Send SMS
        $this->sendSms($payment->phone, "✅ Payment of KSh {$payment->amount} successful. Ref: {$payment->reference}. Enjoy your event!");
    } elseif (isset($data['ResultCode']) && $data['ResultCode'] != '0') {
        \DB::table('payments')->where('id', $payment->id)->update([
            'status' => 'failed',
            'updated_at' => now(),
        ]);
    }

    return $data;
}

public function sendSms($phoneNumber, $message)
{
    $url = "https://sms.movesms.co.ke/api/compose";

    // Normalize phone to international format (2547xxxxxxx)
    if ($phoneNumber) {
        $phoneNumber = preg_replace('/^\+?254/', '254', $phoneNumber); // Ensure no +
        $phoneNumber = preg_replace('/^0/', '254', $phoneNumber);      // Convert 07xxxxxxx -> 2547xxxxxxx
    }

    $params = [
        'username' => 'Devlincoln',
        'api_key'  => 'ueO45AoxT9sNY54R1VRZnHgbGzxDZybJhvxtMK78WRpvILLZrs',
        'sender'   => 'SMARTLINK',
        'to'       => $phoneNumber,
        'message'  => $message,
        'msgtype'  => 5,  // normal text
        'dlr'      => 1   // request delivery report
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => $url . '?' . http_build_query($params),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 30
    ]);

    try {
        $response = curl_exec($ch);

        if ($response === false) {
            throw new \Exception('cURL Error: ' . curl_error($ch));
        }

        // Decode if JSON, otherwise return raw response
        $decoded = json_decode($response, true);

        \Log::info('MoveSMS Response', ['response' => $decoded ?: $response]);

        return $decoded ?: $response;

    } catch (\Exception $e) {
        \Log::error('MoveSMS Error', ['error' => $e->getMessage()]);
        return ['error' => true, 'message' => $e->getMessage()];
    } finally {
        curl_close($ch);
    }
}



public function smstest(Request $request)
{
    $phoneNumber = $request->phone;
    $message     = $request->message;

    $url = "https://sms.movesms.co.ke/api/compose";

    // Normalize phone to international format (2547xxxxxxx)
    if ($phoneNumber) {
        $phoneNumber = preg_replace('/^\+?254/', '254', $phoneNumber); // Ensure no +
        $phoneNumber = preg_replace('/^0/', '254', $phoneNumber);      // Convert 07xxxxxxx -> 2547xxxxxxx
    }

    $params = [
        'username' => 'Devlincoln',
        'api_key'  => 'ueO45AoxT9sNY54R1VRZnHgbGzxDZybJhvxtMK78WRpvILLZrs',
        'sender'   => 'SMARTLINK',
        'to'       => $phoneNumber,
        'message'  => $message,
        'msgtype'  => 5,  // Normal text
        'dlr'      => 1   // Request delivery report
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => $url . '?' . http_build_query($params),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 30
    ]);

    try {
        $response = curl_exec($ch);

        if ($response === false) {
            throw new \Exception('cURL Error: ' . curl_error($ch));
        }

        // Decode if JSON, otherwise return raw
        $decoded = json_decode($response, true);

        \Log::info('MoveSMS Response', ['response' => $decoded ?: $response]);

        return $decoded ?: $response;

    } catch (\Exception $e) {
        \Log::error('MoveSMS Error', ['error' => $e->getMessage()]);
        return ['error' => true, 'message' => $e->getMessage()];
    } finally {
        curl_close($ch);
    }
}



public function stkPush(Request $request, Event $event)
    {
        $username="qXb5B3PCYtEjXLdwUlyK";
        $password="QIdyOsLIaFHM85nAW2mcT0MLUx66dmuLTLdrabV0";
        $basicToken = base64_encode($username . ':' . $password);

        $phone   = $request->phone;
        $tickets = $request->tickets;
        $amount  = $event->price * $tickets;

        $payload = json_encode([
            "amount"             => $amount,
            "phone_number"       => $phone,
            "channel_id"         => 3286, 
            "provider"           => "m-pesa",
            "external_reference" => "INV-" . time(),
            "customer_name"      => $request->name ?? "Guest",
            "callback_url"       => "https://ticketcraft.co.ke/api/callback",
        ]);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => "https://backend.payhero.co.ke/api/v2/payments",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_HTTPHEADER     => [
                "Content-Type: application/json",
                "Authorization: Basic " . $basicToken,
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return back()->with('success', 'STK push sent. Enter your M-Pesa PIN to complete payment.');
    }



    public function initiate(Request $request, Event $event)
    {
        // $request->validate([
        //     'phone' => 'required|string|regex:/^(?:2547|2541)\d{7}$/',
        //     'tickets' => 'required|integer|min:1|max:10',
        // ]);
    
        $phone   = $request->phone;
        $tickets = $request->tickets;
        $amount  = $event->price * $tickets;
    
        // Generate reference
        $reference = 'EVT-' . strtoupper(uniqid());
    
        // --- Get Token ---
        $tokenRes = Http::withBasicAuth(env('MPESA_CONSUMER_KEY'), env('MPESA_CONSUMER_SECRET'))
            ->get('https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
        $accessToken = $tokenRes->json()['access_token'];
    
        $timestamp = now()->format('YmdHis');
        $password = base64_encode(env('MPESA_SHORTCODE') . env('MPESA_PASSKEY') . $timestamp);
    
        // --- STK Request ---
        $stkRes = Http::withToken($accessToken)
            ->post('https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest', [
                "BusinessShortCode" => env('MPESA_SHORTCODE'),
                "Password" => $password,
                "Timestamp" => $timestamp,
                "TransactionType" => "CustomerPayBillOnline",
                "Amount" => $amount,
                "PartyA" => $phone,
                "PartyB" => env('MPESA_SHORTCODE'),
                "PhoneNumber" => $phone,
                "CallBackURL" => env('MPESA_CALLBACK_URL'), // you can ignore this for now
                "AccountReference" => $reference,
                "TransactionDesc" => "Event Ticket Purchase"
            ]);
    
        $stkJson = $stkRes->json();
    
        // --- Save Payment ---
        \DB::table('payments')->insert([
            'user_id'   => 1, // 0 if guest
            'event_id'  => $event->id,
            'phone'     => $phone,
            'amount'    => $amount,
            'reference' => $reference,
            'status'    => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return back()->with('success', 'STK push sent. Enter your M-Pesa PIN to complete payment.');
    }
    
    public function initiatePayment(Request $request, Event $event)
    {
        $request->validate([
            'phone' => 'required|string|max:12',
            'tickets' => 'required|integer|min:1|max:' . $event->available_tickets
        ]);

        $amount = $event->price * $request->tickets;
        $reference = 'TICKET-' . Str::random(8);

        // Create payment record
        $payment = Payment::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
            'phone' => $request->phone,
            'amount' => $amount,
            'reference' => $reference,
            'status' => 'pending'
        ]);

        // Reserve tickets
        for ($i = 0; $i < $request->tickets; $i++) {
            Ticket::create([
                'event_id' => $event->id,
                'user_id' => auth()->id(),
                'ticket_number' => 'TKT-' . Str::random(10),
                'status' => 'reserved'
            ]);
        }

        // Update available tickets
        $event->decrement('available_tickets', $request->tickets);

        // Initiate M-Pesa payment
        return $this->initiateMpesaPayment($request->phone, $amount, $reference);
    }

    private function initiateMpesaPayment($phone, $amount, $reference)
    {
        // This is a simplified version - you'll need to implement the actual M-Pesa API integration
        // For now, we'll simulate a successful payment
        
        $mpesa = new \Safaricom\Mpesa\Mpesa();
        
        try {
            $response = $mpesa->STKPushSimulation(
                config('mpesa.business_shortcode'),
                config('mpesa.passkey'),
                'CustomerPayBillOnline',
                $amount,
                $phone,
                config('mpesa.business_shortcode'),
                $phone,
                route('payment.callback'),
                $reference,
                'Event Tickets Payment'
            );
            
            // Process the response and update payment status
            return redirect()->back()->with('success', 'Payment initiated successfully. Please check your phone to complete the payment.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Payment initiation failed: ' . $e->getMessage());
        }
    }

    public function paymentCallback(Request $request)
    {
        try {
            $callbackData = json_decode($request->getContent());
    
            if (isset($callbackData->response)) {
                $resp = $callbackData->response;
    
                $amount             = $resp->Amount ?? null;
                $externalReference  = $resp->ExternalReference ?? null;
                $mpesaReceiptNumber = $resp->MpesaReceiptNumber ?? null;
                $phoneNumber        = $resp->Phone ?? null;
                $status             = $resp->Status ?? 'Failed';

                if ($phoneNumber) {
                    $phoneNumber = preg_replace('/^\+?254/', '0', $phoneNumber);
                }
    
                if (strtolower($status) === 'success') {
                    // ✅ Payment success
                    $ticketLink = url("/storage/Kenya_vs_Madagascar_Ticket.pdf");

                  //  return null;
                //   dd($phoneNumber);
    
                    $this->sendSms(
                        $phoneNumber,
                        "✅ Payment of KSh {$amount} successful. Ref: {$externalReference}. Enjoy your event! Ticket: {$ticketLink}"
                    );

                    
                }
            }
    
            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
    
        } catch (\Exception $e) {
            // Log error for debugging
            \Log::error('Payment Callback Error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'payload' => $request->getContent()
            ]);
    
            return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Failed']);
        }
    }
    
    
}