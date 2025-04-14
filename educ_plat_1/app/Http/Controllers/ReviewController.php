<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Course $course)
    {
        $reviews = $course->reviews()->get();

        return view('courses.reviews.index', compact('course', 'reviews'));
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $user = $request->user();

        if($course->reviews()->where('user_id', $user->id)->exists())
        {
            return back()->with('error', 'You already left a review.');
        }

        $course->reviews()->create([
            'user_id' => $user->id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return back()->with('success', 'Review submitted.');
    }

    public function destroy(Review $review, Request $request)
    {
        $user = $request->user();

        if($review->user_id !== $user->id)
        {
            return back()->with('error', 'You are not allowed to delete this review.');
        }

        $review->deleteOrFail();

        return back()->with('success', 'Review deleted successfully.');
    }
}
