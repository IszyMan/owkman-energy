<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $categories = Category::all();

        $products = Product::where('category_id', $category->id)
            ->with('images')
            ->latest()
            ->get();        
        
        
        $latestProducts = Product::with('images')
            ->latest()
            ->take(8)
            ->get();
    

        return view('category.show', compact(
            'category', 
            'products', 
            'categories', 
            'latestProducts',));
    }
}