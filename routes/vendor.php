<?php

use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\VendorMessageController;
use App\Http\Controllers\Backend\VendorOrderController;
use App\Http\Controllers\Backend\VendorProductAdditionalInformationController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Backend\VendorProductImageGalleryController;
use App\Http\Controllers\Backend\VendorProductReviewController;
use App\Http\Controllers\Backend\VendorProductVariantController;
use App\Http\Controllers\Backend\VendorProductVariantItemController;
use App\Http\Controllers\Backend\VendorProfileController;
use App\Http\Controllers\Backend\VendorShopProfileController;
use App\Http\Controllers\Backend\VendorWithdrawController;
use Illuminate\Support\Facades\Route;


/** Vendor Routes */

Route::get('dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
Route::get('profile', [VendorProfileController::class, 'index'])->name('profile');
Route::put('profile', [VendorProfileController::class, 'updateProfile'])->name('profile.update');
Route::post('profile', [VendorProfileController::class, 'updatePassword'])->name('profile.update.password');

/** Vendor Shop Profile routes */
Route::resource('shop-profile', VendorShopProfileController::class);

/** Product routes */
Route::get('product/get-subcategories', [VendorProductController::class, 'getSubCategories'])->name('product.get-subcategories');
Route::get('product/get-childcategories', [VendorProductController::class, 'getChildCategories'])->name('product.get-childcategories');
Route::put('product/change-status', [VendorProductController::class, 'changeStatus'])->name('product.change-status');
Route::resource('products', VendorProductController::class);


/** Prodcut Image Gallery route */

Route::resource('product-image-gallery', VendorProductImageGalleryController::class);

/** Product Variant route */
Route::put('product-variant/change-status', [VendorProductVariantController::class, 'changeStatus'])->name('product-variant.change-status');
Route::resource('product-variant', VendorProductVariantController::class);

/** Product Varitant Item route */

Route::get('product-variant-item/{productId}/{variantId}', [VendorProductVariantItemController::class, 'index'])->name('product-variant-item.index');

Route::get('product-variant-item-create/{variantId}', [VendorProductVariantItemController::class, 'create'])->name('product-variant-item.create');

Route::post('product-variant-item', [VendorProductVariantItemController::class, 'store'])->name('product-variant-item.store');

Route::get('product-variant-item-edit/{variantItemId}', [VendorProductVariantItemController::class, 'edit'])->name('product-variant-item.edit');

Route::put('product-variant-item/{variantItemId}', [VendorProductVariantItemController::class, 'update'])->name('product-variant-item.update');

Route::delete('product-variant-item/{variantItemId}', [VendorProductVariantItemController::class, 'destroy'])->name('product-variant-item.destroy');

Route::put('product-variant-item-status/change-status', [VendorProductVariantItemController::class, 'changeStatus'])->name('product-variant-item.change-status');

/** Product Additional Information */
Route::put('product-additional-information/change-status', [VendorProductAdditionalInformationController::class, 'changeStatus'])->name('product-additional-information.change-status');
Route::resource('product-additional-information', VendorProductAdditionalInformationController::class);

/** Orders route */
Route::get('orders', [VendorOrderController::class, 'index'])->name('orders');
Route::get('orders/show/{id}', [VendorOrderController::class, 'show'])->name('orders.show');
Route::put('orders/change-order-status/{id}', [VendorOrderController::class, 'changeOrderStatus'])->name('orders.change-order-status');

/** Product review routes */
Route::get('reviews', [VendorProductReviewController::class, 'index'])->name('reviews.index');
Route::get('review/image-gallery/{id}', [VendorProductReviewController::class, 'getImageGallery'])->name('review.image-gallery');

/** Withdraw routes */
Route::get('withdraw-request/{id}', [VendorWithdrawController::class, 'showDetailRequest'])->name('withdraw-request.show');
Route::resource('withdraw', VendorWithdrawController::class);

/** Message routes */
Route::get('messages', [VendorMessageController::class, 'index'])->name('messages.index');
Route::post('send-message', [VendorMessageController::class, 'sendMessage'])->name('send-message');
Route::get('get-messages', [VendorMessageController::class, 'getMessages'])->name('get-messages');
