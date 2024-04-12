<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AdminVendorProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\FlashSaleController;
use App\Http\Controllers\Backend\FooterGridThreeController;
use App\Http\Controllers\Backend\FooterGridTwoController;
use App\Http\Controllers\Backend\FooterInfoController;
use App\Http\Controllers\Backend\FooterSocialLinkController;
use App\Http\Controllers\Backend\HomePageSettingController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\PaymentSettingController;
use App\Http\Controllers\Backend\PaypalSettingController;
use App\Http\Controllers\Backend\ProductAdditionalInformationController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductImageGalleryController;
use App\Http\Controllers\Backend\ProductVariantController;
use App\Http\Controllers\Backend\ProductVariantItemController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SellerProductController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\ShippingRuleController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\StripeSettingController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\TransactionController;
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

/** Child Category route */
Route::put('child-category/change-status', [ChildCategoryController::class, 'changeStatus'])->name('child-category.change-status');
Route::get('get-subcategories', [ChildCategoryController::class, 'getSubCategories'])->name('get-subcategories');
Route::resource('child-category', ChildCategoryController::class);

/** Brand route */
Route::put('brand/change-status', [BrandController::class, 'changeStatus'])->name('brand.change-status');
Route::resource('brand', BrandController::class);

/** Vendor Profile route */

Route::resource('vendor-profile', AdminVendorProfileController::class);

/** Product route */
Route::get('product/get-childcategories', [ProductController::class, 'getChildCategories'])->name('product.get-childcategories');
Route::get('product/get-subcategories', [ProductController::class, 'getSubCategories'])->name('product.get-subcategories');
Route::put('product/change-status', [ProductController::class, 'changeStatus'])->name('product.change-status');
Route::resource('product', ProductController::class);

/** Prodcut Image Gallery route */

Route::resource('product-image-gallery', ProductImageGalleryController::class);

/** Product Variant route */
Route::put('product-variant/change-status', [ProductVariantController::class, 'changeStatus'])->name('product-variant.change-status');
Route::resource('product-variant', ProductVariantController::class);

/** Product Varitant Item route */

Route::get('product-variant-item/{productId}/{variantId}', [ProductVariantItemController::class, 'index'])->name('product-variant-item.index');

Route::get('product-variant-item-create/{variantId}', [ProductVariantItemController::class, 'create'])->name('product-variant-item.create');

Route::post('product-variant-item', [ProductVariantItemController::class, 'store'])->name('product-variant-item.store');

Route::get('product-variant-item-edit/{variantItemId}', [ProductVariantItemController::class, 'edit'])->name('product-variant-item.edit');

Route::put('product-variant-item/{variantItemId}', [ProductVariantItemController::class, 'update'])->name('product-variant-item.update');

Route::delete('product-variant-item/{variantItemId}', [ProductVariantItemController::class, 'destroy'])->name('product-variant-item.destroy');

Route::put('product-variant-item-status/change-status', [ProductVariantItemController::class, 'changeStatus'])->name('product-variant-item.change-status');

/** Seller's Products route */

Route::get('seller-products', [SellerProductController::class, 'index'])->name('seller-products.index');
Route::get('seller-pending-products', [SellerProductController::class, 'showPendingProducts'])->name('seller-pending-products.index');
Route::put('change-approve-status', [SellerProductController::class, 'changeApproveStatus'])->name('change-approve-status');

/** Flash Sale routes */
Route::get('flash-sale', [FlashSaleController::class, 'index'])->name('flash-sale.index');

Route::put('flash-sale', [FlashSaleController::class, 'update'])->name('flash-sale.update');

Route::post('flash-sale/add-product', [FlashSaleController::class, 'addProduct'])->name('flash-sale.add-product');

Route::put('flash-sale/show-at-home/status-change', [FlashSaleController::class, 'changeShowAtHomeStatus'])->name('flash-sale.show-at-home.change-status');

Route::put('flash-sale-status', [FlashSaleController::class, 'changeStatus'])->name('flash-sale-status');

Route::delete('flash-sale/{id}', [FlashSaleController::class, 'destroy'])->name('flash-sale.destroy');


