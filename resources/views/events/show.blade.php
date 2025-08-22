@extends('layouts.app')

@section('title', $event->title . ' - TicketHub')

@section('styles')
<style>
    .event-detail-container {
        background: linear-gradient(to bottom, #faf7ff, #f0f9ff);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .event-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        margin: 0 auto;
        max-width: 1000px;
    }
    
    .event-hero {
        height: 350px;
        position: relative;
        overflow: hidden;
    }
    
    .event-hero img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .event-hero-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
        padding: 2rem;
        color: white;
    }
    
    .event-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: white;
    }
    
    .event-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.9rem;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .event-content {
        padding: 2.5rem;
    }
    
    .event-meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .event-meta-item {
        display: flex;
        align-items: center;
        padding: 1.2rem;
        background: #f8fafc;
        border-radius: 16px;
        transition: all 0.3s ease;
    }
    
    .event-meta-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }
    
    .meta-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border-radius: 12px;
        font-size: 1.2rem;
        margin-right: 1rem;
        flex-shrink: 0;
    }
    
    .meta-content h3 {
        font-size: 0.85rem;
        color: #718096;
        margin-bottom: 0.3rem;
        font-weight: 500;
    }
    
    .meta-content p {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2d3748;
        margin: 0;
    }
    
    .event-description {
        margin-bottom: 2.5rem;
    }
    
    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.5rem;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 4px;
        background: linear-gradient(to right, #6366f1, #8b5cf6);
        border-radius: 2px;
    }
    
    .description-text {
        color: #4a5568;
        line-height: 1.7;
        font-size: 1.05rem;
    }
    
    .booking-section {
        background: #f8fafc;
        border-radius: 16px;
        padding: 2rem;
        margin-top: 2rem;
    }
    
    .booking-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    
    .booking-title i {
        color: #6366f1;
        margin-right: 0.75rem;
        font-size: 1.8rem;
    }
    
    .booking-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }
    
    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
    }
    
    .payment-summary {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
    }
    
    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .summary-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .summary-total {
        display: flex;
        justify-content: space-between;
        font-weight: 800;
        font-size: 1.2rem;
        padding-top: 1rem;
        margin-top: 1rem;
        border-top: 2px solid #e2e8f0;
        color: #6366f1;
    }
    
    .submit-button {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(to right, #6366f1, #8b5cf6);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .submit-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
    }
    
    .sold-out-alert {
        background: linear-gradient(to right, #fed7d7, #feebeb);
        border: 1px solid #feb2b2;
        color: #c53030;
        padding: 1.5rem;
        border-radius: 12px;
        text-align: center;
    }
    
    .sold-out-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    
    .sold-out-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .sold-out-text {
        margin-bottom: 1rem;
    }
    
    .back-to-events {
        display: inline-flex;
        align-items: center;
        color: #6366f1;
        font-weight: 600;
        text-decoration: none;
        margin-top: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .back-to-events:hover {
        color: #8b5cf6;
        transform: translateX(-5px);
    }
    
    .ticket-availability-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        margin-left: 1rem;
    }
    
    .ticket-high {
        background: #c6f6d5;
        color: #2f855a;
    }
    
    .ticket-medium {
        background: #fefcbf;
        color: #b7791f;
    }
    
    .ticket-low {
        background: #fed7d7;
        color: #c53030;
    }
    
    @media (max-width: 768px) {
        .event-title {
            font-size: 2rem;
        }
        
        .event-content {
            padding: 1.5rem;
        }
        
        .event-meta-grid {
            grid-template-columns: 1fr;
        }
        
        .booking-form {
            grid-template-columns: 1fr;
        }
        
        .event-hero {
            height: 250px;
        }
    }
</style>
@endsection

@section('content')
<div class="event-detail-container">
    <div class="container mx-auto px-4">
        <a href="{{ route('events.index') }}" class="back-to-events">
            <i class="fas fa-arrow-left mr-2"></i> Back to Events
        </a>
        
        <div class="event-card">
            <div class="event-hero">
                <img src="{{ $event->image ? asset('storage/' . $event->image) : asset('images/event-placeholder.jpg') }}" 
                     alt="{{ $event->title }}">
                <div class="event-hero-overlay">
                    <h1 class="event-title">{{ $event->title }}</h1>
                    <div>
                        <span class="event-badge"><i class="fas fa-map-marker-alt mr-1"></i> {{ $event->venue }}</span>
                        <span class="event-badge"><i class="fas fa-calendar mr-1"></i> {{ $event->formatted_date }}</span>
                        <span class="event-badge"><i class="fas fa-clock mr-1"></i> {{ $event->formatted_time }}</span>
                    </div>
                </div>
            </div>
            
            <div class="event-content">
                <div class="event-meta-grid">
                    <div class="event-meta-item">
                        <div class="meta-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="meta-content">
                            <h3>Date</h3>
                            <p>{{ $event->formatted_date }}</p>
                        </div>
                    </div>
                    
                    <div class="event-meta-item">
                        <div class="meta-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="meta-content">
                            <h3>Time</h3>
                            <p>{{ $event->formatted_time }}</p>
                        </div>
                    </div>
                    
                    <div class="event-meta-item">
                        <div class="meta-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="meta-content">
                            <h3>Venue</h3>
                            <p>{{ $event->venue }}</p>
                        </div>
                    </div>
                    
                    <div class="event-meta-item">
                        <div class="meta-icon">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="meta-content">
                            <h3>Price</h3>
                            <p>{{ $event->formatted_price }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="event-description">
                    <h2 class="section-title">Event Description</h2>
                    <p class="description-text">{{ $event->description }}</p>
                </div>
                
                <div class="booking-section">
                    <h2 class="booking-title">
                        <i class="fas fa-ticket-alt"></i>
                        Book Your Tickets
                        @php
                            $ticketPercentage = ($event->available_tickets / $event->total_tickets) * 100;
                            $ticketClass = 'ticket-high';
                            if ($ticketPercentage < 30) {
                                $ticketClass = 'ticket-low';
                            } elseif ($ticketPercentage < 60) {
                                $ticketClass = 'ticket-medium';
                            }
                        @endphp
                        <span class="ticket-availability-badge {{ $ticketClass }}">
                           32 VIP tickets left
                        </span>
                    </h2>
                    
                    @if($event->available_tickets > 0)
                    @if(session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
@endif

                    <form action="{{ route('payment.initiate', $event) }}" method="POST">
                        @csrf

                        
                        <div class="booking-form">
                            <div class="form-group">
                                <label for="tickets" class="form-label">Number of Tickets</label>
                                <select name="tickets" id="tickets" class="form-control" required>
                                    @for($i = 1; $i <= min($event->available_tickets, 10); $i++)
                                        <option value="{{ $i }}">{{ $i }} ticket{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone" class="form-label">M-Pesa Phone Number</label>
                                <input type="text" 
                                name="phone" 
                                id="phone" 
                                class="form-control" 
                                placeholder="e.g., 0712345678" 
                                pattern="^07[0-9]{8}$" 
                                title="Phone number must start with 07 and be 10 digits long" 
                                required>
                         
                            </div>
                            
                        </div>
                        
                        <div class="payment-summary">
                            <h3 class="font-semibold text-gray-800 mb-3">Payment Summary</h3>
                            <div class="summary-item">
                                <span>Tickets Price</span>
                                <span id="tickets-price">{{ $event->formatted_price }}</span>
                            </div>
                            <div class="summary-item">
                                <span>Quantity</span>
                                <span id="tickets-quantity">1</span>
                            </div>
                            <div class="summary-total">
                                <span>Total Amount</span>
                                <span id="total-amount">{{ $event->formatted_price }}</span>
                            </div>
                        </div>
                        
                        <button type="submit" class="submit-button">
                            <i class="fas fa-mobile-alt"></i>
                            Buy via M-Pesa
                        </button>
                    </form>
                    @else
                    <div class="sold-out-alert">
                        <div class="sold-out-icon">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <h3 class="sold-out-title">Sold Out!</h3>
                        <p class="sold-out-text">All tickets for this event have been sold. Please check our other events.</p>
                        <a href="{{ route('events.index') }}" class="submit-button">
                            <i class="fas fa-calendar"></i>
                            Browse Other Events
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ticketsSelect = document.getElementById('tickets');
        const ticketsPrice = {{ $event->price }};
        const ticketsPriceElement = document.getElementById('tickets-price');
        const ticketsQuantityElement = document.getElementById('tickets-quantity');
        const totalAmountElement = document.getElementById('total-amount');
        
        function formatCurrency(amount) {
            return 'KSh ' + amount.toLocaleString('en-KE', {minimumFractionDigits: 2});
        }
        
        function updatePaymentSummary() {
            const quantity = parseInt(ticketsSelect.value);
            const total = ticketsPrice * quantity;
            
            ticketsQuantityElement.textContent = quantity;
            totalAmountElement.textContent = formatCurrency(total);
        }
        
        ticketsSelect.addEventListener('change', updatePaymentSummary);
    });
</script>
@endsection