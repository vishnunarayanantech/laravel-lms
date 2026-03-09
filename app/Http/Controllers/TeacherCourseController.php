<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TeacherCourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('teacher_id', Auth::id())
            ->withCount('enrollments')
            ->latest()
            ->paginate(10);
            
        return view('teacher.dashboard', compact('courses'));
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
            'status' => 'required|in:draft,published',
            'price' => 'numeric|min:0',
            'level' => 'string|nullable',
        ]);

        $course = new Course($request->all());
        $course->teacher_id = Auth::id();
        $course->save();

        return redirect()->route('teacher.dashboard')->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $students = User::where('role', 'student')->orderBy('name')->get();
        $enrolledStudents = $course->enrollments()->with('user')->get();
        
        return view('courses.edit', compact('course', 'students', 'enrolledStudents'));
    }

    public function enrollStudents(Request $request, Course $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:users,id'
        ]);

        foreach ($request->students as $studentId) {
            // Validate it's actually a student
            $user = User::where('id', $studentId)->where('role', 'student')->first();
            if (!$user) continue;

            Enrollment::firstOrCreate([
                'user_id' => $studentId,
                'course_id' => $course->id
            ], [
                'status' => 'active',
                'enrolled_at' => now()
            ]);
        }

        return redirect()->route('teacher.courses.edit', $course)
            ->with('success', 'Students enrolled successfully.');
    }

    public function update(Request $request, Course $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:courses,slug,' . $course->id,
            'description' => 'required',
            'status' => 'required|in:draft,published',
            'price' => 'numeric|min:0',
            'level' => 'string|nullable',
        ]);

        $course->update($request->all());

        return redirect()->route('teacher.dashboard')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $course->delete();
        
        return redirect()->route('teacher.dashboard')->with('success', 'Course deleted successfully.');
    }
}
