<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('teacher')->withCount('enrollments')->latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $teachers = User::where('role', 'teacher')->get();
        return view('admin.courses.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:courses',
            'description' => 'required',
            'teacher_id' => 'required|exists:users,id',
            'status' => 'required|in:draft,published',
            'price' => 'numeric|min:0',
            'level' => 'string|nullable',
        ]);

        Course::create($request->all());

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        $teachers = User::where('role', 'teacher')->get();
        return view('admin.courses.edit', compact('course', 'teachers'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:courses,slug,' . $course->id,
            'description' => 'required',
            'teacher_id' => 'required|exists:users,id',
            'status' => 'required|in:draft,published',
            'price' => 'numeric|min:0',
            'level' => 'string|nullable',
        ]);

        $course->update($request->all());

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }
}