/** General Setting routes */
Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
Route::get('general-settings/currency-symbol', [SettingController::class, 'getCurrencySymbol'])->name('general-settings.currency-symbol');
Route::put('general-settings/update', [SettingController::class, 'updateGeneralSettings'])->name('general-settings.update');

/** Coupon routes */
Route::put('coupons/change-status', [CouponController::class, 'changeStatus'])->name('coupons.change-status');
Route::resource('coupons', CouponController::class);

/** Shipping Rule routes */
Route::put('shipping-rule/change-status', [ShippingRuleController::class, 'changeStatus'])->name('shipping-rule.change-status');
Route::resource('shipping-rule', ShippingRuleController::class);

/** Product Additional Information routes  */
Route::put('product-additional-information/change-status', [ProductAdditionalInformationController::class, 'changeStatus'])->name('product-additional-information.change-status');
Route::resource('product-additional-information', ProductAdditionalInformationController::class);


/** Payment settings routes */
Route::get('payment-settings', [PaymentSettingController::class, 'index'])->name('payment-settings.index');

/** Paypal settings routes */
Route::resource('paypal-settings', PaypalSettingController::class);

/** Stripe settings routes */
Route::put('stripe-settings/{id}', [StripeSettingController::class, 'update'])->name('stripe-settings.update');

/** Orders routes */
Route::put('order/change-order-status', [OrderController::class, 'changeOrderStatus'])->name('order.change-order-status');
Route::put('order/change-payment-status', [OrderController::class, 'changePaymentStatus'])->name('order.change-payment-status');
Route::get('pending-orders', [OrderController::class, 'getPendingOrders'])->name('pending-orders.index');
Route::get('processed-orders', [OrderController::class, 'getProcessedOrders'])->name('processed-orders.index');
Route::get('dropped-off-orders', [OrderController::class, 'getDroppedOffOrders'])->name('dropped-off-orders.index');
Route::get('shipped-orders', [OrderController::class, 'getShippedOrders'])->name('shipped-orders.index');
Route::get('out-for-delivery-orders', [OrderController::class, 'getOutForDeliveryOrders'])->name('out-for-delivery-orders.index');
Route::get('delivered-orders', [OrderController::class, 'getDeliveredOrders'])->name('delivered-orders.index');
Route::get('canceled-orders', [OrderController::class, 'getCanceledOrders'])->name('canceled-orders.index');
Route::resource('orders', OrderController::class);

/** order transaction route */
Route::get('transaction', [TransactionController::class, 'index'])->name('transaction');

/** Home Page settings routes */
Route::get('home-page-setting', [HomePageSettingController::class, 'index'])->name('home-page-setting');
Route::put('popular-category-section', [HomePageSettingController::class, 'updatePopularCategorySection'])->name('popular-category-section');
Route::put('product-slider-section-one', [HomePageSettingController::class, 'updateProductSliderOne'])->name('product-slider-section-one');
Route::put('product-slider-section-two', [HomePageSettingController::class, 'updateProductSliderTwo'])->name('product-slider-section-two');
Route::put('product-slider-section-three', [HomePageSettingController::class, 'updateProductSliderThree'])->name('product-slider-section-three');

/** Footer routes */
Route::resource('footer-info', FooterInfoController::class);

Route::put('footer-social-links/change-status', [FooterSocialLinkController::class, 'changeStatus'])->name('footer-social-links.change-status');
Route::resource('footer-social-links', FooterSocialLinkController::class);

Route::put('footer-grid-two/change-status', [FooterGridTwoController::class, 'changeStatus'])->name('footer-grid-two.change-status');
Route::put('footer-grid-two/change-title', [FooterGridTwoController::class, 'changeTitle'])->name('footer-grid-two.change-title');
Route::resource('footer-grid-two', FooterGridTwoController::class);

Route::put('footer-grid-three/change-status', [FooterGridThreeController::class, 'changeStatus'])->name('footer-grid-three.change-status');
Route::put('footer-grid-three/change-title', [FooterGridThreeController::class, 'changeTitle'])->name('footer-grid-three.change-title');
Route::resource('footer-grid-three', FooterGridThreeController::class);

