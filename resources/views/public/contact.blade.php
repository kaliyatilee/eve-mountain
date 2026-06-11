@extends('layouts.app')
@section('title', 'Contact Us')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-16">
    <div class="text-center mb-12">
        <h1 class="font-display text-4xl font-bold text-gray-900">Get in Touch</h1>
        <p class="text-gray-500 mt-2">Have questions? We'd love to hear from you.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        {{-- Contact form --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-7 shadow-sm">
            <h2 class="font-semibold text-gray-900 mb-5">Send an enquiry</h2>
            <form method="POST" action="{{ route('contact.send') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Your name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-forest-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-forest-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone (optional)</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-forest-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Message</label>
                    <textarea name="message" rows="4" required
                              class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-forest-500 focus:border-transparent resize-none">{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="w-full bg-forest-600 hover:bg-forest-700 text-white font-semibold py-2.5 rounded-full text-sm transition-colors">
                    Send Message
                </button>
            </form>
        </div>

        {{-- Contact info --}}
        <div class="space-y-6">
            <div>
                <h2 class="font-semibold text-gray-900 mb-4">Contact information</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-forest-100 rounded-xl flex items-center justify-center flex-shrink-0">📧</div>
                        <div>
                            <div class="text-sm font-medium text-gray-700">Email</div>
                            <div class="text-sm text-gray-500">info@evemountain.co.zw</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-forest-100 rounded-xl flex items-center justify-center flex-shrink-0">📞</div>
                        <div>
                            <div class="text-sm font-medium text-gray-700">Phone / WhatsApp</div>
                            <div class="text-sm text-gray-500">+263 77 XXX XXXX</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-forest-100 rounded-xl flex items-center justify-center flex-shrink-0">📍</div>
                        <div>
                            <div class="text-sm font-medium text-gray-700">Location</div>
                            <div class="text-sm text-gray-500">Eve Mountain, Zimbabwe<br>Directions provided upon booking.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-forest-50 border border-forest-100 rounded-2xl p-5">
                <h3 class="font-semibold text-forest-800 mb-2">Ready to book?</h3>
                <p class="text-sm text-forest-700 mb-4">Use our online booking form to check availability, get an instant quote and submit your reservation.</p>
                <a href="{{ route('booking.create') }}" class="inline-block bg-forest-600 hover:bg-forest-700 text-white text-sm font-medium px-6 py-2 rounded-full transition-colors">
                    Book online →
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
