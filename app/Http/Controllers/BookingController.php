<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Booking;
use App\Models\Facility;
use App\Services\AvailabilityService;
use App\Services\BookingQuoteService;
use App\Mail\BookingConfirmation;
use App\Mail\BookingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function __construct(
        private BookingQuoteService $quoteService,
        private AvailabilityService $availabilityService,
    ) {}

    public function create()
    {
        $facilities = Facility::where('is_active', true)->orderBy('sort_order')->get();
        $activities = Activity::where('is_active', true)->orderBy('sort_order')->get();
        $unavailableDates = $this->availabilityService->getUnavailableDates();

        return view('public.booking', compact('facilities', 'activities', 'unavailableDates'));
    }

    /**
     * AJAX: Calculate quote without submitting
     */
    public function quote(Request $request)
    {
        $data = $request->validate([
            'arrival_date'        => 'required|date|after:today',
            'departure_date'      => 'required|date|after:arrival_date',
            'pax_count'           => 'required|integer|min:1|max:275',
            'accommodation_type'  => 'required|in:dormitory,outdoor_camp,both,none',
            'needs_auditorium'    => 'nullable|boolean',
            'needs_kitchen'       => 'nullable|boolean',
            'chair_count'         => 'nullable|integer|min:0',
            'selected_activities' => 'nullable|array',
            'selected_activities.*' => 'exists:activities,id',
        ]);

        $quote = $this->quoteService->calculate($data);
        return response()->json($quote);
    }

    /**
     * Submit the booking
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'group_name'           => 'required|string|max:200',
            'group_type'           => 'required|in:church,ngo,company,school,other',
            'contact_name'         => 'required|string|max:100',
            'contact_email'        => 'required|email',
            'contact_phone'        => 'required|string|max:30',
            'arrival_date'         => 'required|date|after:today',
            'departure_date'       => 'required|date|after:arrival_date',
            'pax_count'            => 'required|integer|min:1|max:275',
            'accommodation_type'   => 'required|in:dormitory,outdoor_camp,both,none',
            'needs_auditorium'     => 'nullable|boolean',
            'needs_kitchen'        => 'nullable|boolean',
            'chair_count'          => 'nullable|integer|min:0',
            'selected_activities'  => 'nullable|array',
            'selected_activities.*' => 'exists:activities,id',
            'special_requirements' => 'nullable|string|max:1000',
        ]);

        // Check availability
        $availability = $this->availabilityService->check(
            $data['arrival_date'],
            $data['departure_date'],
            $data['accommodation_type'],
            $data['pax_count']
        );

        if (!$availability['available']) {
            return back()->withErrors(['availability' => $availability['reason']])->withInput();
        }

        // Calculate quote
        $quote = $this->quoteService->calculate($data);

        DB::beginTransaction();
        try {
            $booking = Booking::create([
                'reference'            => Booking::generateReference(),
                'group_name'           => $data['group_name'],
                'group_type'           => $data['group_type'],
                'contact_name'         => $data['contact_name'],
                'contact_email'        => $data['contact_email'],
                'contact_phone'        => $data['contact_phone'],
                'arrival_date'         => $data['arrival_date'],
                'departure_date'       => $data['departure_date'],
                'pax_count'            => $data['pax_count'],
                'accommodation_type'   => $data['accommodation_type'],
                'total_quote'          => $quote['total'],
                'status'               => 'pending',
                'special_requirements' => $data['special_requirements'] ?? null,
            ]);

            // Attach facility lines
            foreach ($quote['facility_lines'] as $line) {
                $booking->facilities()->attach($line['facility_id'], [
                    'quantity'      => $line['quantity'],
                    'days'          => $line['days'],
                    'rate_snapshot' => $line['rate_snapshot'],
                    'subtotal'      => $line['subtotal'],
                ]);
            }

            // Attach activity lines
            foreach ($quote['activity_lines'] as $line) {
                $booking->activities()->attach($line['activity_id'], [
                    'pax'           => $line['pax'],
                    'rate_snapshot' => $line['rate_snapshot'],
                    'subtotal'      => $line['subtotal'],
                ]);
            }

            DB::commit();

            // Send confirmation to client
            Mail::to($booking->contact_email)->send(new BookingConfirmation($booking, $quote));

            // Notify admin
            Mail::to(config('mail.admin_email', 'admin@evemountain.co.zw'))
                ->send(new BookingNotification($booking, $quote));

            return redirect()->route('booking.confirmation', $booking->reference)
                ->with('success', 'Booking submitted! Reference: ' . $booking->reference);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong. Please try again.'])->withInput();
        }
    }

    public function confirmation(string $reference)
    {
        $booking = Booking::where('reference', $reference)->firstOrFail();
        return view('public.booking-confirmation', compact('booking'));
    }
}
