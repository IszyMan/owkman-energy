<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    // USER SUBMIT REVIEW
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required',
        ]);

        Review::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Review submitted for approval');
    }

    // ADMIN: LIST REVIEWS
    public function adminIndex()
    {
        $reviews = Review::with('product', 'user')->latest()->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    // ADMIN: APPROVE
    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->status = 'approved';
        $review->save();

        return back();
    }

    // ADMIN: DELETE
    public function destroy($id)
    {
        Review::findOrFail($id)->delete();
        return back();
    }
}
