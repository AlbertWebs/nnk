<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EmailController;

// Mailing List API Routes
Route::prefix('mailing-list')->name('mailing-list.')->group(function () {
    // Groups
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/{id}', [GroupController::class, 'show'])->name('groups.show');
    Route::put('/groups/{id}', [GroupController::class, 'update'])->name('groups.update');
    Route::delete('/groups/{id}', [GroupController::class, 'destroy'])->name('groups.destroy');
    
    // Add/Remove users from groups
    Route::post('/groups/{groupId}/add-user/{userId}', [GroupController::class, 'addUser'])->name('groups.add-user');
    Route::delete('/groups/{groupId}/remove-user/{userId}', [GroupController::class, 'removeUser'])->name('groups.remove-user');
    
    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    
    // Send emails
    Route::post('/groups/{groupId}/send-email', [EmailController::class, 'sendToGroup'])->name('groups.send-email');
});

