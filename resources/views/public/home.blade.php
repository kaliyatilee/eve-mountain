@extends('layouts.app')
@section('title', 'Eve Mountain Campsite – Group Retreats & Teambuilding Zimbabwe')
@section('description', 'Eve Mountain Campsite Zimbabwe – Dormitories for 75, outdoor camping for 200. Perfect for churches, NGOs, companies and schools.')

@section('content')

{{-- ── HERO ──────────────────────────────────────────────────────── --}}
<section class="relative h-screen min-h-[600px] flex items-end overflow-hidden">
    {{-- Best hero: dramatic sunset shot with building --}}
    <img src="{{ asset('images/LEO09040.jpeg') }}"
         alt="Eve Mountain Campsite at golden hour"
         class="absolute inset-0 w-full h-full object-cover object-center">
    <div class="absolute inset-0 bg-gradient-to-t from-gray-950/90 via-gray-900/40 to-transparent"></div>

    <div class="relative w-full max-w-6xl mx-auto px-6 pb-16 md:pb-24">
        <p class="text-earth-300 text-xs font-semibold tracking-[0.2em] uppercase mb-3">Zimbabwe's Premier Group Retreat</p>
        <h1 class="font-display text-5xl md:text-7xl font-bold text-white leading-tight mb-5 drop-shadow-lg">
            Where Groups<br>Come Alive
        </h1>
        <p class="text-gray-200 text-lg max-w-xl mb-8 leading-relaxed">
            A purpose-built mountain campsite for churches, NGOs, companies and schools.
            Up to 275 guests, 3 activities, full facilities.
        </p>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('booking.create') }}"
               class="bg-forest-500 hover:bg-forest-400 text-white font-semibold px-8 py-3.5 rounded-full transition-all text-sm shadow-lg hover:shadow-forest-500/30 hover:scale-105">
                Reserve Your Stay
            </a>
            <a href="{{ route('gallery') }}"
               class="bg-white/10 hover:bg-white/20 backdrop-blur text-white font-medium px-8 py-3.5 rounded-full transition-all text-sm border border-white/25">
                View Gallery
            </a>
        </div>
    </div>
</section>

{{-- ── STATS BAR ─────────────────────────────────────────────────── --}}
<section class="bg-forest-700 text-white py-8">
    <div class="max-w-5xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
        @foreach([['75','Dormitory guests'],['200','Outdoor campers'],['100','Auditorium seats'],['3+','On-site activities']] as [$n,$l])
        <div>
            <div class="font-display text-4xl font-bold text-earth-300">{{ $n }}</div>
            <div class="text-xs text-forest-100 mt-1 uppercase tracking-wide">{{ $l }}</div>
        </div>
        @endforeach
    </div>
</section>

{{-- ── WHO WE WELCOME ───────────────────────────────────────────── --}}
<section class="py-20 max-w-6xl mx-auto px-4">
    <div class="text-center mb-12">
        <p class="text-forest-600 text-xs font-semibold tracking-[0.15em] uppercase">Who We Welcome</p>
        <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mt-2">Built for groups</h2>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
        @foreach([['⛪','Churches','Retreats, camps & worship weekends'],['🤝','NGOs','Workshops & strategy sessions'],['🏢','Companies','Teambuilding & corporate retreats'],['🎓','Schools','Educational camps & excursions']] as [$icon,$label,$desc])
        <div class="text-center p-6 rounded-2xl bg-forest-50 hover:bg-forest-100 transition-colors">
            <div class="text-4xl mb-3">{{ $icon }}</div>
            <h3 class="font-semibold text-gray-900 mb-1">{{ $label }}</h3>
            <p class="text-xs text-gray-500 leading-relaxed">{{ $desc }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ── FACILITIES WITH REAL PHOTOS ─────────────────────────────── --}}
<section class="bg-gray-50 py-20">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-14">
            <p class="text-forest-600 text-xs font-semibold tracking-[0.15em] uppercase">What We Offer</p>
            <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mt-2">Facilities & Rates</h2>
        </div>

        {{-- Big feature: Auditorium --}}
        <div class="grid md:grid-cols-2 gap-8 items-center mb-16">
            <div class="overflow-hidden rounded-2xl shadow-lg">
                <img src="{{ asset('images/LEO09080.jpeg') }}" alt="Auditorium"
                     class="w-full h-72 object-cover hover:scale-105 transition-transform duration-700">
            </div>
            <div>
                <span class="text-xs font-semibold text-forest-600 uppercase tracking-wider">Auditorium / Gazebo</span>
                <h3 class="font-display text-2xl font-bold text-gray-900 mt-2 mb-3">Conference-ready, 100 seats</h3>
                <p class="text-gray-500 leading-relaxed mb-4">A large open hall fitted with a ceiling-mounted Epson projector, speakers and ample natural light. Ideal for worship sessions, presentations and large group gatherings.</p>
                <div class="text-2xl font-bold text-forest-600">US$100 <span class="text-sm font-normal text-gray-400">/ day</span></div>
            </div>
        </div>

        {{-- Dormitories --}}
        <div class="grid md:grid-cols-2 gap-8 items-center mb-16">
            <div class="order-2 md:order-1">
                <span class="text-xs font-semibold text-forest-600 uppercase tracking-wider">Dormitories</span>
                <h3 class="font-display text-2xl font-bold text-gray-900 mt-2 mb-3">Comfortable bunk beds for 75</h3>
                <p class="text-gray-500 leading-relaxed mb-4">Clean dormitories fitted with hot water geysers and bunk beds. Multiple dorms available to accommodate your full group with up to 75 guests in total.</p>
                <div class="text-2xl font-bold text-forest-600">US$12 <span class="text-sm font-normal text-gray-400">/ person / night</span></div>
            </div>
            <div class="order-1 md:order-2 overflow-hidden rounded-2xl shadow-lg">
                <img src="{{ asset('images/LEO09062.jpeg') }}" alt="Dormitory"
                     class="w-full h-72 object-cover hover:scale-105 transition-transform duration-700">
            </div>
        </div>

        {{-- 3-col grid: other facilities --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($facilities as $facility)
            @if(!in_array($facility->slug, ['dormitory','auditorium']))
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <h3 class="font-semibold text-gray-900 mb-1">{{ $facility->name }}</h3>
                <p class="text-forest-600 font-bold text-lg mb-2">{{ $facility->rate_description }}</p>
                <p class="text-sm text-gray-500 leading-relaxed">{{ $facility->description }}</p>
            </div>
            @endif
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('facilities') }}" class="inline-block border-2 border-forest-600 text-forest-600 hover:bg-forest-600 hover:text-white font-semibold px-8 py-3 rounded-full transition-all">
                See All Rates
            </a>
        </div>
    </div>
