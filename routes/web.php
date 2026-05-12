<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController; 
use App\Http\Controllers\CategoryController;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\FeaturedController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;


Route::get('/', [HomeController::class, 'index']);

Route::get('/product/{slug}', [ProductController::class, 'show']);

Route::post('/reviews', [ReviewController::class, 'store']);

Route::get('/category/{slug}', [CategoryController::class, 'show']);


Route::get('/search-suggestions', [ProductController::class, 'suggestions']);
Route::get('/search', [ProductController::class, 'search']);


Route::post('/cart/add', [CartController::class, 'add']);
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/increase', [CartController::class, 'increase']);
Route::post('/cart/decrease', [CartController::class, 'decrease']);
Route::post('/cart/remove', [CartController::class, 'remove']);

Route::get('/checkout', [CheckoutController::class, 'index']);

Route::get('/my-orders', [OrderController::class, 'index']);




Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    

    // Products
    Route::get('/products', [AdminProductController::class, 'index']);
    Route::get('/products/create', [AdminProductController::class, 'create']);
    Route::post('/products', [AdminProductController::class, 'store']);
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit']);
    Route::put('/products/{id}', [AdminProductController::class, 'update']);
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy']);

    // Categories
    Route::get('/categories', [AdminCategoryController::class, 'index']);
    Route::get('/categories/create', [AdminCategoryController::class, 'create']);
    Route::post('/categories', [AdminCategoryController::class, 'store']);
    Route::get('/categories/{id}/edit', [AdminCategoryController::class, 'edit']);
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update']);
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy']);


    Route::get('/reviews', [ReviewController::class, 'adminIndex']);
    Route::patch('/reviews/{id}/approve', [ReviewController::class, 'approve']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);

    Route::get('/featured', [FeaturedController::class, 'index']);
    Route::post('/featured', [FeaturedController::class, 'store']);
    Route::delete('/featured/{id}', [FeaturedController::class, 'destroy']);


    Route::get('/orders', [AdminOrderController::class, 'index']);
    Route::get('/orders/{id}', [AdminOrderController::class, 'show']);
    Route::post('/orders/{id}/status', [AdminOrderController::class, 'updateStatus']);

    

});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

   

require __DIR__.'/auth.php';
