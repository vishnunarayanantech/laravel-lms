<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('courses', CourseController::class);
Route::resource('enrollments', EnrollmentController::class);
Route::resource('lessons', LessonController::class);

// Route::middleware('auth')->group(function(){

// Route::resource('courses',CourseController::class);

// });

Route::middleware('auth')->group(function(){

Route::post('/courses/{course}/enroll',
[EnrollmentController::class,'enroll'])
->name('courses.enroll');

});

Route::middleware('auth')->group(function(){

Route::get(
'/courses/{course}/lessons/{lesson}',
[LessonController::class,'show']
)->name('lessons.show');


Route::post(
'/courses/{course}/lessons/{lesson}/complete',
[LessonController::class,'complete']
)->name('lessons.complete');

});