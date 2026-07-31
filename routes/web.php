<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\GiftCardController;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/{slug}', [ProductController::class, 'show'])->name('show');
});

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
Route::post('/newsletter/resubscribe', [NewsletterController::class, 'resubscribe'])->name('newsletter.resubscribe');

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::put('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::post('/coupon', [CouponController::class, 'apply'])->name('coupon.apply');
    Route::delete('/coupon', [CouponController::class, 'remove'])->name('coupon.remove');
});

Route::get('/gift-cards', [GiftCardController::class, 'create'])->name('gift-cards.create');
Route::post('/gift-cards', [GiftCardController::class, 'store'])->name('gift-cards.store');
Route::get('/gift-cards/{giftCard}', [GiftCardController::class, 'show'])->name('gift-cards.show');
Route::post('/gift-cards/verify', [GiftCardController::class, 'verify'])->name('gift-cards.verify');
Route::post('/gift-cards/remove', [GiftCardController::class, 'remove'])->name('gift-cards.remove');

Route::post('/push/subscribe', [PushNotificationController::class, 'subscribe'])->name('push.subscribe');
Route::post('/push/test', [PushNotificationController::class, 'sendTest'])->name('push.test');

Route::get('/stripe/checkout/{order}', [StripePaymentController::class, 'checkout'])->name('stripe.checkout');
Route::get('/stripe/success/{order}', [StripePaymentController::class, 'success'])->name('stripe.success');
Route::get('/stripe/cancel/{order}', [StripePaymentController::class, 'cancel'])->name('stripe.cancel');

Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/suggest', [SearchController::class, 'suggest'])->name('search.suggest');

Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/', [CheckoutController::class, 'store'])->name('store');
    Route::post('/toggle-points', [CheckoutController::class, 'togglePoints'])->name('togglePoints');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
    });

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    });

    Route::get('/returns', [ReturnController::class, 'index'])->name('returns.index');
    Route::get('/returns/create/{order}', [ReturnController::class, 'create'])->name('returns.create');
    Route::post('/returns/{order}', [ReturnController::class, 'store'])->name('returns.store');
    Route::get('/returns/view/{return}', [ReturnController::class, 'show'])->name('returns.show');

    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('index');
        Route::post('/toggle/{product}', [WishlistController::class, 'toggle'])->name('toggle');
        Route::post('/add-to-cart/{product}', [WishlistController::class, 'addToCart'])->name('addToCart');
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [AdminDashboardController::class, 'orders'])->name('orders');
    Route::put('/orders/{order}/status', [AdminDashboardController::class, 'updateOrderStatus'])->name('orders.status');
    Route::resource('products', AdminProductController::class);
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
    Route::put('/users/{user}/role', [AdminDashboardController::class, 'updateUserRole'])->name('users.role');
    Route::get('/subscribers', [AdminDashboardController::class, 'subscribers'])->name('subscribers');
    Route::get('/returns', [AdminDashboardController::class, 'returns'])->name('returns');
    Route::put('/returns/{return}', [AdminDashboardController::class, 'updateReturn'])->name('returns.update');
    Route::get('/chat', fn() => view('admin.chat'))->name('chat');

    Route::get('/flash-sales', [AdminDashboardController::class, 'flashSales'])->name('flash-sales');
    Route::post('/flash-sales', [AdminDashboardController::class, 'storeFlashSale'])->name('flash-sales.store');
    Route::put('/flash-sales/{flashSale}/toggle', [AdminDashboardController::class, 'toggleFlashSale'])->name('flash-sales.toggle');
    Route::delete('/flash-sales/{flashSale}', [AdminDashboardController::class, 'deleteFlashSale'])->name('flash-sales.delete');
});