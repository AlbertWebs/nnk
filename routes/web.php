<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmailHistoryController;

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
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/membership', [HomeController::class, 'membership'])->name('membership');
Route::post('/membership/apply', [HomeController::class, 'store'])->name('membership.post');




Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    
    // Users CRUD
    Route::resource('users', App\Http\Controllers\UserController::class);
    
    // Services CRUD
    Route::resource('services', App\Http\Controllers\ServiceController::class);
    
    // Gallery CRUD
    Route::resource('gallery', App\Http\Controllers\GalleryController::class);
    
    // Gallery upload for dropzone (keep for backward compatibility)
    Route::post('/gallery/upload', [App\Http\Controllers\GalleryController::class, 'store'])->name('gallery.upload');
    
    // Mailing List
    Route::get('/mailing-list', fn () => view('admin.mailing-list'))->name('mailing-list');
    Route::get('/mailing-list/send-email', fn () => view('admin.send-email'))->name('mailing-list.send-email');
    Route::get('/mailing-list/mapping', fn () => view('admin.member-groups-mapping'))->name('mailing-list.mapping');
    Route::get('/mailing-list/history', [App\Http\Controllers\EmailHistoryController::class, 'index'])->name('mailing-list.history');
    Route::get('/mailing-list/history/{id}', [App\Http\Controllers\EmailHistoryController::class, 'show'])->name('mailing-list.history.detail');
    
    // Resources
    Route::get('/resources/gallery', [App\Http\Controllers\GalleryController::class, 'resources'])->name('resources.gallery');
});

Route::middleware(['auth', 'role:officer'])->group(function () {
    Route::get('/officer/dashboard', fn () => view('officer.dashboard'));
});

Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/member/dashboard', fn () => view('member.dashboard'));
});