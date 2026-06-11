@extends('layouts.app')
@section('title', 'Activities')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-16">
    <div class="text-center mb-14">
        <h1 class="font-display text-4xl font-bold text-gray-900">Activities</h1>
        <p class="text-gray-500 mt-3 max-w-lg mx-auto">All activities are US$5 per person and can be added to your booking.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        @foreach($activities as $activity)
        <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
            <div class="h-40 bg-gradient-to-br from-forest-100 to-earth-100 flex items-center justify-center text-6xl">
                @if($activity->icon === 'bike') 🏍️
                @elseif($activity->icon === 'users') 🤝
                @elseif($activity->icon === 'waves') 🏊
                @else 🎯
                @endif
            </div>
            <div class="p-6">
                <h2 class="font-semibold text-gray-900 text-lg mb-1">{{ $activity->name }}</h2>
                <p class="text-forest-600 font-bold mb-3">US${{ number_format($activity->cost_per_person, 2) }} per person</p>
                <p class="text-sm text-gray-500 leading-relaxed">{{ $activity->description }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div class="bg-earth-50 border border-earth-200 rounded-2xl p-8 text-center">
        <h3 class="font-display text-2xl font-bold text-earth-800 mb-2">Add activities to your booking</h3>
        <p class="text-earth-600 mb-5">Activities are selected during the booking process. Mix and match what your group wants.</p>
        <a href="{{ route('booking.create') }}" class="inline-block bg-forest-600 hover:bg-forest-700 text-white font-semibold px-8 py-3 rounded-full transition-colors">
            Book Now
        </a>
    </div>
</div>
@endsection
