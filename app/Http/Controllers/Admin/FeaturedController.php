<?php

namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Featured;
use App\Models\Product;

class FeaturedController extends Controller
{
    public function index()
    {
        $featureds = Featured::with('product')->latest()->get();
        $products = Product::all();

        return view('admin.featured.index', compact('featureds', 'products'));
    }

    public function store(Request $request)
    {
        Featured::create([
            'product_id' => $request->product_id
        ]);

        return back()->with('success', 'Product added to featured');
    }

    public function destroy($id)
    {
        Featured::findOrFail($id)->delete();
        return back()->with('success', 'Removed from featured');
    }
}
