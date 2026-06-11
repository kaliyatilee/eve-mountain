@extends('layouts.app')
@section('title', 'Facilities & Rates')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-16">
    <div class="text-center mb-12">
        <h1 class="font-display text-4xl font-bold text-gray-900">Facilities & Rates</h1>
        <p class="text-gray-500 mt-3 max-w-xl mx-auto">Everything included at Eve Mountain Campsite. All prices in USD.</p>
    </div>

    {{-- Rates table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-12">
        <div class="bg-forest-700 text-white px-6 py-4">
            <h2 class="font-semibold">Facility Rates</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-3 font-medium text-gray-700">Facility</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-700">Rate</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-700">Details</th>
                        <th class="text-right px-6 py-3 font-medium text-gray-700">Capacity</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($facilities as $f)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $f->name }}</td>
                        <td class="px-6 py-4 text-forest-600 font-semibold">{{ $f->rate_description }}</td>
                        <td class="px-6 py-4 text-gray-500 max-w-sm">{{ $f->description }}</td>
                        <td class="px-6 py-4 text-right text-gray-500">
                            {{ $f->capacity ? number_format($f->capacity) . ' pax' : '—' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Facility detail cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        <div class="bg-forest-50 border border-forest-100 rounded-2xl p-6">
            <h3 class="font-semibold text-forest-800 mb-3">🛏️ Dormitories</h3>
            <ul class="text-sm text-forest-700 space-y-1.5">
                <li>✓ Hot water geysers in all dorms</li>
                <li>✓ Bunk beds — 40 per dormitory</li>
                <li>✓ Multiple dormitories available</li>
                <li>✓ Up to 75 total dormitory guests</li>
            </ul>
        </div>
        <div class="bg-forest-50 border border-forest-100 rounded-2xl p-6">
            <h3 class="font-semibold text-forest-800 mb-3">🎤 Auditorium / Gazebo</h3>
            <ul class="text-sm text-forest-700 space-y-1.5">
                <li>✓ Seats 100 people</li>
                <li>✓ Projector & speakers</li>
                <li>✓ Printer available</li>
                <li>✓ Suitable for conferences & worship</li>
            </ul>
        </div>
        <div class="bg-earth-50 border border-earth-100 rounded-2xl p-6">
            <h3 class="font-semibold text-earth-800 mb-3">🍳 Kitchen</h3>
            <ul class="text-sm text-earth-700 space-y-1.5">
                <li>✓ Three-plate gas stove</li>
                <li>✓ Two 50kg gas tanks</li>
                <li>✓ Fridge included</li>
                <li>⚠️ Utensils not provided — bring your own</li>
            </ul>
        </div>
        <div class="bg-earth-50 border border-earth-100 rounded-2xl p-6">
            <h3 class="font-semibold text-earth-800 mb-3">⛺ Outdoor Camp</h3>
            <ul class="text-sm text-earth-700 space-y-1.5">
                <li>✓ Tent camping area</li>
                <li>✓ Hot water showers</li>
                <li>✓ Bathrooms and toilets</li>
                <li>✓ Gas-powered cooking area</li>
                <li>✓ Up to 200 guests</li>
            </ul>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('booking.create') }}" class="inline-block bg-forest-600 hover:bg-forest-700 text-white font-semibold px-10 py-3.5 rounded-full transition-colors">
            Get an Instant Quote
        </a>
    </div>
</div>
@endsection
