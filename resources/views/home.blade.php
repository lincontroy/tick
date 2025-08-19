@extends('layouts.app')

@section('title', 'Dashboard - TicketHub')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Welcome to your TicketHub dashboard, {{ Auth::user()->first_name }}!</p>
                    <p>Here you can manage your event tickets and bookings.</p>
                    
                    <div class="mt-4">
                        <a href="{{ route('events.index') }}" class="btn btn-primary">
                            Browse Events
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection