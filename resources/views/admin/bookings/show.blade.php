@extends('layouts.admin')
@section('title', 'Booking ' . $booking->reference)

@section('content')
<div class="max-w-3xl">
    <div class="flex items-start justify-between mb-6">
        <div>
            <a href="{{ route('admin.bookings.index') }}" class="text-xs text-gray-400 hover:text-gray-600 mb-1 inline-block">← All bookings</a>
            <h1 class="text-xl font-bold text-gray-900">{{ $booking->reference }}</h1>
            <p class="text-sm text-gray-500">{{ $booking->group_name }} · Submitted {{ $booking->created_at->diffForHumans() }}</p>
        </div>
        <span class="px-3 py-1.5 rounded-full text-sm font-medium
            {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' :
               ($booking->status === 'pending'  ? 'bg-yellow-100 text-yellow-700' :
               ($booking->status === 'cancelled'? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600')) }}">
            {{ ucfirst($booking->status) }}
        </span>
    </div>

    {{-- Action buttons --}}
    @if($booking->status === 'pending')
    <div class="flex gap-3 mb-6">
        <form method="POST" action="{{ route('admin.bookings.confirm', $booking) }}">
            @csrf
            <button type="submit" onclick="return confirm('Confirm this booking?')"
                    class="bg-green-600 hover:bg-green-700 text-white font-medium px-5 py-2 rounded-full text-sm transition-colors">
                ✓ Confirm Booking
            </button>
        </form>
        <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}">
            @csrf
            <button type="submit" onclick="return confirm('Cancel this booking?')"
                    class="bg-red-100 hover:bg-red-200 text-red-700 font-medium px-5 py-2 rounded-full text-sm transition-colors">
                ✕ Cancel
            </button>
        </form>
    </div>
    @elseif($booking->status === 'confirmed')
    <div class="mb-6">
        <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}" class="inline">
            @csrf
            <button type="submit" onclick="return confirm('Cancel this confirmed booking?')"
                    class="bg-red-100 hover:bg-red-200 text-red-700 font-medium px-5 py-2 rounded-full text-sm">
                Cancel Booking
            </button>
        </form>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
        {{-- Group & dates --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-semibold text-gray-900 text-sm mb-3">Booking details</h3>
            <dl class="space-y-2 text-sm">
                @foreach([
                    ['Group',        $booking->group_name],
                    ['Type',         ucfirst($booking->group_type)],
                    ['Arrival',      $booking->arrival_date->format('D, d M Y')],
                    ['Departure',    $booking->departure_date->format('D, d M Y')],
                    ['Nights',       $booking->nights],
                    ['Guests',       $booking->pax_count . ' people'],
                    ['Accommodation',ucfirst(str_replace('_',' ',$booking->accommodation_type))],
                ] as [$k, $v])
                <div class="flex justify-between">
                    <dt class="text-gray-500">{{ $k }}</dt>
                    <dd class="font-medium text-gray-900">{{ $v }}</dd>
                </div>
                @endforeach
            </dl>
        </div>

        {{-- Contact --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-semibold text-gray-900 text-sm mb-3">Contact</h3>
            <dl class="space-y-2 text-sm">
                @foreach([
                    ['Name',  $booking->contact_name],
                    ['Email', $booking->contact_email],
                    ['Phone', $booking->contact_phone],
                ] as [$k, $v])
                <div class="flex justify-between">
                    <dt class="text-gray-500">{{ $k }}</dt>
                    <dd class="font-medium text-gray-900">{{ $v }}</dd>
                </div>
                @endforeach
            </dl>
            <div class="flex gap-2 mt-4">
                <a href="mailto:{{ $booking->contact_email }}" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-full transition-colors">
                    Send email
                </a>
                <a href="tel:{{ $booking->contact_phone }}" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-full transition-colors">
                    Call
                </a>
            </div>
        </div>
    </div>

    {{-- Quote breakdown --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 mb-5">
        <h3 class="font-semibold text-gray-900 text-sm mb-3">Quote breakdown</h3>
        @if($booking->facilities->isNotEmpty())
        <div class="mb-3">
            <div class="text-xs text-gray-400 uppercase tracking-wider mb-2">Facilities</div>
            @foreach($booking->facilities as $f)
            <div class="flex justify-between text-sm py-1.5 border-b border-gray-50">
                <span class="text-gray-700">{{ $f->name }}</span>
                <span class="font-medium">US${{ number_format($f->pivot->subtotal, 2) }}</span>
            </div>
            @endforeach
        </div>
        @endif
        @if($booking->activities->isNotEmpty())
        <div class="mb-3">
            <div class="text-xs text-gray-400 uppercase tracking-wider mb-2">Activities</div>
            @foreach($booking->activities as $a)
            <div class="flex justify-between text-sm py-1.5 border-b border-gray-50">
                <span class="text-gray-700">{{ $a->name }} ({{ $a->pivot->pax }} pax)</span>
                <span class="font-medium">US${{ number_format($a->pivot->subtotal, 2) }}</span>
            </div>
            @endforeach
        </div>
        @endif
        <div class="flex justify-between font-bold text-gray-900 pt-3">
            <span>Total</span>
            <span>US${{ number_format($booking->total_quote, 2) }}</span>
        </div>
    </div>

    {{-- Special requirements --}}
    @if($booking->special_requirements)
    <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-5 mb-5">
        <h3 class="font-semibold text-yellow-800 text-sm mb-2">Special requirements</h3>
        <p class="text-sm text-yellow-700">{{ $booking->special_requirements }}</p>
    </div>
    @endif

    {{-- Admin notes --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <h3 class="font-semibold text-gray-900 text-sm mb-3">Admin notes</h3>
        <form method="POST" action="{{ route('admin.bookings.notes', $booking) }}" class="flex gap-3">
            @csrf @method('PATCH')
            <textarea name="admin_notes" rows="2" placeholder="Internal notes about this booking..."
                      class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm resize-none focus:ring-2 focus:ring-forest-500 focus:border-transparent">{{ $booking->admin_notes }}</textarea>
            <button type="submit" class="self-end bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg text-sm transition-colors">Save</button>
        </form>
    </div>
</div>
@endsection
