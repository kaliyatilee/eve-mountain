<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Facility;

class BookingQuoteService
{
    /**
     * Calculate a full quote from booking form data.
     *
     * @param array $data {
     *   arrival_date: string,
     *   departure_date: string,
     *   pax_count: int,
     *   accommodation_type: string,
     *   selected_facilities: array [ facility_id => quantity ],
     *   selected_activities: array [ activity_id ],
     *   chair_count: int,
     * }
     */
    public function calculate(array $data): array
    {
        $arrival    = \Carbon\Carbon::parse($data['arrival_date']);
        $departure  = \Carbon\Carbon::parse($data['departure_date']);
        $nights     = max(1, $arrival->diffInDays($departure));
        $days       = $nights; // same for day-rate items
        $pax        = (int) $data['pax_count'];
        $lines      = [];
        $total      = 0;

        // --- Accommodation ---
        if (in_array($data['accommodation_type'], ['dormitory', 'both'])) {
            $facility = Facility::where('slug', 'dormitory')->first();
            if ($facility) {
                $cost    = $facility->rate * $pax * $nights;
                $lines[] = [
                    'label'    => "Dormitory ({$pax} pax × US\${$facility->rate} × {$nights} night" . ($nights > 1 ? 's' : '') . ")",
                    'subtotal' => $cost,
                    'facility_id' => $facility->id,
                    'rate_snapshot' => $facility->rate,
                    'quantity' => $pax,
                    'days'     => $nights,
                ];
                $total += $cost;
            }
        }

        if (in_array($data['accommodation_type'], ['outdoor_camp', 'both'])) {
            $facility = Facility::where('slug', 'outdoor-camp')->first();
            if ($facility) {
                $cost    = $facility->rate * $pax * $days;
                $lines[] = [
                    'label'    => "Outdoor Camp ({$pax} pax × US\${$facility->rate} × {$days} day" . ($days > 1 ? 's' : '') . ")",
                    'subtotal' => $cost,
                    'facility_id' => $facility->id,
                    'rate_snapshot' => $facility->rate,
                    'quantity' => $pax,
                    'days'     => $days,
                ];
                $total += $cost;
            }
        }

        // --- Auditorium ---
        if (!empty($data['needs_auditorium'])) {
            $facility = Facility::where('slug', 'auditorium')->first();
            if ($facility) {
                $cost    = $facility->rate * $days;
                $lines[] = [
                    'label'    => "Auditorium (US\${$facility->rate}/day × {$days} day" . ($days > 1 ? 's' : '') . ")",
                    'subtotal' => $cost,
                    'facility_id' => $facility->id,
                    'rate_snapshot' => $facility->rate,
                    'quantity' => 1,
                    'days'     => $days,
                ];
                $total += $cost;
            }
        }

        // --- Kitchen ---
        if (!empty($data['needs_kitchen'])) {
            $facility = Facility::where('slug', 'kitchen')->first();
            if ($facility) {
                $cost    = $facility->rate * $days;
                $lines[] = [
                    'label'    => "Kitchen (US\${$facility->rate}/day × {$days} day" . ($days > 1 ? 's' : '') . ")",
                    'subtotal' => $cost,
                    'facility_id' => $facility->id,
                    'rate_snapshot' => $facility->rate,
                    'quantity' => 1,
                    'days'     => $days,
                ];
                $total += $cost;
            }
        }

        // --- Chairs ---
        $chairCount = (int) ($data['chair_count'] ?? 0);
        if ($chairCount > 0) {
            $facility = Facility::where('slug', 'chairs')->first();
            if ($facility) {
                $cost    = $facility->rate * $chairCount * $days;
                $lines[] = [
                    'label'    => "Chairs ({$chairCount} × US\${$facility->rate} × {$days} day" . ($days > 1 ? 's' : '') . ")",
                    'subtotal' => $cost,
                    'facility_id' => $facility->id,
                    'rate_snapshot' => $facility->rate,
                    'quantity' => $chairCount,
                    'days'     => $days,
                ];
                $total += $cost;
            }
        }

        // --- Activities ---
        $activityLines = [];
        $selectedActivities = $data['selected_activities'] ?? [];
        if (!empty($selectedActivities)) {
            $activities = Activity::whereIn('id', $selectedActivities)->get();
            foreach ($activities as $activity) {
                $cost          = $activity->cost_per_person * $pax;
                $activityLines[] = [
                    'label'         => "{$activity->name} ({$pax} pax × US\${$activity->cost_per_person})",
                    'subtotal'      => $cost,
                    'activity_id'   => $activity->id,
                    'rate_snapshot' => $activity->cost_per_person,
                    'pax'           => $pax,
                ];
                $total += $cost;
            }
        }

        return [
            'nights'         => $nights,
            'days'           => $days,
            'pax'            => $pax,
            'facility_lines' => $lines,
            'activity_lines' => $activityLines,
            'total'          => round($total, 2),
        ];
    }
}
