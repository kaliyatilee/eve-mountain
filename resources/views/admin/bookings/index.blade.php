@extends('layouts.admin')
@section('title', 'Bookings')

@section('content')
{{-- Stats row --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['Pending', $stats['pending'], 'yellow'],
        ['Confirmed', $stats['confirmed'], 'green'],
        ['This Month', $stats['total_month'], 'blue'],
        ['Revenue (Month)', 'US$'.number_format($stats['revenue_month'],2), 'purple'],
    ] as [$l, $v, $c])
    <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
        <div class="text-xs text-gray-500">{{ $l }}</div>
        <div class="font-bold text-gray-900 text-xl mt-1">{{ $v }}</div>
    </div>
    @endforeach
</div>

{{-- Filters --}}
<form method="GET" class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-5 flex flex-wrap gap-3 items-end">
    <div>
        <label class="block text-xs text-gray-500 mb-1">Search</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Group name, reference..."
               class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm w-52">
    </div>
    <div>
        <label class="block text-xs text-gray-500 mb-1">Status</label>
        <select name="status" class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm">
            <option value="">All</option>
            @foreach(['pending','confirmed','cancelled','completed'] as $s)
            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-xs text-gray-500 mb-1">From</label>
        <input type="date" name="from" value="{{ request('from') }}" class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm">
    </div>
    <div>
        <label class="block text-xs text-gray-500 mb-1">To</label>
        <input type="date" name="to" value="{{ request('to') }}" class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm">
    </div>
    <button type="submit" class="bg-forest-600 hover:bg-forest-700 text-white text-sm px-5 py-1.5 rounded-lg transition-colors">Filter</button>
    <a href="{{ route('admin.bookings.index') }}" class="text-sm text-gray-400 hover:text-gray-600 py-1.5">Clear</a>
</form>

{{-- Table --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100 text-xs text-gray-500">
                <tr>
                    <th class="px-5 py-3 text-left font-medium">Reference</th>
                    <th class="px-5 py-3 text-left font-medium">Group</th>
                    <th class="px-5 py-3 text-left font-medium">Dates</th>
                    <th class="px-5 py-3 text-left font-medium">Pax</th>
                    <th class="px-5 py-3 text-left font-medium">Quote</th>
                    <th class="px-5 py-3 text-left font-medium">Status</th>
                    <th class="px-5 py-3 text-left font-medium">Submitted</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($bookings as $b)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-mono text-xs text-gray-700">{{ $b->reference }}</td>
                    <td class="px-5 py-3">
                        <div class="font-medium text-gray-900">{{ $b->group_name }}</div>
                        <div class="text-xs text-gray-400">{{ ucfirst($b->group_type) }}</div>
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-600">
                        {{ $b->arrival_date->format('d M') }} – {{ $b->departure_date->format('d M Y') }}
                    </td>
                    <td class="px-5 py-3 text-gray-600">{{ $b->pax_count }}</td>
                    <td class="px-5 py-3 font-medium text-gray-900">US${{ number_format($b->total_quote, 2) }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium
                            {{ $b->status === 'confirmed' ? 'bg-green-100 text-green-700' :
                               ($b->status === 'pending'  ? 'bg-yellow-100 text-yellow-700' :
                               ($b->status === 'cancelled'? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600')) }}">
                            {{ ucfirst($b->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-400">{{ $b->created_at->format('d M Y') }}</td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.bookings.show', $b) }}" class="text-forest-600 hover:underline text-xs">View →</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-6 py-12 text-center text-gray-400">No bookings found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-gray-50">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
