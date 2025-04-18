<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Course\CourseCreateRequest;
use App\Http\Requests\Course\CourseUpdateRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CourseController extends Controller
{
    use AuthorizesRequests;

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

    public function store(CourseCreateRequest $request)
    {
        $validated = $request->validated();

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

    public function update(CourseUpdateRequest $request, Course $course)
    {
        $this->authorize('update', $course);

        $validated = $request->validated();

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
