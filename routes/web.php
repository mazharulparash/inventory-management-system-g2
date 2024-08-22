<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\CustomerProductController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminUserController;

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Routes for authenticated users
Route::middleware(['auth', 'verified'])->group(function () {
    // Route for the customer dashboard
    Route::get('/customer', function () {
        return view('dashboard'); // Customer dashboard
    })->name('dashboard');

    // Route for the admin dashboard
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Routes for admin profile management
        Route::get('/admin/profile', [AdminProfileController::class, 'edit'])->name('admin-profile.edit');
        Route::patch('/admin/profile', [AdminProfileController::class, 'update'])->name('admin-profile.update');
        Route::delete('/admin/profile', [AdminProfileController::class, 'destroy'])->name('admin-profile.destroy');

        // Routes for category management
        Route::resource('admin/categories', CategoryController::class);

        // Routes for product management
        Route::resource('admin/products', ProductController::class);

        // Routes for admin orders
        Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/admin/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/admin/orders/{id}', [AdminOrderController::class, 'update'])->name('orders.update');

        // Routes for admin reports
        Route::get('/admin/report-sales', [ReportController::class, 'sales'])->name('report-sales.index');
        Route::post('/admin/report-sales/download', [ReportController::class, 'downloadSalesReport'])->name('report-sales.download');
        Route::get('/admin/report-product-sales', [ReportController::class, 'productSales'])->name('report-product-sales.index');
        Route::post('/admin/report-product-sales/download', [ReportController::class, 'downloadProductSalesReport'])->name('report-product-sales.download');
        // Routes for user management
        Route::resource('admin/users', AdminUserController::class);
    });


    // Admin Middleware End

    // Routes for user profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes for customer products
    Route::get('/products', [CustomerProductController::class, 'index'])->name('customer-products.index');
    Route::get('/product/{id}', [CustomerProductController::class, 'show'])->name('customer-product.show');

    // Routes for customer cart
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Routes for customer checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/confirmation/{order}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');

    // Routes for customer orders
    Route::get('/orders', [OrderController::class, 'index'])->name('customer-orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('customer-orders.show');
    Route::get('/orders/{id}/download', [OrderController::class, 'download'])->name('customer-orders.download');


});

require __DIR__.'/auth.php';
