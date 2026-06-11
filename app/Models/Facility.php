<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Facility extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'rate', 'rate_unit',
        'capacity', 'icon', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'rate'      => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class, 'booking_facilities')
            ->withPivot('quantity', 'days', 'rate_snapshot', 'subtotal')
            ->withTimestamps();
    }

    public function getRateDescriptionAttribute(): string
    {
        return match ($this->rate_unit) {
            'per_person_per_night' => 'US$' . number_format($this->rate, 2) . ' per person/night',
            'per_person_per_day'   => 'US$' . number_format($this->rate, 2) . ' per person/day',
            'per_day'              => 'US$' . number_format($this->rate, 2) . ' per day',
            'per_day_per_unit'     => 'US$' . number_format($this->rate, 2) . ' per unit/day',
            default                => 'US$' . number_format($this->rate, 2),
        };
    }

    /**
     * Calculate cost for given pax, days, quantity
     */
    public function calculateCost(int $pax, int $days, int $quantity = 1): float
    {
        return match ($this->rate_unit) {
            'per_person_per_night' => $this->rate * $pax * $days,
            'per_person_per_day'   => $this->rate * $pax * $days,
            'per_day'              => $this->rate * $days,
            'per_day_per_unit'     => $this->rate * $quantity * $days,
            default                => $this->rate,
        };
    }
}
