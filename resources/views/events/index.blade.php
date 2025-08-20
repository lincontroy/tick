@extends('layouts.app')

@section('title', 'Events - TicketHub')

@section('styles')
<style>
    .events-container {
        background: linear-gradient(to bottom, #f0f9ff, #e6f7ff);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .events-header {
        text-align: center;
        margin-bottom: 3rem;
        position: relative;
    }
    
    .events-title {
        font-size: 2.8rem;
        font-weight: 800;
        color: #4a5568;
        margin-bottom: 1rem;
        position: relative;
        display: inline-block;
    }
    
    .events-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(to right, #6366f1, #8b5cf6);
        border-radius: 2px;
    }
    
    .events-subtitle {
        color: #718096;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .events-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }
    
    .event-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
        border: 1px solid #e2e8f0;
    }
    
    .event-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }
    
    .event-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(to right, #6366f1, #8b5cf6);
    }
    
    .event-image {
        height: 200px;
        overflow: hidden;
        position: relative;
    }
    
    .event-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .event-card:hover .event-image img {
        transform: scale(1.05);
    }
    
    .event-date-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.95);
        padding: 8px 12px;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #6366f1;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .event-content {
        padding: 1.5rem;
    }
    
    .event-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }
    
    .event-description {
        color: #718096;
        margin-bottom: 1.25rem;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .event-meta {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
    }
    
    .event-meta-item {
        display: flex;
        align-items: center;
        color: #4a5568;
        font-size: 0.9rem;
    }
    
    .event-meta-item i {
        color: #6366f1;
        margin-right: 0.5rem;
        width: 20px;
    }
    
    .event-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
    }
    
    .event-price {
        font-size: 1.5rem;
        font-weight: 800;
        color: #6366f1;
    }
    
    .ticket-availability {
        font-size: 0.85rem;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
    }
    
    .ticket-high {
        background: #f0fff4;
        color: #38a169;
    }
    
    .ticket-medium {
        background: #fffaf0;
        color: #d69e2e;
    }
    
    .ticket-low {
        background: #fff5f5;
        color: #e53e3e;
    }
    
    .event-button {
        display: block;
        width: 100%;
        text-align: center;
        padding: 0.75rem;
        background: linear-gradient(to right, #6366f1, #8b5cf6);
        color: white;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
    }
    
    .event-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(99, 102, 241, 0.4);
    }
    
    .no-events {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
    
    .no-events-icon {
        font-size: 4rem;
        color: #cbd5e0;
        margin-bottom: 1.5rem;
    }
    
    .no-events-title {
        font-size: 1.5rem;
        color: #4a5568;
        margin-bottom: 1rem;
    }
    
    .no-events-text {
        color: #718096;
        max-width: 500px;
        margin: 0 auto;
    }
    
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 3rem;
    }
    
    .pagination {
        display: flex;
        gap: 0.5rem;
    }
    
    .pagination-item {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        color: #4a5568;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 600;
    }
    
    .pagination-item:hover, .pagination-item.active {
        background: linear-gradient(to right, #6366f1, #8b5cf6);
        color: white;
        border-color: #6366f1;
    }
    
    @media (max-width: 768px) {
        .events-title {
            font-size: 2.2rem;
        }
        
        .events-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .event-footer {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }
    }
</style>
@endsection

@section('content')
<div class="events-container">
    <div class="container mx-auto px-4 py-8">
        <div class="events-header">
            <h1 class="events-title">Upcoming Event</h1>
            <p class="events-subtitle">Discover amazing experiences waiting for you. Book your tickets in seconds with our secure platform.</p>
        </div>
        
        @if($events->isEmpty())
            <div class="no-events">
                <div class="no-events-icon">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <h3 class="no-events-title">No Events Scheduled</h3>
                <p class="no-events-text">There are no upcoming events at the moment. Please check back later for new events or follow us on social media for updates.</p>
            </div>
        @else
            <div class="events-grid">
                @foreach($events as $event)
                <div class="event-card">
                    <div class="event-image">
                        <img src="{{ $event->image ? asset('storage/' . $event->image) : asset('images/event-placeholder.jpg') }}" 
                             alt="{{ $event->title }}">
                        <div class="event-date-badge">
                            <i class="fas fa-calendar-alt"></i>
                            {{ $event->date_time->format('M j') }}
                        </div>
                    </div>
                    
                    <div class="event-content">
                        <h2 class="event-title">{{ $event->title }}</h2>
                        <p class="event-description">{{ Str::limit($event->description, 120) }}</p>
                        
                        <div class="event-meta">
                            <div class="event-meta-item">
                                <i class="fas fa-clock"></i>
                                {{ $event->date_time->format('g:i A') }}
                            </div>
                            <div class="event-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $event->venue }}
                            </div>
                        </div>
                        
                        <div class="event-footer">
                            <div class="event-price">KSh {{ number_format($event->price, 2) }}</div>
                            @php
                                $ticketPercentage = ($event->available_tickets / $event->total_tickets) * 100;
                                $ticketClass = 'ticket-high';
                                if ($ticketPercentage < 30) {
                                    $ticketClass = 'ticket-low';
                                } elseif ($ticketPercentage < 60) {
                                    $ticketClass = 'ticket-medium';
                                }
                            @endphp
                            <span class="ticket-availability {{ $ticketClass }}">
                                {{ $event->available_tickets }} left
                            </span>
                        </div>
                        
                        <a href="{{ route('events.show', $event) }}" class="event-button">
                            View Details & Book
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
            
        @endif
    </div>
</div>
@endsection