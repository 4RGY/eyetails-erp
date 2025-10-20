<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReturnRequestController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Auth\SocialiteController;
// =================================================
// ADMIN ROUTE
// =================================================
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ReturnRequestController as AdminReturnRequestController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\AdminChatController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\CrmController;
use App\Http\Controllers\Admin\PaymentMethodController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Semua route web di sini dimuat oleh RouteServiceProvider.
|
*/

// ==============================================
// 1. FRONTEND PAGES (Public Access)
// ==============================================

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman Statis
Route::view('/tentang-kami', 'about')->name('about');
Route::view('/faq', 'faq')->name('faq');
Route::view('/syarat-dan-ketentuan', 'terms')->name('terms');
Route::view('/kebijakan-privasi', 'privacy')->name('privacy');
Route::view('/testimoni', 'testimoni')->name('testimoni');

// Katalog & Detail Produk
Route::get('/katalog', [ProductController::class, 'index'])->name('catalog.index');
Route::get('/katalog/{product:slug}', [ProductController::class, 'show'])->name('catalog.show');

// Kontak Kami
Route::get('/kontak-kami', function () {
    return view('contact');
})->name('contact');
Route::post('/kontak-kami', [ContactController::class, 'submit'])->name('contact.submit');

// Blog/Berita
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

// Keranjang (Cart) - Dapat diakses oleh tamu (guest)
Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/keranjang/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/keranjang/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
// === TAMBAHKAN KEMBALI DUA BARIS INI ===
Route::post('/checkout/apply-promo', [CheckoutController::class, 'applyPromo'])->name('checkout.applyPromo');
Route::post('/checkout/remove-promo', [CheckoutController::class, 'removePromo'])->name('checkout.removePromo');

// Promo
Route::get('/promo', [ProductController::class, 'promo'])->name('promo.index');
// Testimoni
// Route untuk menampilkan form tulis ulasan
Route::get('/ulasan/tulis/{item}', [ReviewController::class, 'create'])->name('reviews.create');
// Route untuk menyimpan ulasan
Route::post('/ulasan', [ReviewController::class, 'store'])->name('reviews.store');
// === ROUTE BARU UNTUK PENGEMBALIAN (SISI PELANGGAN) ===
Route::get('/pengembalian/ajukan/{item}', [ReturnRequestController::class, 'create'])->name('returns.create');
Route::post('/pengembalian', [ReturnRequestController::class, 'store'])->name('returns.store');

Route::prefix('chat')->name('chat.')->group(function () {
    Route::get('/', [ChatController::class, 'index'])->name('index');
    Route::post('/start', [ChatController::class, 'startConversation'])->name('start');
    Route::get('/{conversation}', [ChatController::class, 'show'])->name('show');
    Route::post('/{conversation}/send', [ChatController::class, 'sendMessage'])->name('send');
});

Route::get('/auth/google/redirect', [SocialiteController::class, 'redirectToProvider'])->name('google.redirect');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleProviderCallback'])->name('google.callback');

// ==============================================
// 2. AUTHENTICATION & AKUN LANJUT (Protected Access)
// ==============================================

Route::middleware(['auth'])->group(function () {
    

    // Dashboard Akun
    Route::get('/dashboard', function () {
        $user = Auth::user();

        // Mengambil 1 pesanan terakhir beserta relasi item-nya
        $latestOrder = $user->orders()->with('items')->latest()->first();

        // Menghitung total pesanan
        $totalOrders = $user->orders()->count();

        return view('dashboard', [
            'latestOrder' => $latestOrder,
            'totalOrders' => $totalOrders
        ]);
    })->name('dashboard');

    // Riwayat Pesanan & Lacak Pesanan (23-24 Oktober)
    Route::post('/keranjang/add/{product:slug}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/riwayat-pesanan', [UserOrderController::class, 'index'])->name('order.history');
    Route::get('/order/{order}/tracking', [UserOrderController::class, 'tracking'])->name('order.tracking');

    // Wishlist (25-27 Oktober)
    Route::get('/akun/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    // Baris baru
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // PENGATURAN PROFIL & PASSWORD BAWAAN BREEZE
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==============================================
// 3. ADMIN AREA (Protected Access)
// ==============================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // ROUTE BARU UNTUK CRUD PRODUK
    Route::resource('products', AdminProductController::class);
    // routes/web.php (di dalam grup admin)
    Route::delete('/products/images/{imageId}', [AdminProductController::class, 'destroyImage'])->name('products.images.destroy');
    Route::resource('users', AdminUserController::class);
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
    Route::resource('posts', PostController::class);
    Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('reports/print', [AdminReportController::class, 'printPDF'])->name('reports.print');
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('promotions', PromotionController::class);
    Route::resource('returns', AdminReturnRequestController::class)->only([
        'index',
        'show',
        'update'
    ]);
    Route::get('campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('campaigns/send', [CampaignController::class, 'send'])->name('campaigns.send');
    Route::resource('shipping', ShippingController::class)
        ->except(['show'])
        ->parameters(['shipping' => 'shippingOption']);
    Route::resource('payments', PaymentMethodController::class)->except(['show']);
    Route::prefix('crm')->name('crm.')->group(function () {
        Route::get('/', [CrmController::class, 'index'])->name('index');
        Route::get('/customer/{customer}', [CrmController::class, 'show'])->name('show');
        Route::post('/customer/{customer}/interaction', [CrmController::class, 'addInteraction'])->name('interaction.add');
        Route::patch('/customer/{customer}/status', [CrmController::class, 'updateStatus'])->name('status.update');
    });
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/', [AdminChatController::class, 'index'])->name('index');
        Route::get('/{conversation}', [AdminChatController::class, 'show'])->name('show');
        Route::post('/{conversation}/send', [AdminChatController::class, 'sendMessage'])->name('send');
    });
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::put('/', [SettingsController::class, 'update'])->name('update');
        Route::delete('/remove/{key}', [SettingsController::class, 'remove'])->name('remove');
    });
});

// ROUTE AUTHENTICATION LAINNYA (Login, Register, Reset Password)
require __DIR__ . '/auth.php';
