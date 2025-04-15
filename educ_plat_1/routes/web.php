<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CertificateController;

Route::get('/', [IndexController::class, 'index'])
    ->name('index');

Route::get('/courses', [CourseController::class, 'index'])
    ->name('courses.index');
Route::middleware('auth')->group(function () {
    Route::get('/courses/create', [CourseController::class, 'create'])
        ->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])
        ->name('courses.store');
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])
        ->name('courses.edit');
    Route::put('/courses/{course}', [CourseController::class, 'update'])
        ->name('courses.update');
    Route::delete('courses/{course}', [CourseController::class, 'destroy'])
        ->name('courses.destroy');
});
Route::get('/courses/{course}', [CourseController::class, 'show'])
    ->name('courses.show');

Route::middleware('auth')->group(function() {
    Route::get('/courses/{course}/lessons', [LessonController::class, 'index'])
        ->name('lessons.index');
    Route::get('/courses/{course}/lessons/create', [LessonController::class, 'create'])
        ->name('lessons.create');
    Route::post('/courses/{course}/lessons', [LessonController::class, 'store'])
        ->name('lessons.store');
    Route::get('/courses/{course}/lessons/{lesson}/edit', [LessonController::class, 'edit'])
        ->name('lessons.edit');
    Route::put('/courses/{course}/lessons/{lesson}', [LessonController::class, 'update'])
        ->name('lessons.update');
    Route::delete('/courses/{course}/lessons/{lesson}', [LessonController::class, 'destroy'])
        ->name('lessons.destroy');
    Route::post('/courses/{course}/lessons/{lesson}/complete', [LessonController::class, 'complete'])
        ->name('lessons.complete');
    Route::get('/courses/{course}/lessons/{lesson}', [LessonController::class, 'show'])
        ->name('lessons.show');
});

Route::middleware('auth')->group(function() {
    Route::post('users/{user}/enroll/{course}', [UserController::class, 'enroll'])
        ->name('users.enroll');
    Route::post('users/{user}/leave/{course}', [UserController::class, 'leave'])
        ->name('users.leave');
});

Route::get('/certificates/{certificate}', [CertificateController::class, 'show'])
    ->name('certificates.show');
Route::middleware('auth')->post('/courses/{course}/certificate', [CertificateController::class, 'generate'])
    ->name('certificates.generate');

Route::get('/courses/{course}/reviews', [ReviewController::class, 'index'])
    ->name('reviews.index');
Route::middleware('auth')->post('/courses/{course}/reviews', [ReviewController::class, 'store'])
    ->name('reviews.store');
Route::middleware('auth')->delete('/courses/{course}/reviews/{review}', [ReviewController::class, 'destroy'])
    ->name('reviews.destroy');

Route::get('/auth/login', [LoginController::class, 'show'])
    ->name('login.show');
Route::post('/auth/login', [LoginController::class, 'login'])
    ->name('login.login');
Route::post('/', [LoginController::class, 'logout']  )
    ->name('login.logout');

Route::get('/auth/register', [RegisterController::class, 'show'])
    ->name('register.show');
Route::post('/auth/register', [RegisterController::class, 'register'])
    ->name('register.register');
