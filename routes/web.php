<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [HomeController::class, 'about'])->name('about');
Route::get('/the-team', [HomeController::class, 'team'])->name('team');
Route::get('/contact-us', [HomeController::class, 'contact'])->name('contact');
Route::get('/privacy-policy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms-and-conditions', [HomeController::class, 'terms'])->name('terms');
Route::get('/copyright-policy', [HomeController::class, 'copyright'])->name('copyright');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/services/{slung}', [HomeController::class, 'singleService'])->name('services.single');
Route::get('/join-us', [HomeController::class, 'joinUs'])->name('join-us');
Route::get('/downloads', [HomeController::class, 'downloads'])->name('downloads');
Route::get('/membership', [HomeController::class, 'membership'])->name('membership');




Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', fn () => view('admin.dashboard'));
});

Route::middleware(['auth', 'role:officer'])->group(function () {
    Route::get('/officer/dashboard', fn () => view('officer.dashboard'));
});

Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/member/dashboard', fn () => view('member.dashboard'));
});