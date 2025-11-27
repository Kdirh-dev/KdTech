<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\RepairController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\RepairController as AdminRepairController;
use App\Http\Controllers\Admin\SettingController;
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

// Routes Publiques
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');

// Routes Produits
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/category/{categorySlug}', [ProductController::class, 'byCategory'])->name('products.byCategory');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Wishlist (session-based minimal implementation)
Route::post('/wishlist/{id}', [WishlistController::class, 'add'])->name('wishlist.add');

// Routes Réparations (publiques)
Route::get('/repairs', [RepairController::class, 'index'])->name('repairs.index');
Route::get('/repairs/track', [RepairController::class, 'track'])->name('repairs.track');

// Routes Panier (publiques pour voir, protégées pour commander)
Route::get('/cart', [OrderController::class, 'cart'])->name('cart');
Route::post('/cart/add/{id}', [OrderController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [OrderController::class, 'updateCart'])->name('cart.update');
Route::get('/cart/remove/{id}', [OrderController::class, 'removeFromCart'])->name('cart.remove');

// Routes Protégées (nécessitent une connexion)
Route::middleware(['auth', 'verified'])->group(function () {
    // Commandes
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'placeOrder'])->name('checkout.place');

    // Routes Utilisateur
    Route::prefix('user')->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
        Route::get('/orders', [UserController::class, 'orders'])->name('user.orders');
        Route::get('/orders/{id}', [UserController::class, 'orderDetail'])->name('user.order.detail');
        Route::get('/repairs', [UserController::class, 'repairs'])->name('user.repairs');
    });

    // Réparations
    Route::post('/repairs', [RepairController::class, 'store'])->name('repairs.store');

    // Profile - Accessible à tous les utilisateurs connectés
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes Admin (nécessitent le rôle admin ou manager)
    Route::middleware('role:admin,manager')->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Routes Produits
        Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
        Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products', [AdminProductController::class, 'store'])->name('admin.products.store');
        Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.delete');

        // Routes Commandes
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

        // Routes Réparations
        Route::get('/repairs', [AdminRepairController::class, 'index'])->name('admin.repairs.index');
        Route::get('/repairs/{repair}', [AdminRepairController::class, 'show'])->name('admin.repairs.show');
        Route::post('/repairs/{repair}/status', [AdminRepairController::class, 'updateStatus'])->name('admin.repairs.updateStatus');
        Route::post('/repairs/{repair}/estimate', [AdminRepairController::class, 'updateEstimate'])->name('admin.repairs.updateEstimate');

        // Routes Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
        Route::post('/settings/hero', [SettingController::class, 'updateHero'])->name('admin.settings.updateHero');
        Route::post('/settings/about', [SettingController::class, 'updateAbout'])->name('admin.settings.updateAbout');
    });
});

// Redirection du dashboard par défaut
Route::get('/dashboard', function () {
    // Rediriger vers le dashboard admin si l'utilisateur est admin/manager, sinon vers le dashboard utilisateur
    if (auth()->check() && auth()->user()->hasRole(['admin', 'manager'])) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
