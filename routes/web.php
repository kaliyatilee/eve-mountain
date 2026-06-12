<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\RatesController;
use Illuminate\Support\Facades\Route;

// ─────────────────────────────────────────
// SEO
// ─────────────────────────────────────────
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// ─────────────────────────────────────────
// Public routes
// ─────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/facilities', [HomeController::class, 'facilities'])->name('facilities');
Route::get('/activities', [HomeController::class, 'activities'])->name('activities');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'sendContact'])->name('contact.send');

// Booking
Route::get('/book', [BookingController::class, 'create'])->name('booking.create');
Route::post('/book', [BookingController::class, 'store'])->name('booking.store');
Route::post('/book/quote', [BookingController::class, 'quote'])->name('booking.quote');
Route::get('/booking/confirmation/{reference}', [BookingController::class, 'confirmation'])->name('booking.confirmation');

// ─────────────────────────────────────────
// Admin auth
// ─────────────────────────────────────────
Route::get('/admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

// ─────────────────────────────────────────
// Admin protected routes
// ─────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Bookings
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/confirm', [AdminBookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
    Route::patch('/bookings/{booking}/notes', [AdminBookingController::class, 'updateNotes'])->name('bookings.notes');

    // Gallery
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::patch('/gallery/{galleryImage}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/gallery/{galleryImage}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
    Route::post('/gallery/reorder', [GalleryController::class, 'reorder'])->name('gallery.reorder');

    // Rates
    Route::get('/rates', [RatesController::class, 'index'])->name('rates.index');
    Route::patch('/rates/facility/{facility}', [RatesController::class, 'updateFacility'])->name('rates.facility');
    Route::patch('/rates/activity/{activity}', [RatesController::class, 'updateActivity'])->name('rates.activity');
});