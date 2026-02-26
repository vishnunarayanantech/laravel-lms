<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::resource('courses', CourseController::class)->only(['index', 'show']);

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Enrollment
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'enroll'])->name('courses.enroll');

    // Lesson Viewer & Completion
    Route::get('/courses/{course}/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
    Route::post('/courses/{course}/lessons/{lesson}/complete', [LessonController::class, 'complete'])->name('lessons.complete');

    // Dashboards
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])
        ->middleware('role:student')
        ->name('dashboard');

    // Teacher Dashboard
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])
        ->middleware('role:teacher')
        ->name('teacher.dashboard');

});

// Admin Panel Routes
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('users', \App\Http\Controllers\AdminUserController::class);

    Route::resource('courses', \App\Http\Controllers\AdminCourseController::class);

    Route::resource('lessons', \App\Http\Controllers\AdminLessonController::class);

    Route::resource('enrollments', \App\Http\Controllers\AdminEnrollmentController::class);
    
    Route::get('/reports', [\App\Http\Controllers\AdminReportController::class, 'index'])->name('reports.index');
});

require __DIR__.'/auth.php';
