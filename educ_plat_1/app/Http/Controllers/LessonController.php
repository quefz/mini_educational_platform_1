<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\LessonCompletion;

class LessonController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Course $course)
    {
        $lessons = $course->lessons()->get();

        return view('pages.courses.lessons.index', compact('course', 'lessons'));
    }

    public function create(Course $course)
    {
        $this->authorize('manageLessons', $course);

        return view('pages.courses.lessons.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $this->authorize('manageLessons', $course);

        $validated = $request->validate ([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $lesson = $course->lessons()->create($validated);

        return redirect()->route('courses.lessons.show', [$course, $lesson])
            ->with('success', 'Lesson created.');
    }

    public function edit(Course $course, Lesson $lesson)
    {
        $this->authorize('manageLessons', $course);

        return view('pages.courses.lessons.edit', compact('course', 'lesson'));
    }

    public function update(Request $request, Course $course, Lesson $lesson)
    {
        $this->authorize('manageLessons', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $lesson->update($validated);

        return redirect()->route('courses.lessons.show', [$course, $lesson])
            ->with('success', 'Lesson updated.');
    }

    public function destroy(Course $course, Lesson $lesson)
    {
        $this->authorize('manageLessons', $course);

        $lesson->delete();

        return redirect()->route('courses.lessons.index', $course)
            ->with('success', 'Lesson denied');
    }

    public function complete(Request $request, Course $course, Lesson $lesson)
    {
        if($lesson->course_id != $course->id)
        {
            abort(404, 'Lesson does not belong to the specified course.');
        }

        $user = $request->user();

        $completed = LessonCompletion::where('user_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->exists();

        if(!$completed)
        {
            $user->lessonCompletions()->create([
                'lesson_id' => $lesson->id,
            ]);
        }

        return back()->with('success', 'Lesson marked as completed.');
    }
}
