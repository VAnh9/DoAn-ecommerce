<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\FlashSaleController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\UserAddressController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\UserProfileController;
use App\Http\Controllers\Frontend\CheckOutController;
use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\ProductTrackController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\UserOrderController;
use App\Http\Controllers\Frontend\UserVendorRequestController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


/** Flash sale route */
Route::get('flash-sale', [FlashSaleController::class, 'index'])->name('flash-sale');

/** Product route */
Route::get('products', [ProductController::class, 'productsIndex'])->name('products.index');
Route::get('change-product-format-view', [ProductController::class, 'changeProductFormatView'])->name('change-product-format-view');

/** Product detail route */
Route::get('product-detail/{slug}', [ProductController::class, 'showProduct'])->name('product-detail');

/**  Cart routes */
Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('cart-details', [CartController::class, 'showCartDetails'])->name('cart-details');
Route::post('cart/update-quantity',[CartController::class, 'updateProductQuantity'])->name('cart.update-quantity');
Route::delete('clear-cart',[CartController::class, 'clearCart'])->name('clear-cart');
Route::delete('cart/remove-product/{rowId}',[CartController::class, 'removeProduct'])->name('cart.remove-product');
Route::get('cart-count', [CartController::class, 'getCartCount'])->name('cart-count');
Route::get('cart-products', [CartController::class, 'getCartProducts'])->name('cart-products');
Route::get('cart/sidebar-product-total', [CartController::class, 'getCartTotalPrice'])->name('cart.sidebar-product-total');
Route::get('apply-coupon', [CartController::class, 'applyCoupon'])->name('apply-coupon');
Route::get('coupon-calculation', [CartController::class, 'calculateCouponDiscount'])->name('coupon-calculation');

/** Newsletter */
Route::post('newsletter-request', [NewsletterController::class, 'requestNewsletter'])->name('newsletter-request');
Route::get('newsletter-verify/{token}', [NewsletterController::class, 'verifyNewsletterEmail'])->name('newsletter-verify');

/** Vendor page routes */
Route::get('vendors', [HomeController::class, 'showVendorPage'])->name('vendor.index');
Route::get('vendor-product/{id}', [HomeController::class, 'showVendorProductsPage'])->name('vendor.product-detail-page');

/** About page routes */
Route::get('about', [PageController::class, 'about'])->name('about');

/** terms and conditions page routes */
Route::get('terms-and-conditions', [PageController::class, 'termsAndConditions'])->name('terms-and-conditions');

/** contact routes */
Route::get('contact', [PageController::class, 'contact'])->name('contact');
Route::post('contact', [PageController::class, 'handleContactForm'])->name('handle-contact-form');

/** Product Track routes */
Route::get('tracking', [ProductTrackController::class, 'index'])->name('product-tracking.index');

/** Blog detail routes */
Route::get('blog/{slug}', [BlogController::class, 'index'])->name('blog.index');

/** Blog routes */
Route::get('blogs', [BlogController::class, 'getAllBlogs'])->name('blogs.index');

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'user', 'as' => 'user.'], function() {
    Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [UserProfileController::class, 'index'])->name('profile');
    Route::put('profile', [UserProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('profile', [UserProfileController::class, 'updatePassword'])->name('profile.update.password');

    /** User Address routes */
    Route::resource('address', UserAddressController::class);

    /** Check out routes */
    Route::get('checkout', [CheckOutController::class, 'index'])->name('checkout');
    Route::post('checkout/address-create', [CheckOutController::class, 'createAddress'])->name('checkout.address-create');
    Route::post('checkout/form-submit', [CheckOutController::class, 'checkOutFormSubmit'])->name('checkout.form-submit');

    /** Payment routes */
    Route::get('payment', [PaymentController::class, 'index'])->name('payment');
    Route::get('payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');

    /** Paypal routes */
    Route::get('paypal/payment', [PaymentController::class, 'payWithPaypal'])->name('paypal.payment');
    Route::get('paypal/success', [PaymentController::class, 'paypalSuccess'])->name('paypal.success');
    Route::get('paypal/cancel', [PaymentController::class, 'paypalCancel'])->name('paypal.cancel');

    /** Stripe routes */
    Route::get('stripe/payment', [PaymentController::class, 'payWithStripe'])->name('stripe.payment');

    /** COD routes */
    Route::get('cod/payment', [PaymentController::class, 'payWithCod'])->name('cod.payment');

    /** Order routes */
    Route::get('orders', [UserOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/show/{id}', [UserOrderController::class, 'show'])->name('orders.show');

    /** Wishlist routes */
    Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('wishlist/add-product', [WishlistController::class, 'addToWishlist'])->name('wishlist.store');
    Route::delete('wishlist/remove-product', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.destroy');

    /** product review routes */
    Route::post('review', [ReviewController::class, 'postReview'])->name('review.create');
    Route::get('reviews', [ReviewController::class, 'index'])->name('review.index');
    Route::get('review/image-gallery/{id}', [ReviewController::class, 'getImageGallery'])->name('review.image-gallery');

    /** Request to vendor routes */
    Route::get('vendor-request', [UserVendorRequestController::class, 'index'])->name('vendor-request.index');
    Route::post('vendor-request', [UserVendorRequestController::class, 'store'])->name('vendor-request.store');

    /** Blog comment routes */
    Route::post('blog-comment', [BlogController::class, 'comment'])->name('blog-comment');
});

