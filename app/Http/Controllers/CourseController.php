<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{

    // public function index()
    // {
    //     $courses = Course::latest()->get();

    //     return view('courses.index', compact('courses'));
    // }


public function index()
{
    // If a teacher is logged in, only show their own published courses
    if (auth()->check() && auth()->user()->role === 'teacher') {
        $courses = Course::with('teacher')
            ->where('teacher_id', auth()->id())
            ->where('status', 'published')
            ->get();
    } else {
        $courses = Course::with('teacher')
            ->where('status', 'published')
            ->get();
    }

    return view('courses.index', compact('courses'));
}

public function show(Course $course)
{
    $course->load(['teacher', 'lessons']);
    $isEnrolled = false;

    // Restrict teachers to only view their own courses
    if (auth()->check() && auth()->user()->role === 'teacher' && $course->teacher_id !== auth()->id()) {
        abort(403);
    }

    if (auth()->check()) {
        $isEnrolled = $course->enrollments()
            ->where('user_id', auth()->id())
            ->exists();
    }

    return view('courses.show', compact('course', 'isEnrolled'));
}

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|max:255',
        'slug' => 'required|unique:courses',
        'description' => 'required',
        'teacher_id' => 'required|exists:users,id',
        'status' => 'required'
    ]);

    Course::create($request->all());

    return redirect('/courses');
}

    public function edit(Course $course)
    {
        return view('courses.edit',compact('course'));
    }

    public function update(Request $request, Course $course)
{
    $request->validate([
        'title' => 'required|max:255',
        'slug' => 'required|unique:courses,slug,' . $course->id,
        'description' => 'required',
        'teacher_id' => 'required|exists:users,id',
        'status' => 'required'
    ]);

    $course->update($request->all());

    return redirect('/courses');
}

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect('/courses');
    }

}