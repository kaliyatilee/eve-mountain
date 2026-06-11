@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
{{-- Stats grid --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
        <div class="text-xs text-gray-500 mb-1">Pending Bookings</div>
        <div class="text-2xl font-bold text-gray-900 mb-0.5">{{ $stats['pending'] ?? 0 }}</div>
        <div class="text-xs text-gray-400">Awaiting confirmation</div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
        <div class="text-xs text-gray-500 mb-1">Confirmed Bookings</div>
        <div class="text-2xl font-bold text-gray-900 mb-0.5">{{ $stats['confirmed'] ?? 0 }}</div>
        <div class="text-xs text-gray-400">Active reservations</div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
        <div class="text-xs text-gray-500 mb-1">This Month</div>
        <div class="text-2xl font-bold text-gray-900 mb-0.5">{{ $stats['total_month'] ?? 0 }}</div>
        <div class="text-xs text-gray-400">New bookings this month</div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
        <div class="text-xs text-gray-500 mb-1">Revenue (Month)</div>
        <div class="text-2xl font-bold text-gray-900 mb-0.5">US${{ number_format($stats['revenue_month'] ?? 0, 2) }}</div>
        <div class="text-xs text-gray-400">Confirmed revenue</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Recent bookings --}}
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900 text-sm">Recent Bookings</h2>
            <a href="{{ route('admin.bookings.index') }}" class="text-xs text-forest-600 hover:underline">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentBookings as $b)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">
                            <div class="font-medium text-gray-900 text-xs font-mono">{{ $b->reference }}</div>
                            <div class="text-xs text-gray-400">{{ $b->group_name }}</div>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-500">{{ $b->arrival_date->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-xs text-gray-500">{{ $b->pax_count }} pax</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $b->status === 'confirmed'  ? 'bg-green-100 text-green-700'  :
                                  ($b->status === 'pending'    ? 'bg-yellow-100 text-yellow-700' :
                                  ($b->status === 'cancelled'  ? 'bg-red-100 text-red-700'       : 'bg-gray-100 text-gray-600')) }}">
                                {{ ucfirst($b->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.bookings.show', $b) }}" class="text-xs text-forest-600 hover:underline">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400 text-xs">
                            No bookings yet. They will appear here once clients submit requests.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Upcoming arrivals --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50">
            <h2 class="font-semibold text-gray-900 text-sm">Upcoming Arrivals</h2>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($upcomingBookings as $b)
            <div class="px-5 py-3.5">
                <div class="font-medium text-sm text-gray-900">{{ $b->group_name }}</div>
                <div class="text-xs text-gray-400 mt-0.5">
                    {{ $b->arrival_date->format('D d M') }} · {{ $b->pax_count }} pax
                </div>
                <div class="text-xs text-forest-600 mt-0.5">{{ $b->reference }}</div>
            </div>
            @empty
            <div class="px-5 py-10 text-center text-gray-400 text-xs">
                No upcoming confirmed arrivals.
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Summary footer --}}
<div class="mt-6 grid grid-cols-2 sm:grid-cols-3 gap-4">
    <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
        <div class="text-xs text-gray-500">Total bookings (all time)</div>
        <div class="font-bold text-gray-900 text-xl mt-1">{{ $stats['total_bookings'] ?? 0 }}</div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
        <div class="text-xs text-gray-500">Gallery images</div>
        <div class="font-bold text-gray-900 text-xl mt-1">{{ $stats['gallery_count'] ?? 0 }}</div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm sm:col-span-1 col-span-2">
        <div class="text-xs text-gray-500">Total confirmed revenue</div>
        <div class="font-bold text-gray-900 text-xl mt-1">US${{ number_format($stats['revenue_total'] ?? 0, 2) }}</div>
    </div>
</div>
@endsection
