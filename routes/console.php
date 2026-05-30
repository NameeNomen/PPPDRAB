<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Schedule;
use App\Models\Notification;

// Ini tugas si pemulung: Hapus notif yang udah dibaca > 3 hari
Schedule::call(function () {
    Notification::where('is_read', true)
        ->where('read_at', '<', now()->subDays(3))
        ->delete();
})->daily(); // Jalan tiap hari otomatis

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
