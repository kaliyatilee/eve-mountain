@extends('layouts.app')
@section('title', 'Book Your Stay')
@section('description', 'Reserve your group retreat at Eve Mountain Campsite. Instant quote calculator.')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .step { display: none; }
    .step.active { display: block; }
    .step-indicator { transition: all .3s; }
    .check-card input:checked + label { @apply ring-2 ring-forest-500 bg-forest-50; }
</style>
@endpush

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">
    <div class="text-center mb-10">
        <h1 class="font-display text-3xl md:text-4xl font-bold text-gray-900">Book Your Stay</h1>
        <p class="text-gray-500 mt-2">Fill in the details below and get an instant quote.</p>
    </div>

    {{-- Step indicators --}}
    <div class="flex items-center justify-center gap-2 mb-10" id="step-indicators">
        @foreach(['Your Stay', 'Facilities', 'Contact', 'Review'] as $i => $label)
        <div class="step-indicator flex items-center gap-2">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold border-2
                {{ $i === 0 ? 'bg-forest-600 border-forest-600 text-white' : 'border-gray-300 text-gray-400' }}"
                 id="step-dot-{{ $i + 1 }}">{{ $i + 1 }}</div>
            <span class="text-xs text-gray-500 hidden sm:block">{{ $label }}</span>
            @if($i < 3)
                <div class="w-8 h-px bg-gray-200 mx-1"></div>
            @endif
        </div>
        @endforeach
    </div>

    <form id="booking-form" method="POST" action="{{ route('booking.store') }}">
        @csrf

        {{-- ── Step 1: Dates & Accommodation ── --}}
        <div class="step active" id="step-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <h2 class="font-semibold text-gray-900 text-lg mb-6">Your stay</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Arrival date *</label>
                        <input type="text" name="arrival_date" id="arrival-date" placeholder="Select date"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-forest-500 focus:border-transparent"
                               value="{{ old('arrival_date') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Departure date *</label>
                        <input type="text" name="departure_date" id="departure-date" placeholder="Select date"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-forest-500 focus:border-transparent"
                               value="{{ old('departure_date') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Number of guests *</label>
                        <input type="number" name="pax_count" id="pax-count" min="1" max="275" placeholder="e.g. 40"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-forest-500 focus:border-transparent"
                               value="{{ old('pax_count') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Group type *</label>
                        <select name="group_type"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-forest-500 focus:border-transparent" required>
                            <option value="">Select...</option>
                            @foreach(['church' => 'Church', 'ngo' => 'NGO', 'company' => 'Company', 'school' => 'School/College', 'other' => 'Other'] as $val => $label)
                                <option value="{{ $val }}" {{ old('group_type') == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Accommodation type *</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach([
                            ['dormitory',    'Dormitory Bunk Beds', 'Up to 75 guests, hot water, bunk beds', '🛏️'],
                            ['outdoor_camp', 'Outdoor Camp (Tents)', 'Up to 200 guests, showers & cooking area', '⛺'],
                            ['both',         'Both (Dorms + Outdoor)', 'Maximum capacity 275 guests', '🏕️'],
                            ['none',         'Day visit only', 'No overnight accommodation', '☀️'],
                        ] as [$val, $lbl, $desc, $icon])
                        <label class="flex items-start gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-forest-50 hover:border-forest-300 transition-all has-[:checked]:ring-2 has-[:checked]:ring-forest-500 has-[:checked]:bg-forest-50">
                            <input type="radio" name="accommodation_type" value="{{ $val }}" class="mt-0.5" {{ old('accommodation_type') == $val ? 'checked' : '' }} required>
                            <div>
                                <div class="font-medium text-sm text-gray-900">{{ $icon }} {{ $lbl }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">{{ $desc }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button type="button" onclick="nextStep(2)" class="bg-forest-600 hover:bg-forest-700 text-white font-medium px-7 py-2.5 rounded-full text-sm transition-colors">
                    Next: Facilities →
                </button>
            </div>
        </div>

        {{-- ── Step 2: Facilities & Activities ── --}}
        <div class="step" id="step-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <h2 class="font-semibold text-gray-900 text-lg mb-6">Facilities & activities</h2>

                <div class="space-y-4">
                    <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-forest-50 has-[:checked]:ring-2 has-[:checked]:ring-forest-500 has-[:checked]:bg-forest-50 transition-all">
                        <input type="checkbox" name="needs_auditorium" value="1" {{ old('needs_auditorium') ? 'checked' : '' }}>
                        <div class="flex-1">
                            <div class="font-medium text-sm text-gray-900">🎤 Auditorium / Gazebo</div>
                            <div class="text-xs text-gray-500">Seats 100 · Projector, speakers, printer · US$100/day</div>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-forest-50 has-[:checked]:ring-2 has-[:checked]:ring-forest-500 has-[:checked]:bg-forest-50 transition-all">
                        <input type="checkbox" name="needs_kitchen" value="1" {{ old('needs_kitchen') ? 'checked' : '' }}>
                        <div class="flex-1">
                            <div class="font-medium text-sm text-gray-900">🍳 Kitchen</div>
                            <div class="text-xs text-gray-500">Gas stove, fridge (no utensils) · US$60/day</div>
                        </div>
                    </label>

                    <div class="p-4 border border-gray-200 rounded-xl">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-900 mb-2">
                            🪑 Chairs (US$0.50 per chair/day)
                        </label>
                        <input type="number" name="chair_count" min="0" max="500" placeholder="Number of chairs needed"
                               class="w-48 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-forest-500 focus:border-transparent"
                               value="{{ old('chair_count', 0) }}">
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="font-medium text-gray-900 mb-4 text-sm">Activities <span class="text-gray-400 font-normal">(US$5 per person each)</span></h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @foreach($activities as $activity)
                        <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-earth-50 has-[:checked]:ring-2 has-[:checked]:ring-earth-400 has-[:checked]:bg-earth-50 transition-all">
                            <input type="checkbox" name="selected_activities[]" value="{{ $activity->id }}"
                                   {{ in_array($activity->id, old('selected_activities', [])) ? 'checked' : '' }}>
                            <div>
                                <div class="font-medium text-sm text-gray-900">{{ $activity->name }}</div>
                                <div class="text-xs text-gray-500">US${{ number_format($activity->cost_per_person, 2) }}/person</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Live quote preview --}}
            <div id="quote-preview" class="mt-4 bg-forest-50 border border-forest-200 rounded-2xl p-5 hidden">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold text-forest-800 text-sm">Estimated Quote</h3>
                    <span class="text-xs text-forest-600">Based on your selections</span>
                </div>
                <div id="quote-lines" class="space-y-1 text-sm text-forest-700 mb-3"></div>
                <div class="border-t border-forest-300 pt-3 flex justify-between font-bold text-forest-900">
                    <span>Total estimate</span>
                    <span id="quote-total">US$0.00</span>
                </div>
                <p class="text-xs text-forest-600 mt-2">Final amount confirmed upon booking approval.</p>
            </div>

            <div class="flex justify-between mt-4">
                <button type="button" onclick="prevStep(1)" class="text-gray-600 hover:text-gray-900 font-medium px-6 py-2.5 rounded-full border border-gray-300 text-sm transition-colors">
                    ← Back
                </button>
                <button type="button" onclick="nextStep(3)" class="bg-forest-600 hover:bg-forest-700 text-white font-medium px-7 py-2.5 rounded-full text-sm transition-colors">
                    Next: Contact →
                </button>
            </div>
        </div>

        {{-- ── Step 3: Contact Details ── --}}
        <div class="step" id="step-3">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <h2 class="font-semibold text-gray-900 text-lg mb-6">Contact details</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Group / Organisation name *</label>
                        <input type="text" name="group_name" placeholder="e.g. Living Hope Church"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-forest-500 focus:border-transparent"
                               value="{{ old('group_name') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Your name *</label>
                        <input type="text" name="contact_name" placeholder="Full name"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-forest-500 focus:border-transparent"
                               value="{{ old('contact_name') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone number *</label>
                        <input type="tel" name="contact_phone" placeholder="+263 77 XXX XXXX"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-forest-500 focus:border-transparent"
                               value="{{ old('contact_phone') }}" required>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email address *</label>
                        <input type="email" name="contact_email" placeholder="your@email.com"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-forest-500 focus:border-transparent"
                               value="{{ old('contact_email') }}" required>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Special requirements <span class="text-gray-400 font-normal">(optional)</span></label>
                        <textarea name="special_requirements" rows="3" placeholder="Dietary needs, accessibility, specific setup requests..."
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-forest-500 focus:border-transparent resize-none">{{ old('special_requirements') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-4">
                <button type="button" onclick="prevStep(2)" class="text-gray-600 hover:text-gray-900 font-medium px-6 py-2.5 rounded-full border border-gray-300 text-sm transition-colors">
                    ← Back
                </button>
                <button type="button" onclick="nextStep(4)" class="bg-forest-600 hover:bg-forest-700 text-white font-medium px-7 py-2.5 rounded-full text-sm transition-colors">
                    Review →
                </button>
            </div>
        </div>

        {{-- ── Step 4: Review & Submit ── --}}
        <div class="step" id="step-4">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <h2 class="font-semibold text-gray-900 text-lg mb-6">Review your booking</h2>
                <div id="review-content" class="space-y-3 text-sm text-gray-700"></div>

                {{-- Final quote --}}
                <div id="final-quote" class="mt-6 bg-forest-50 rounded-xl p-5 border border-forest-200">
                    <div class="font-semibold text-forest-800 mb-2">Quote Breakdown</div>
                    <div id="final-quote-lines" class="space-y-1 text-sm text-forest-700"></div>
                    <div class="border-t border-forest-300 mt-3 pt-3 flex justify-between font-bold text-forest-900">
                        <span>Total estimate</span>
                        <span id="final-quote-total">—</span>
                    </div>
                </div>

                <p class="text-xs text-gray-400 mt-4">
                    By submitting, you agree to our booking terms. You will receive a confirmation email and we will contact you within 24 hours to confirm availability and payment details.
                </p>
            </div>
            <div class="flex justify-between mt-4">
                <button type="button" onclick="prevStep(3)" class="text-gray-600 hover:text-gray-900 font-medium px-6 py-2.5 rounded-full border border-gray-300 text-sm transition-colors">
                    ← Back
                </button>
                <button type="submit" id="submit-btn"
                        class="bg-forest-600 hover:bg-forest-700 text-white font-semibold px-8 py-2.5 rounded-full text-sm transition-colors">
                    Submit Booking Request ✓
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
const unavailableDates = @json($unavailableDates);
let currentStep = 1;
let quoteData = null;

// Init date pickers
const arrivalPicker = flatpickr('#arrival-date', {
    minDate: 'today',
    disable: unavailableDates,
    dateFormat: 'Y-m-d',
    onChange: () => { departureMin(); fetchQuote(); }
});
const departurePicker = flatpickr('#departure-date', {
    minDate: new Date().fp_incr(1),
    disable: unavailableDates,
    dateFormat: 'Y-m-d',
    onChange: fetchQuote
});

function departureMin() {
    const a = document.getElementById('arrival-date').value;
    if (a) departurePicker.set('minDate', new Date(a).fp_incr(1));
}

// ── Step navigation ──
function nextStep(n) { goToStep(n); }
function prevStep(n) { goToStep(n); }

function goToStep(n) {
    document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
    document.getElementById('step-' + n).classList.add('active');

    // Update dots
    for (let i = 1; i <= 4; i++) {
        const dot = document.getElementById('step-dot-' + i);
        if (i < n) {
            dot.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold border-2 bg-forest-600 border-forest-600 text-white';
            dot.innerHTML = '✓';
        } else if (i === n) {
            dot.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold border-2 bg-forest-600 border-forest-600 text-white';
            dot.innerHTML = i;
        } else {
            dot.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold border-2 border-gray-300 text-gray-400';
            dot.innerHTML = i;
        }
    }

    currentStep = n;
    if (n === 2) fetchQuote();
    if (n === 4) buildReview();
    window.scrollTo({top: 0, behavior: 'smooth'});
}

// ── Quote fetching ──
async function fetchQuote() {
    const form = document.getElementById('booking-form');
    const fd = new FormData(form);
    const arrival = fd.get('arrival_date');
    const departure = fd.get('departure_date');
    const pax = fd.get('pax_count');
    const accom = fd.get('accommodation_type');
    if (!arrival || !departure || !pax || !accom) return;

    const body = {
        arrival_date: arrival,
        departure_date: departure,
        pax_count: pax,
        accommodation_type: accom,
        needs_auditorium: fd.get('needs_auditorium') ? 1 : 0,
        needs_kitchen: fd.get('needs_kitchen') ? 1 : 0,
        chair_count: fd.get('chair_count') || 0,
        selected_activities: fd.getAll('selected_activities[]'),
        _token: document.querySelector('meta[name=csrf-token]').content,
    };

    try {
        const res = await fetch('{{ route("booking.quote") }}', {
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': body._token},
            body: JSON.stringify(body),
        });
        quoteData = await res.json();
        renderQuote(quoteData);
    } catch (e) { console.error(e); }
}

function renderQuote(q) {
    if (!q) return;
    const lines = [...(q.facility_lines || []), ...(q.activity_lines || [])];
    const html = lines.map(l => `<div class="flex justify-between"><span>${l.label}</span><span>US$${l.subtotal.toFixed(2)}</span></div>`).join('');
    const total = `US$${q.total.toFixed(2)}`;

    const preview = document.getElementById('quote-preview');
    document.getElementById('quote-lines').innerHTML = html;
    document.getElementById('quote-total').textContent = total;
    preview.classList.remove('hidden');

    document.getElementById('final-quote-lines').innerHTML = html;
    document.getElementById('final-quote-total').textContent = total;
}

function buildReview() {
    fetchQuote();
    const fd = new FormData(document.getElementById('booking-form'));
    const html = [
        ['Dates', `${fd.get('arrival_date')} → ${fd.get('departure_date')}`],
        ['Guests', fd.get('pax_count')],
        ['Group type', fd.get('group_type')],
        ['Accommodation', fd.get('accommodation_type')],
        ['Organisation', fd.get('group_name')],
        ['Contact', fd.get('contact_name')],
        ['Email', fd.get('contact_email')],
        ['Phone', fd.get('contact_phone')],
    ].map(([k, v]) => v ? `<div class="flex justify-between py-1.5 border-b border-gray-100"><span class="text-gray-500">${k}</span><span class="font-medium">${v}</span></div>` : '').join('');
    document.getElementById('review-content').innerHTML = html;
}

// Auto-fetch on changes in step 2
document.addEventListener('change', e => {
    if (['needs_auditorium','needs_kitchen','chair_count'].includes(e.target.name) ||
        e.target.name === 'selected_activities[]') {
        fetchQuote();
    }
});

// Submit button loading state
document.getElementById('booking-form').addEventListener('submit', function() {
    const btn = document.getElementById('submit-btn');
    btn.disabled = true;
    btn.textContent = 'Submitting...';
});
</script>
@endpush
