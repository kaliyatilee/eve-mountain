@extends('layouts.admin')
@section('title', 'Rates Manager')

@section('content')
<p class="text-sm text-gray-500 mb-6">Changes to rates apply to all new bookings. Existing booking quotes are not affected (stored as snapshots).</p>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Facilities --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 bg-forest-50">
            <h2 class="font-semibold text-forest-800 text-sm">Facility Rates</h2>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($facilities as $facility)
            <form method="POST" action="{{ route('admin.rates.facility', $facility) }}" class="px-6 py-5">
                @csrf @method('PATCH')
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="font-medium text-gray-900 text-sm mb-1">{{ $facility->name }}</div>
                        <div class="text-xs text-gray-400 mb-3">{{ $facility->rate_description }}</div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Rate (US$)</label>
                                <input type="number" name="rate" value="{{ $facility->rate }}" step="0.01" min="0"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-forest-500 focus:border-transparent">
                            </div>
                            <div class="flex items-end pb-0.5">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" {{ $facility->is_active ? 'checked' : '' }} class="rounded">
                                    <span class="text-xs text-gray-600">Active</span>
                                </label>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="block text-xs text-gray-500 mb-1">Description</label>
                            <textarea name="description" rows="2"
                                      class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs resize-none focus:ring-2 focus:ring-forest-500 focus:border-transparent">{{ $facility->description }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end mt-3">
                    <button type="submit" class="bg-forest-600 hover:bg-forest-700 text-white text-xs font-medium px-4 py-1.5 rounded-full transition-colors">
                        Save
                    </button>
                </div>
            </form>
            @endforeach
        </div>
    </div>

    {{-- Activities --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 bg-earth-50">
            <h2 class="font-semibold text-earth-800 text-sm">Activity Rates</h2>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($activities as $activity)
            <form method="POST" action="{{ route('admin.rates.activity', $activity) }}" class="px-6 py-5">
                @csrf @method('PATCH')
                <div>
                    <div class="font-medium text-gray-900 text-sm mb-1">{{ $activity->name }}</div>
                    <div class="text-xs text-gray-400 mb-3">US${{ number_format($activity->cost_per_person, 2) }} per person</div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Cost per person (US$)</label>
                            <input type="number" name="cost_per_person" value="{{ $activity->cost_per_person }}" step="0.01" min="0"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-forest-500 focus:border-transparent">
                        </div>
                        <div class="flex items-end pb-0.5">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ $activity->is_active ? 'checked' : '' }} class="rounded">
                                <span class="text-xs text-gray-600">Active</span>
                            </label>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="block text-xs text-gray-500 mb-1">Description</label>
                        <textarea name="description" rows="2"
                                  class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs resize-none">{{ $activity->description }}</textarea>
                    </div>
                </div>
                <div class="flex justify-end mt-3">
                    <button type="submit" class="bg-earth-600 hover:bg-earth-700 text-white text-xs font-medium px-4 py-1.5 rounded-full transition-colors">
                        Save
                    </button>
                </div>
            </form>
            @endforeach
        </div>
    </div>
</div>
@endsection
