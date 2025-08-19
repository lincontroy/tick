<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date_time',
        'venue',
        'price',
        'total_tickets',
        'available_tickets',
        'image'
    ];

    // Cast date_time to a Carbon instance
    protected $casts = [
        'date_time' => 'datetime',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Accessor for formatted date
    public function getFormattedDateAttribute()
    {
        return $this->date_time instanceof Carbon
            ? $this->date_time->translatedFormat('F j, Y') // e.g. August 20, 2025
            : null;
    }

    // Accessor for formatted time
    public function getFormattedTimeAttribute()
    {
        return $this->date_time instanceof Carbon
            ? $this->date_time->format('g:i A') // e.g. 2:30 PM
            : null;
    }

    // Accessor for formatted price
    public function getFormattedPriceAttribute()
    {
        return 'KSh ' . number_format($this->price, 2);
    }
}
