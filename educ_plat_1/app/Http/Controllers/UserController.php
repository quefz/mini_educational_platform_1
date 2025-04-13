<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function enroll(Request $request, Course $course)
    {
        $user = $request->user();

        if($user->enrolledCourses()->where('course_id', $course->id)->exists())
        {
            return back()->with('error', 'You are already participating in this course.');
        }

        $user->enrolledCourses()->attach($course->id);
        return back()->with('success', 'Registration for the course was successful');
    }

    public function leave(Request $request, Course $course)
    {
        $request->user()->enrolledCourses()->detach($course->id);
        return back()->with('success', 'Вы покинули курс.');
    }
}
