<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::user();

        $courses = $teacher->courses()
            ->withCount('enrollments')
            ->get();

        return view('teacher.dashboard', [
            'courses' => $courses
        ]);
    }
}
