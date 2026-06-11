@extends('layouts.app')
@section('title', 'Booking Received – ' . $booking->reference)

@section('content')
<div class="max-w-xl mx-auto px-4 py-16 text-center">
    <div class="w-16 h-16 bg-forest-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-8 h-8 text-forest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
    </div>
    <h1 class="font-display text-3xl font-bold text-gray-900 mb-2">Booking Request Received!</h1>
    <p class="text-gray-500 mb-6">We have received your booking request and will confirm within 24 hours.</p>

    <div class="bg-forest-50 border border-forest-200 rounded-2xl p-6 text-left mb-8">
        <div class="text-center mb-4">
            <div class="text-sm text-gray-500">Your reference number</div>
            <div class="font-display text-3xl font-bold text-forest-700">{{ $booking->reference }}</div>
        </div>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between"><span class="text-gray-500">Group</span><span class="font-medium">{{ $booking->group_name }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Arrival</span><span class="font-medium">{{ $booking->arrival_date->format('D, d M Y') }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Departure</span><span class="font-medium">{{ $booking->departure_date->format('D, d M Y') }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Guests</span><span class="font-medium">{{ $booking->pax_count }}</span></div>
            <div class="flex justify-between border-t border-forest-200 pt-2 mt-2">
                <span class="font-semibold text-forest-800">Estimated total</span>
                <span class="font-bold text-forest-800">US${{ number_format($booking->total_quote, 2) }}</span>
            </div>
        </div>
    </div>

    <p class="text-sm text-gray-400 mb-8">A confirmation email has been sent to <strong>{{ $booking->contact_email }}</strong>.</p>

    <a href="{{ route('home') }}" class="inline-block bg-forest-600 hover:bg-forest-700 text-white font-medium px-7 py-3 rounded-full text-sm transition-colors">
        Back to Home
    </a>
</div>
@endsection
