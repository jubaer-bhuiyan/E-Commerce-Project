<?php

use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\KycController;
use App\Http\Controllers\Frontend\ProductPageController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\StoreController;
use App\Http\Controllers\Frontend\VendorDashboardController;
use App\Http\Controllers\Frontend\VendorProductController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.home.index');
});


/** Products routes */
Route::get('/products', [ProductPageController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductPageController::class, 'show'])->name('products.show');

/** Contact Routes */
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

/** Custom Page Route */
Route::get('/page/{slug}', [HomeController::class, 'customPage'])->name('custom-page.index');

/** Vendor Routes */
Route::get('vendors', [VendorPageController::class, 'index'])->name('vendors.index');
Route::get('vendors/{vendor}', [VendorPageController::class, 'show'])->name('vendors.show');

/** Flash Sale Route */
Route::get('/flash-sales', [HomeController::class, 'flashSales'])->name('flash-sales.index');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'profileUpdate'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'passwordUpdate'])->name('password.update');

    // KYC routes
    Route::get('/kyc-verification', [KycController::class, 'Index'])->name('kyc.index');
    Route::post('/kyc-verification', [KycController::class, 'store'])->name('kyc.store');

    /** Cart Routes */
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/update-cart', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');
    Route::delete('/cart/coupon/remove', [CartController::class, 'destroyCoupon'])->name('cart.coupon.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/shipping-method/{id}', [CheckoutController::class, 'shippingMethod'])->name('checkout.shipping');
    Route::post('/billing-info', [CheckoutController::class, 'billingInfo'])->name('checkout.billinginfo.store');
 
});

// Vendor routes
Route::group(['prefix' => 'vendor', 'as' => 'vendor.', 'middleware' => ['auth', 'verified', 'user_role:vendor']], function () {
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');

    // Shop Profile routes
    Route::resource('store-profile', StoreController::class);

    /** Profile Routes */
    Route::get('/profile', [VendorProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [VendorProfileController::class, 'update'])->name('profile.update');

    Route::put('/profile-password', [VendorProfileController::class, 'updatePassword'])->name('profile-password.update');

    /** Shop Profile Routes */
    Route::resource('store-profile', StoreController::class);

    /** Product Routes */
    Route::get('/products', [VendorProductController::class, 'index'])->name('products.index');

    Route::get('/products/{type}/create', [VendorProductController::class, 'create'])->name('products.create');
    Route::post('/products/{type}/create', [VendorProductController::class, 'store'])->name('products.store');

    Route::get('/products/physical/{product}/edit', [VendorProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/physical/{product}/update', [VendorProductController::class, 'update'])->name('products.update');
    Route::post('/products/images/upload/{product}', [VendorProductController::class, 'uploadImages'])->name('products.images.upload');
    Route::delete('/products/images/{image}', [VendorProductController::class, 'destroyImage'])->name('products.images.destroy');
    Route::post('/products/images/reorder', [VendorProductController::class, 'imagesReorder'])->name('products.images.reorder');

    /** Product Attributes Routes */
    Route::post('/products/attributes/{product}/store', [VendorProductController::class, 'storeAttributes'])->name('products.attributes.store');
    Route::delete('/products/attributes/{product}/{attribute}', [VendorProductController::class, 'destroyAttribute'])->name('products.attributes.destroy');

    /** Product Variants Routes */
    Route::post('/products/variants/{product}/update', [VendorProductController::class, 'updateVariants'])->name('products.variants.update');

    /** Digital Product Routes */
    Route::get('/products/digital/{product}/edit', [VendorProductController::class, 'editDigitalProduct'])->name('digital-products.edit');
    Route::post('/products/digital/file-upload', [VendorProductController::class, 'uploadDigitalProductFile'])->name('digital-products.file.upload');
    Route::delete('/products/digital/{product}/{file}', [VendorProductController::class, 'destroyDigitalProductFile'])->name('digital-products.file.destroy');

    Route::delete('/products/{product}', [VendorProductController::class, 'destroy'])->name('products.destroy');
});



require __DIR__ . '/auth.php';
