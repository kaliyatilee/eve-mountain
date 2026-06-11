<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Mark past confirmed bookings as completed daily
Schedule::call(function () {
    \App\Models\Booking::where('status', 'confirmed')
        ->where('departure_date', '<', today())
        ->update(['status' => 'completed']);
})->daily();
