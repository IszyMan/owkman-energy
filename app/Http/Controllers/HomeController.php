<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Featured;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('images')->latest()->get();
        $categories = Category::all();
        $featured = Featured::with('product.images')->latest()->get();

        return view('home', compact('products', 'categories', 'featured'));
    }
}



