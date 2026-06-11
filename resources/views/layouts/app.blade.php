<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Eve Mountain Campsite') | Eve Mountain</title>
    <meta name="description" content="@yield('description', 'Eve Mountain Campsite – Group retreats, teambuilding, churches and NGOs.')">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        forest: { 50:'#f0faf4',100:'#dcf3e4',200:'#b5e5c5',300:'#7ecfa1',400:'#46b478',500:'#28975e',600:'#1a7849',700:'#156039',800:'#124f30',900:'#0f4128' },
                        earth:  { 50:'#fdf8f0',100:'#f9eedc',200:'#f1d9b0',300:'#e6bf7c',400:'#d89c44',500:'#c47e28',600:'#a3641e',700:'#834d19',800:'#6b3e18',900:'#583318' },
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
        html { scroll-behavior: smooth; }
    </style>
    @stack('styles')
</head>
<body class="bg-white text-gray-900">

    {{-- ══════════════════════════════════════════════
         TOP BAR — contact info + social icons
    ══════════════════════════════════════════════ --}}
    <div class="bg-forest-800 text-forest-100 text-xs">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-9 flex items-center justify-between gap-4">

            {{-- Left: address + phone --}}
            <div class="flex items-center gap-5 overflow-hidden">
                {{-- Phone --}}
                <a href="tel:+26377XXXXXXX"
                   class="flex items-center gap-1.5 hover:text-white transition-colors whitespace-nowrap">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    +263 77 XXX XXXX
                </a>

                {{-- Email --}}
                <a href="mailto:info@evemountain.com"
                   class="hidden sm:flex items-center gap-1.5 hover:text-white transition-colors whitespace-nowrap">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    info@evemountain.com
                </a>

                {{-- Address --}}
                <span class="hidden lg:flex items-center gap-1.5 whitespace-nowrap">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Eve Mountain, Zimbabwe
                </span>
            </div>

            {{-- Right: social icons --}}
            <div class="flex items-center gap-1 flex-shrink-0">
                {{-- Facebook — TODO: replace href="#" with https://facebook.com/evemountain --}}
                <a href="#"
                   aria-label="Facebook"
                   target="_blank" rel="noopener"
                   class="w-7 h-7 flex items-center justify-center rounded hover:bg-forest-700 transition-colors group">
                    <svg class="w-3.5 h-3.5 text-forest-200 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                    </svg>
                </a>

                {{-- Twitter/X — TODO: replace href="#" with https://twitter.com/evemountain --}}
                <a href="#"
                   aria-label="Twitter / X"
                   target="_blank" rel="noopener"
                   class="w-7 h-7 flex items-center justify-center rounded hover:bg-forest-700 transition-colors group">
                    <svg class="w-3.5 h-3.5 text-forest-200 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                </a>

                {{-- Instagram — TODO: replace href="#" with https://instagram.com/evemountain --}}
                <a href="#"
                   aria-label="Instagram"
                   target="_blank" rel="noopener"
                   class="w-7 h-7 flex items-center justify-center rounded hover:bg-forest-700 transition-colors group">
                    <svg class="w-3.5 h-3.5 text-forest-200 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                    </svg>
                </a>

                {{-- WhatsApp --}}
                {{-- TODO: replace 26377XXXXXXX with your actual WhatsApp number --}}
                <a href="https://wa.me/26377XXXXXXX"
                   aria-label="WhatsApp"
                   target="_blank" rel="noopener"
                   class="w-7 h-7 flex items-center justify-center rounded hover:bg-forest-700 transition-colors group">
                    <svg class="w-3.5 h-3.5 text-forest-200 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </a>
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════════════════════
         MAIN NAVIGATION
    ══════════════════════════════════════════════ --}}
    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-gray-100 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-16">

                <a href="{{ route('home') }}" class="flex-shrink-0">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="Eve Mountain Campsite"
                         style="height:54px; width:auto;">
                </a>

                <div class="hidden md:flex items-center gap-7">
                    <a href="{{ route('home') }}"
                       class="text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-forest-600' : 'text-gray-700 hover:text-forest-600' }}">Home</a>
                    <a href="{{ route('facilities') }}"
                       class="text-sm font-medium transition-colors {{ request()->routeIs('facilities') ? 'text-forest-600' : 'text-gray-700 hover:text-forest-600' }}">Facilities</a>
                    <a href="{{ route('activities') }}"
                       class="text-sm font-medium transition-colors {{ request()->routeIs('activities') ? 'text-forest-600' : 'text-gray-700 hover:text-forest-600' }}">Activities</a>
                    <a href="{{ route('gallery') }}"
                       class="text-sm font-medium transition-colors {{ request()->routeIs('gallery') ? 'text-forest-600' : 'text-gray-700 hover:text-forest-600' }}">Gallery</a>
                    <a href="{{ route('contact') }}"
                       class="text-sm font-medium transition-colors {{ request()->routeIs('contact') ? 'text-forest-600' : 'text-gray-700 hover:text-forest-600' }}">Contact</a>
                    <a href="{{ route('booking.create') }}"
                       class="bg-forest-600 hover:bg-forest-700 text-white text-sm font-medium px-5 py-2 rounded-full transition-colors">Book Now</a>
                </div>

                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            {{-- Mobile menu --}}
            <div id="mobile-menu" class="md:hidden hidden pb-4 border-t border-gray-100 mt-1">
                <div class="flex flex-col gap-1 pt-3">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-forest-600 text-sm font-medium px-2 py-2">Home</a>
                    <a href="{{ route('facilities') }}" class="text-gray-700 hover:text-forest-600 text-sm font-medium px-2 py-2">Facilities</a>
                    <a href="{{ route('activities') }}" class="text-gray-700 hover:text-forest-600 text-sm font-medium px-2 py-2">Activities</a>
                    <a href="{{ route('gallery') }}" class="text-gray-700 hover:text-forest-600 text-sm font-medium px-2 py-2">Gallery</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-forest-600 text-sm font-medium px-2 py-2">Contact</a>
                    <a href="{{ route('booking.create') }}" class="bg-forest-600 text-white text-sm font-medium px-5 py-2 rounded-full w-fit mt-2">Book Now</a>
                    {{-- Mobile social links --}}
                    <div class="flex items-center gap-3 px-2 pt-3 border-t border-gray-100 mt-2">
                        <a href="#" class="text-gray-400 hover:text-forest-600"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg></a>
                        <a href="#" class="text-gray-400 hover:text-forest-600"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                        <a href="#" class="text-gray-400 hover:text-forest-600"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
                        <a href="https://wa.me/26377XXXXXXX" class="text-gray-400 hover:text-forest-600"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg></a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- ══════════════════════════════════════════════
         PAGE CONTENT
    ══════════════════════════════════════════════ --}}
    <main>
        @if(session('success'))
            <div class="bg-forest-50 border-l-4 border-forest-500 text-forest-800 px-6 py-4 text-sm">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 px-6 py-4 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </main>

    {{-- ══════════════════════════════════════════════
         FOOTER
    ══════════════════════════════════════════════ --}}
    <footer class="bg-gray-900 text-gray-300 mt-20">

        {{-- Social bar --}}
        <div class="border-b border-gray-800">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between flex-wrap gap-3">
                <p class="text-sm text-gray-400">Follow us for updates &amp; inspiration</p>
                <div class="flex items-center gap-2">
                    <a href="#" aria-label="Facebook" target="_blank" rel="noopener"
                       class="w-9 h-9 rounded-full bg-gray-800 hover:bg-forest-700 flex items-center justify-center transition-colors group">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                    </a>
                    <a href="#" aria-label="Twitter" target="_blank" rel="noopener"
                       class="w-9 h-9 rounded-full bg-gray-800 hover:bg-forest-700 flex items-center justify-center transition-colors group">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="#" aria-label="Instagram" target="_blank" rel="noopener"
                       class="w-9 h-9 rounded-full bg-gray-800 hover:bg-forest-700 flex items-center justify-center transition-colors group">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    <a href="https://wa.me/26377XXXXXXX" aria-label="WhatsApp" target="_blank" rel="noopener"
                       class="w-9 h-9 rounded-full bg-gray-800 hover:bg-green-700 flex items-center justify-center transition-colors group">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Main footer --}}
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-14 grid grid-cols-1 md:grid-cols-3 gap-10">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Eve Mountain"
                     style="height:36px;width:auto;filter:brightness(0) invert(1);opacity:0.85;" class="mb-4">
                <p class="text-sm text-gray-400 leading-relaxed mb-5">A mountain retreat for churches, NGOs, companies and schools. Teambuilding, worship, conferences and adventure.</p>
                <div class="space-y-2 text-sm text-gray-400">
                    <a href="tel:+26377XXXXXXX" class="flex items-center gap-2 hover:text-white transition-colors">
                        <svg class="w-4 h-4 text-forest-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        +263 77 XXX XXXX
                    </a>
                    <a href="mailto:info@evemountain.com" class="flex items-center gap-2 hover:text-white transition-colors">
                        <svg class="w-4 h-4 text-forest-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        info@evemountain.com
                    </a>
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-forest-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Eve Mountain, Zimbabwe
                    </span>
                </div>
            </div>
            <div>
                <h4 class="text-white font-medium text-sm mb-3">Quick links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('facilities') }}" class="hover:text-white transition-colors">Facilities & Rates</a></li>
                    <li><a href="{{ route('activities') }}" class="hover:text-white transition-colors">Activities</a></li>
                    <li><a href="{{ route('gallery') }}" class="hover:text-white transition-colors">Gallery</a></li>
                    <li><a href="{{ route('booking.create') }}" class="hover:text-white transition-colors">Book a Stay</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact Us</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-medium text-sm mb-3">Group types</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li>⛪ Churches & Youth Groups</li>
                    <li>🤝 NGOs & Non-profits</li>
                    <li>🏢 Corporate Teambuilding</li>
                    <li>🎓 Schools & Colleges</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 py-4 text-center text-xs text-gray-500">
            © {{ date('Y') }} Eve Mountain Campsite. All rights reserved.
        </div>
    </footer>

    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
    @stack('scripts')
</body>
</html>