<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/login', 'login')->name('login');

if (app()->environment(['local', 'staging'])) {
    Volt::route('/register', 'register');
}

Route::get('/logout', function () {
    auth('web')->logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})
    ->name('general.logout');

Route::middleware([])->group(function () {
    Volt::route('/', 'monitors.index')->name('index');
    Volt::route('/monitors', 'monitors.index')->name('monitors.index');
    Volt::route('/post-mortems', 'post-mortems.index')->name('post-mortems.index');
    Volt::route('/incidents', 'incidents.index')->name('incidents.index');
    Volt::route('/alert-logs', 'alert-logs.index')->name('alert-logs.index');
    Volt::route('/activity_logs', 'activity-logs.index')->name('activity-logs.index');
});

