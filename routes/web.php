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



Route::get('/product/{slug}', [ProductController::class, 'show']);

Route::post('/reviews', [ReviewController::class, 'store']);


Route::get('/', function () {
    $products = Product::with('images')->latest()->get();
    $categories = Category::all();

    return view('home', compact('products', 'categories'));
});

Route::get('/category/{slug}', [CategoryController::class, 'show']);


Route::get('/search-suggestions', [ProductController::class, 'suggestions']);
Route::get('/search', [ProductController::class, 'search']);




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


    Route::get('/reviews', [ReviewController::class, 'adminIndex']);
    Route::patch('/reviews/{id}/approve', [ReviewController::class, 'approve']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);
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
