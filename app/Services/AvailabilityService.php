<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BlockedDate;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AvailabilityService
{
    /**
     * Check if the campsite can accept a booking for given dates.
     * Returns array with 'available' bool and 'reason' string.
     */
    public function check(string $arrival, string $departure, string $accommodationType, int $pax): array
    {
        $arrivalDate   = Carbon::parse($arrival);
        $departureDate = Carbon::parse($departure);

        // Check blocked dates
        $blocked = BlockedDate::whereBetween('date', [$arrivalDate, $departureDate])->exists();
        if ($blocked) {
            return ['available' => false, 'reason' => 'Some dates in your selected range are not available.'];
        }

        // Check dormitory capacity (75 max)
        if (in_array($accommodationType, ['dormitory', 'both'])) {
            $overlapping = Booking::where('status', '!=', 'cancelled')
                ->where('accommodation_type', '!=', 'outdoor_camp')
                ->where(function ($q) use ($arrivalDate, $departureDate) {
                    $q->whereBetween('arrival_date', [$arrivalDate, $departureDate])
                      ->orWhereBetween('departure_date', [$arrivalDate, $departureDate])
                      ->orWhere(function ($q2) use ($arrivalDate, $departureDate) {
                          $q2->where('arrival_date', '<=', $arrivalDate)
                             ->where('departure_date', '>=', $departureDate);
                      });
                })
                ->sum('pax_count');

            if (($overlapping + $pax) > 75) {
                return ['available' => false, 'reason' => 'Dormitory capacity exceeded for those dates. Maximum 75 guests in dormitories.'];
            }
        }

        // Check outdoor camp capacity (200 max)
        if (in_array($accommodationType, ['outdoor_camp', 'both'])) {
            $overlapping = Booking::where('status', '!=', 'cancelled')
                ->where('accommodation_type', '!=', 'dormitory')
                ->where(function ($q) use ($arrivalDate, $departureDate) {
                    $q->whereBetween('arrival_date', [$arrivalDate, $departureDate])
                      ->orWhereBetween('departure_date', [$arrivalDate, $departureDate])
                      ->orWhere(function ($q2) use ($arrivalDate, $departureDate) {
                          $q2->where('arrival_date', '<=', $arrivalDate)
                             ->where('departure_date', '>=', $departureDate);
                      });
                })
                ->sum('pax_count');

            if (($overlapping + $pax) > 200) {
                return ['available' => false, 'reason' => 'Outdoor camp capacity exceeded for those dates. Maximum 200 guests in outdoor camp.'];
            }
        }

        return ['available' => true, 'reason' => ''];
    }

    /**
     * Get all blocked/fully-booked dates for the calendar (next 12 months).
     * Returns array of date strings.
     */
    public function getUnavailableDates(): array
    {
        $dates = [];

        // Admin-blocked dates
        $blocked = BlockedDate::where('date', '>=', today())
            ->pluck('date')
            ->map(fn ($d) => $d->format('Y-m-d'))
            ->toArray();

        return array_unique(array_merge($dates, $blocked));
    }
}
