<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use Illuminate\Support\Facades\Route;


/** Admin Routes */

Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

/** Profile route  */

Route::get('profile', [ProfileController::class, 'index'])->name('profile');

Route::post('profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');

Route::post('profile/update/password', [ProfileController::class, 'updatePassword'])->name('password.update');


/** Slider route */
Route::resource('slider', SliderController::class);

/** Category route */
Route::put('change-status', [CategoryController::class, 'changeStatus'])->name('category.change-status');
Route::resource('category', CategoryController::class);

/** Sub Category route */
Route::put('sub-category/change-status', [SubCategoryController::class, 'changeStatus'])->name('sub-category.change-status');
Route::resource('sub-category', SubCategoryController::class);
