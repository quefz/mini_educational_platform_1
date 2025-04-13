<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $courses = Course::all();

        return view('pages.courses.index')
            ->with(['courses' => $courses]);
    }

    public function show(Course $course)
    {
        $course->load(['lessons', 'reviews.user', 'author']);
        $avgRating = $course->avgRating();

        $isEnrolled = Auth::check() && $course->members()
            ->where('user_id', auth::id())->exists();

        $hasCertificate = Auth::check() && $course->certificates()
            ->where('user_id', Auth::id())->exists();

        return view('pages.courses.show',
            compact('course', 'avgRating', 'isEnrolled', 'hasCertificate'));
    }

    public function create()
    {
        return view('pages.courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'nullable|numeric|min:0',
            'level' => 'required|in:beginner,intermediate,advanced'
        ]);

        if($request->hasFile('thumbnail'))
        {
            $validated['thumbnail'] = $request->file('thumbnail')
                ->store('thumbnails', 'public');
        }

        $validated['user_id'] = Auth::id();

        Course::create($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        $this->authorize('update', $course);

        return view('pages.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'nullable|numeric|min:0',
            'level' => 'required|in:beginner,intermediate,advanced',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
                Storage::disk('public')->delete($course->thumbnail);
            }

            $validated['thumbnail'] = $request->file('thumbnail')
                ->store('thumbnails', 'public');
        }

        $course->update($validated);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted.');
    }
}
