<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Certificate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function construct_()
    {
        $this->middleware('auth');
    }

    public function generate(Request $request, Course $course)
    {
        $user = $request->user();

        if(!$user->enrolledCourses()->where('course_id', $course->id)->exists())
        {
            return back()->with('error', 'You are not enrolled in this course.');
        }

        if($user->certificates()->where('course_id', $course->id)->exists())
        {
            return back()->with('error', 'The certificate has already been issued.');
        }

        $completedLessonsCount = $user->lessonCompletions()
            ->whereIn('lesson_id', $course->lessons()->pluck('id'))
            ->count();

        $totalLessonsCount = $course->lessons()->count();

        if($completedLessonsCount < $totalLessonsCount)
        {
            return back()->with('error',
            'Course not completed!'. $completedLessonsCount . 'of' .
            $totalLessonsCount . 'lessons completed.');
        }

        $certificate = $course->certificates()->create([
            'user_id' => $user->id,
            'certificate_code' => Str::uuid(),
            'issued_at' => now()
        ]);

        return redirect()->route('certificates.show', $certificate)
            ->with('success', 'The certificate was successfully created');
    }

    public function show(Certificate $certificate)
    {
        $user = Auth::user();

        if($certificate->user_id != $user->id)
        {
            return redirect()->route('certificates.index')
                ->with('error', 'You do not have permission to view this certificate.');
        }

        return view('certificates.show', compact('certificate'));
    }
}
