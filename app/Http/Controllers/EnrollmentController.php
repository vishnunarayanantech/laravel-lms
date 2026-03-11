<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function create()
    {
        $students = User::where('role', 'student')->get();
        if (auth()->check() && auth()->user()->role === 'teacher') {
            $courses = Course::where('teacher_id', auth()->id())->get();
        } else {
            $courses = Course::all();
        }

        return view('enrollments.create', compact('students', 'courses'));
    }

    public function enroll(Request $request, Course $course)
    {
        $user = auth()->user();
        $role = $user ? $user->role : 'student';

        // Step 2: Restrict student access - students cannot enroll themselves
        if ($role === 'student') {
            abort(403, 'Students cannot enroll themselves. Contact a teacher or admin.');
        }

        // Step 9 & Security validation
        if ($role === 'teacher') {
            if ($course->teacher_id !== auth()->id()) {
                abort(403, 'You are not allowed to enroll students in this course.');
            }
        } elseif ($role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        // Determine which student is being enrolled (Step 3: Keep admin/teacher functionality)
        if ($request->has('user_id')) {
            // Step 3 (Validate student)
            $student = User::where('id', $request->user_id)
                ->where('role', 'student')
                ->firstOrFail();
            $studentId = $student->id;
        } else {
            // For teacher/admin if they didn't provide a student ID but somehow hit this?
            // Actually, for teacher/admin to enroll a student, they MUST provide an ID.
            return back()->with('error', 'Please provide a student to enroll.');
        }

        // Step 4: Prevent duplicate enrollment
        if (Enrollment::where('user_id', $studentId)
            ->where('course_id', $course->id)
            ->exists()) {
            return back()->with('error', 'Student already enrolled');
        }

        // Step 5: Create enrollment safely
        Enrollment::create([
            'user_id' => $studentId,
            'course_id' => $course->id,
            'status' => 'active',
            'enrolled_at' => now(),
        ]);

        return back()->with('success', 'Student enrolled successfully.');
    }
}
