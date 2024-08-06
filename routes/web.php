<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
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
        Route::get('/admin', function () {
            return view('admin.dashboard'); // Admin dashboard
        })->name('admin.dashboard');

    // Routes for admin profile management
    Route::get('/admin/profile', [AdminProfileController::class, 'edit'])->name('admin-profile.edit');
    Route::patch('/admin/profile', [AdminProfileController::class, 'update'])->name('admin-profile.update');
    Route::delete('/admin/profile', [AdminProfileController::class, 'destroy'])->name('admin-profile.destroy');

    // Routes for category management
    Route::resource('admin/categories', CategoryController::class);

    // Routes for product management
    Route::resource('admin/products', ProductController::class);
    });

    // Routes for user profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes for customer products
    Route::get('/products', [ProductController::class, 'customerIndex'])->name('customer-products.index');
    Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');
});

require __DIR__.'/auth.php';
