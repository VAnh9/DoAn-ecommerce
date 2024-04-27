<?php

use App\Http\Controllers\Backend\ShipperController;
use App\Http\Controllers\Backend\ShipperMessageController;
use App\Http\Controllers\Backend\ShipperProfileController;
use Illuminate\Support\Facades\Route;



/** Shipper routes */
Route::get('dashboard', [ShipperController::class, 'dashboard'])->name('dashboard');

/** Profile routes */
Route::get('profile', [ShipperProfileController::class, 'index'])->name('profile');
Route::put('profile', [ShipperProfileController::class, 'updateProfile'])->name('profile.update');
Route::post('profile', [ShipperProfileController::class, 'updatePassword'])->name('profile.update.password');

/** Message routes */
Route::get('messages', [ShipperMessageController::class, 'index'])->name('messages.index');
Route::post('send-message', [ShipperMessageController::class, 'sendMessage'])->name('send-message');
Route::get('get-messages', [ShipperMessageController::class, 'getMessages'])->name('get-messages');
