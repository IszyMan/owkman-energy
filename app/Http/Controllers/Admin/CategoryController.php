<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'parent_id' => $request->parent_id ?? null,
            'is_active' => 1,
            'sort_order' => 0,
        ]);

        return redirect('/admin/categories');
    }
    public function edit($id)
    {
        $category = Category::findOrFail($id);
    
        return view('admin.categories.edit', compact('category'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $category = Category::findOrFail($id);
    
        $category->update([
            'name' => $request->name,
        ]);
    
        return redirect('/admin/categories');
    }

    

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // optional: prevent deleting if products exist
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Cannot delete category with products.');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}