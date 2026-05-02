<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{    
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['images', 'category'])
            ->firstOrFail();

        // Related products (same category)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('images')
            ->latest()
            ->take(8)
            ->get();

        // Latest products
        $latestProducts = Product::with('images')
            ->latest()
            ->take(8)
            ->get();


        $recent = session()->get('recent_products', []);

        // remove duplicates + current product
        $recent = array_filter($recent, fn($id) => $id != $product->id);

        // add current product to front
        array_unshift($recent, $product->id);

        // keep only last 5
        $recent = array_slice($recent, 0, 5);

        session()->put('recent_products', $recent);

        $recentlyViewed = Product::whereIn('id', $recent)
            ->with('images')
            ->get(); 
            
            
        $reviews = $product->reviews()
        ->where('status', 'approved')
        ->with('user')
        ->latest()
        ->get();    

        return view('product.show', compact(
            'product',
            'relatedProducts',
            'latestProducts',
            'reviews',
            'recentlyViewed'
        ));
    }

   
   public function suggestions(Request $request)
    {
        return Product::with('images')
            ->where('name', 'LIKE', "%{$request->q}%")
            ->limit(6)
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'price' => $p->price,
                    'slug' => $p->slug,
                    'image' => $p->images->first()
                        ? asset('storage/'.$p->images->first()->image)
                        : asset('images/default.png'),
                ];
            });
    }

  

    public function search(Request $request)
    {
        $query = $request->q;

        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get();

        return view('search.results', compact('products', 'query'));
    }


}