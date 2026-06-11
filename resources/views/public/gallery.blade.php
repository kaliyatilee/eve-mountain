@extends('layouts.app')
@section('title', 'Gallery – Eve Mountain Campsite')
@section('description', 'Photo gallery of Eve Mountain Campsite Zimbabwe. See our facilities, dormitories, outdoor areas and activities.')

@push('styles')
<style>
    .gallery-item { cursor: pointer; overflow: hidden; }
    .gallery-item img { transition: transform .5s ease; display: block; width: 100%; height: 100%; object-fit: cover; }
    .gallery-item:hover img { transform: scale(1.06); }

    /* Lightbox */
    #lightbox { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.95); z-index: 9999; }
    #lightbox.open { display: flex; align-items: center; justify-content: center; }
    #lightbox-img { max-width: 90vw; max-height: 88vh; object-fit: contain; border-radius: 8px; }

    /* Category filter active */
    .filter-btn.active { background: #1a7849; color: white; border-color: #1a7849; }
</style>
@endpush

@section('content')

{{-- ── HERO STRIP ───────────────────────────────────────────────── --}}
<div class="relative h-64 overflow-hidden">
    <img src="{{ asset('images/LEO09042.jpeg') }}" alt="Eve Mountain Campsite"
         class="w-full h-full object-cover object-center">
    <div class="absolute inset-0 bg-black/50 flex items-end">
        <div class="max-w-6xl mx-auto px-4 pb-8 w-full">
            <p class="text-earth-300 text-xs font-semibold tracking-widest uppercase mb-1">By Marcaz Photography</p>
            <h1 class="font-display text-4xl md:text-5xl font-bold text-white">Photo Gallery</h1>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 py-12">

    {{-- ── CATEGORY FILTERS ──────────────────────────────────────── --}}
    <div class="flex flex-wrap gap-2 mb-10 justify-center" id="filters">
        <button onclick="filter('all')" class="filter-btn active px-5 py-2 rounded-full text-sm font-medium border border-gray-300 transition-all">
            All Photos
        </button>
        @foreach(['general'=>'Overview','facilities'=>'Facilities','dorms'=>'Dormitories','outdoor'=>'Outdoor','activities'=>'Activities'] as $cat => $label)
        <button onclick="filter('{{ $cat }}')" class="filter-btn px-5 py-2 rounded-full text-sm font-medium border border-gray-300 text-gray-600 transition-all hover:border-forest-500 hover:text-forest-600">
            {{ $label }}
        </button>
        @endforeach
    </div>

    {{-- ── PHOTO GRID ────────────────────────────────────────────── --}}
    @if($images->isEmpty())
        <p class="text-center text-gray-400 py-20">Photos coming soon.</p>
    @else
        <div class="columns-2 md:columns-3 lg:columns-4 gap-3 space-y-3" id="gallery-grid">
            @foreach($images->flatten() as $image)
            <div class="gallery-item break-inside-avoid rounded-xl mb-3"
                 data-category="{{ $image->category }}"
                 onclick="openLightbox('{{ $image->url }}', '{{ e($image->caption) }}')">
                <img src="{{ $image->thumb_url }}"
                     alt="{{ $image->caption ?? 'Eve Mountain Campsite' }}"
                     loading="lazy"
                     class="rounded-xl">
                @if($image->caption)
                <div class="px-2 py-1.5 text-xs text-gray-500">{{ $image->caption }}</div>
                @endif
            </div>
            @endforeach
        </div>
    @endif

    {{-- ── FALLBACK: show static images if DB gallery is empty ───── --}}
    @if($images->isEmpty())
    <div class="columns-2 md:columns-3 lg:columns-4 gap-3 space-y-3">
        @foreach([
            ['LEO09019','Eve Mountain Campsite at sunset','facilities'],
            ['LEO09029','Outdoor seating under the trees','general'],
            ['LEO09040','Main building at golden hour','facilities'],
            ['LEO09042','Buildings nestled in trees','facilities'],
            ['LEO09058','Dormitory bunk beds','dorms'],
            ['LEO09062','Dormitory interior','dorms'],
            ['LEO09074','Auditorium hall','facilities'],
            ['LEO09080','Conference space','facilities'],
            ['LEO09087','Projector in auditorium','facilities'],
            ['LEO09118','Outdoor camping area','outdoor'],
            ['LEO09119','Natural bush setting','outdoor'],
            ['LEO09125','Teambuilding course','activities'],
            ['LEO09131','Obstacle course','activities'],
            ['LEO09165','African bush landscape','outdoor'],
            ['LEO09190','Welcome to Eve Mountain','general'],
            ['LEO09195','Campsite entrance sign','general'],
            ['mahuuu','Dormitory block at dusk','general'],
        ] as [$file,$cap,$cat])
        <div class="gallery-item break-inside-avoid rounded-xl mb-3" data-category="{{ $cat }}"
             onclick="openLightbox('{{ asset('images/'.$file.'.jpeg') }}', '{{ $cap }}')">
            <img src="{{ asset('images/'.$file.'.jpeg') }}" alt="{{ $cap }}"
                 loading="lazy" class="rounded-xl">
            <div class="px-2 py-1.5 text-xs text-gray-500">{{ $cap }}</div>
        </div>
        @endforeach
    </div>
    @endif

</div>

{{-- ── BOOK CTA ─────────────────────────────────────────────────── --}}
<section class="bg-forest-700 text-white py-14 text-center px-4 mt-8">
    <h2 class="font-display text-2xl md:text-3xl font-bold mb-3">Like what you see?</h2>
    <p class="text-forest-100 max-w-md mx-auto mb-7 text-sm">Get in touch and let us host your group at Eve Mountain.</p>
    <a href="{{ route('booking.create') }}"
       class="bg-white text-forest-700 hover:bg-earth-50 font-bold px-10 py-3.5 rounded-full transition-colors inline-block">
        Book Your Stay
    </a>
</section>

{{-- ── LIGHTBOX ─────────────────────────────────────────────────── --}}
<div id="lightbox" role="dialog">
    <button onclick="closeLightbox()"
            class="absolute top-4 right-5 text-white text-4xl font-thin leading-none z-10 hover:text-gray-300 transition-colors"
            aria-label="Close">×</button>
    <button onclick="closeLightbox()" class="absolute inset-0 w-full h-full" aria-label="Close"></button>
    <div class="relative z-10 text-center px-4">
        <img id="lightbox-img" src="" alt="" class="rounded-lg shadow-2xl">
        <p id="lightbox-caption" class="text-gray-300 text-sm mt-3 max-w-lg mx-auto"></p>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openLightbox(url, caption) {
    document.getElementById('lightbox-img').src = url;
    document.getElementById('lightbox-caption').textContent = caption;
    document.getElementById('lightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('lightbox').classList.remove('open');
    document.getElementById('lightbox-img').src = '';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => e.key === 'Escape' && closeLightbox());

function filter(cat) {
    // Update button states
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    event.target.classList.add('active');

    // Show/hide items
    document.querySelectorAll('.gallery-item').forEach(item => {
        const match = cat === 'all' || item.dataset.category === cat;
        item.style.display = match ? '' : 'none';
    });
}
</script>
@endpush