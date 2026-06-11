<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Activity;
use App\Models\GalleryImage;

class HomeController extends Controller
{
    public function index()
    {
        $heroImages = GalleryImage::where('is_visible', true)
            ->orderBy('sort_order')
            ->limit(5)
            ->get();

        $facilities = Facility::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $activities = Activity::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('public.home', compact('heroImages', 'facilities', 'activities'));
    }

    public function facilities()
    {
        $facilities = Facility::where('is_active', true)->orderBy('sort_order')->get();
        return view('public.facilities', compact('facilities'));
    }

    public function activities()
    {
        $activities = Activity::where('is_active', true)->orderBy('sort_order')->get();
        return view('public.activities', compact('activities'));
    }

    public function gallery()
    {
        $images = GalleryImage::where('is_visible', true)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');
        return view('public.gallery', compact('images'));
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function sendContact(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'phone'   => 'nullable|string|max:30',
            'message' => 'required|string|max:2000',
        ]);

        // Send notification email to admin
        \Mail::send([], [], function ($mail) use ($data) {
            $mail->to(config('mail.admin_email', 'admin@evemountain.co.zw'))
                 ->subject('New Contact Enquiry – ' . $data['name'])
                 ->html(
                     "<p><strong>Name:</strong> {$data['name']}</p>
                      <p><strong>Email:</strong> {$data['email']}</p>
                      <p><strong>Phone:</strong> " . ($data['phone'] ?? 'N/A') . "</p>
                      <p><strong>Message:</strong><br>" . nl2br(e($data['message'])) . "</p>"
                 );
        });

        return back()->with('success', 'Thank you! We will get back to you shortly.');
    }
}
