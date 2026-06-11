<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Activity extends Model
{
    protected $fillable = ['name', 'description', 'cost_per_person', 'icon', 'is_active', 'sort_order'];

    protected $casts = [
        'cost_per_person' => 'decimal:2',
        'is_active'       => 'boolean',
    ];

    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class, 'booking_activities')
            ->withPivot('pax', 'rate_snapshot', 'subtotal')
            ->withTimestamps();
    }
}
