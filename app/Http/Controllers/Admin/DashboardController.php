<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\GalleryImage;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pending'         => Booking::where('status', 'pending')->count(),
            'confirmed'       => Booking::where('status', 'confirmed')->count(),
            'total_bookings'  => Booking::count(),
            'gallery_count'   => GalleryImage::count(),
            'revenue_total'   => Booking::where('status', 'confirmed')->sum('total_quote'),
            'revenue_month'   => Booking::where('status', 'confirmed')
                ->whereMonth('confirmed_at', now()->month)
                ->whereYear('confirmed_at', now()->year)
                ->sum('total_quote'),
        ];

        $recentBookings = Booking::latest()->limit(8)->get();

        $upcomingBookings = Booking::where('status', 'confirmed')
            ->where('arrival_date', '>=', today())
            ->orderBy('arrival_date')
            ->limit(5)
            ->get();

        // Monthly bookings for chart (last 6 months)
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $chartData[] = [
                'label' => $month->format('M'),
                'count' => Booking::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
            ];
        }

        return view('admin.dashboard', compact('stats', 'recentBookings', 'upcomingBookings', 'chartData'));
    }
}
