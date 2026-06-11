<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
        'reference', 'group_name', 'group_type', 'contact_name',
        'contact_email', 'contact_phone', 'arrival_date', 'departure_date',
        'pax_count', 'accommodation_type', 'total_quote', 'status',
        'special_requirements', 'admin_notes', 'confirmed_at',
    ];

    protected $casts = [
        'arrival_date'   => 'date',
        'departure_date' => 'date',
        'total_quote'    => 'decimal:2',
        'confirmed_at'   => 'datetime',
    ];

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'booking_facilities')
            ->withPivot('quantity', 'days', 'rate_snapshot', 'subtotal')
            ->withTimestamps();
    }

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'booking_activities')
            ->withPivot('pax', 'rate_snapshot', 'subtotal')
            ->withTimestamps();
    }

    public function getNightsAttribute(): int
    {
        return $this->arrival_date->diffInDays($this->departure_date);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'warning',
            'confirmed' => 'success',
            'cancelled' => 'danger',
            'completed' => 'secondary',
            default     => 'secondary',
        };
    }

    public static function generateReference(): string
    {
        $year  = date('Y');
        $count = static::whereYear('created_at', $year)->count() + 1;
        return 'EM-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
