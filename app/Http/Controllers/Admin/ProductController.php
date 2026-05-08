<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category; 
use App\Models\ProductImage;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    

    public function store(Request $request)
    {


        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'replace_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
                
        $slug = Str::slug($request->name);

        $original = $slug;
        $count = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count;
            $count++;
        }


        $product = Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'stock' => $request->stock ?? 0,
        ]);

        // Handle multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {

                $filename = Str::uuid().'.'.$image->extension();
                $image->move(public_path('storage/products'), $filename);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'storage/products/'.$filename,
                ]);
            }
        }

        return redirect('/admin/products');
    }

    public function index()
    {
        $products = Product::with('images')->latest()->get();

        return view('admin.products.index', compact('products'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'replace_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            
        ]);

        $product = Product::findOrFail($id);

        // update product info
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);

        if ($request->hasFile('replace_images')) {

            foreach ($request->file('replace_images') as $imageId => $file) {

                $img = ProductImage::find($imageId);

                if ($img) {

                    // delete old image
                    $oldPath = public_path($img->image);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }

                    // upload new image
                    $filename = Str::uuid().'.'.$file->extension();
                    $file->move(public_path('storage/products'), $filename);

                    // update record
                    $img->update([
                        'image' => 'storage/products/'.$filename
                    ]);
                }
            }
        }

        if ($request->hasFile('new_images')) {

            foreach ($request->file('new_images') as $file) {

                $filename = Str::uuid().'.'.$file->extension();
                $file->move(public_path('storage/products'), $filename);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'storage/products/'.$filename
                ]);
            }
        }
        return redirect('/admin/products');
    }

    public function destroy($id)
    {
        $product = Product::with('images')->findOrFail($id);

        foreach ($product->images as $img) {
            $oldPath = public_path($img->image);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
            $img->delete();
        }

        $product->delete();

        return redirect('/admin/products');
    }
}