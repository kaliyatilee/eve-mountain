<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['facilities', 'activities'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('group_name', 'like', '%' . $request->search . '%')
                  ->orWhere('reference', 'like', '%' . $request->search . '%')
                  ->orWhere('contact_email', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('from')) {
            $query->where('arrival_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->where('arrival_date', '<=', $request->to);
        }

        $bookings = $query->paginate(20)->withQueryString();

        $stats = [
            'pending'   => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'total_month' => Booking::whereMonth('created_at', now()->month)->count(),
            'revenue_month' => Booking::where('status', 'confirmed')
                ->whereMonth('confirmed_at', now()->month)
                ->sum('total_quote'),
        ];

        return view('admin.bookings.index', compact('bookings', 'stats'));
    }

    public function show(Booking $booking)
    {
        $booking->load('facilities', 'activities');
        return view('admin.bookings.show', compact('booking'));
    }

    public function confirm(Booking $booking)
    {
        $booking->update([
            'status'       => 'confirmed',
            'confirmed_at' => now(),
        ]);

        // Send confirmation email to client
        \Mail::to($booking->contact_email)->send(new \App\Mail\BookingStatusUpdate($booking));

        return back()->with('success', 'Booking confirmed. Email sent to client.');
    }

    public function cancel(Request $request, Booking $booking)
    {
        $request->validate(['admin_notes' => 'nullable|string|max:500']);
        $booking->update([
            'status'      => 'cancelled',
            'admin_notes' => $request->admin_notes,
        ]);
        return back()->with('success', 'Booking cancelled.');
    }

    public function updateNotes(Request $request, Booking $booking)
    {
        $request->validate(['admin_notes' => 'nullable|string|max:1000']);
        $booking->update(['admin_notes' => $request->admin_notes]);
        return back()->with('success', 'Notes saved.');
    }
}