</section>

{{-- ── IMMERSIVE PHOTO GRID ─────────────────────────────────────── --}}
<section class="py-20 max-w-6xl mx-auto px-4">
    <div class="text-center mb-12">
        <p class="text-forest-600 text-xs font-semibold tracking-[0.15em] uppercase">The Experience</p>
        <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mt-2">Feel the place</h2>
        <p class="text-gray-500 mt-2 max-w-lg mx-auto">Nature, space and purpose — everything your group needs to connect and grow.</p>
    </div>

    {{-- Masonry-style grid --}}
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
        <div class="col-span-2 md:col-span-1 row-span-2 overflow-hidden rounded-2xl">
            <img src="{{ asset('images/LEO09019.jpeg') }}" alt="Eve Mountain Campsite"
                 class="w-full h-full min-h-[300px] object-cover hover:scale-105 transition-transform duration-700">
        </div>
        <div class="overflow-hidden rounded-2xl">
            <img src="{{ asset('images/LEO09190.jpeg') }}" alt="Welcome to Eve Mountain"
                 class="w-full h-52 object-cover hover:scale-105 transition-transform duration-700">
        </div>
        <div class="overflow-hidden rounded-2xl">
            <img src="{{ asset('images/LEO09074.jpeg') }}" alt="Auditorium"
                 class="w-full h-52 object-cover hover:scale-105 transition-transform duration-700">
        </div>
        <div class="overflow-hidden rounded-2xl">
            <img src="{{ asset('images/LEO09131.jpeg') }}" alt="Teambuilding"
                 class="w-full h-52 object-cover hover:scale-105 transition-transform duration-700">
        </div>
        <div class="overflow-hidden rounded-2xl">
            <img src="{{ asset('images/LEO09029.jpeg') }}" alt="Outdoor seating"
                 class="w-full h-52 object-cover hover:scale-105 transition-transform duration-700">
        </div>
    </div>

    <div class="text-center mt-8">
        <a href="{{ route('gallery') }}"
           class="inline-block bg-forest-600 hover:bg-forest-700 text-white font-semibold px-8 py-3 rounded-full transition-colors">
            View Full Gallery →
        </a>
    </div>
</section>

{{-- ── ACTIVITIES ───────────────────────────────────────────────── --}}
<section class="bg-gray-900 text-white py-20">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-14">
            <p class="text-earth-300 text-xs font-semibold tracking-[0.15em] uppercase">On-site</p>
            <h2 class="font-display text-3xl md:text-4xl font-bold mt-2">Activities</h2>
            <p class="text-gray-400 mt-2">All US$5 per person</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($activities as $activity)
            <div class="bg-gray-800 rounded-2xl overflow-hidden hover:bg-gray-750 transition-colors">
                {{-- Activity image based on type --}}
                @if($activity->icon === 'users')
                <img src="{{ asset('images/LEO09125.jpeg') }}" alt="{{ $activity->name }}"
                     class="w-full h-48 object-cover">
                @elseif($activity->icon === 'waves')
                <img src="{{ asset('images/LEO09134.jpeg') }}" alt="{{ $activity->name }}"
                     class="w-full h-48 object-cover">
                @else
                <img src="{{ asset('images/LEO09131.jpeg') }}" alt="{{ $activity->name }}"
                     class="w-full h-48 object-cover">
                @endif
                <div class="p-6">
                    <h3 class="font-semibold text-lg mb-1">{{ $activity->name }}</h3>
                    <p class="text-earth-300 font-bold mb-2">US${{ number_format($activity->cost_per_person, 2) }}/person</p>
                    <p class="text-gray-400 text-sm">{{ $activity->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── ENTRANCE / ATMOSPHERE STRIP ─────────────────────────────── --}}
<section class="relative h-96 overflow-hidden">
    <img src="{{ asset('images/LEO09195.jpeg') }}" alt="Eve Mountain Campsite entrance"
         class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-black/50 flex items-center justify-center text-center px-4">
        <div>
            <h2 class="font-display text-3xl md:text-5xl font-bold text-white mb-4 drop-shadow">
                Ready to book your retreat?
            </h2>
            <p class="text-gray-200 max-w-lg mx-auto mb-8">Tell us your dates and group size — get an instant quote in minutes.</p>
            <a href="{{ route('booking.create') }}"
               class="bg-white text-forest-700 hover:bg-earth-50 font-bold px-10 py-4 rounded-full transition-colors inline-block shadow-lg">
                Book Now — Free to Enquire
            </a>
        </div>
    </div>
</section>

@endsection