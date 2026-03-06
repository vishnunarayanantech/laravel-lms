<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalCourses = Course::count();
        $totalLessons = \App\Models\Lesson::count();
        $totalEnrollments = Enrollment::count();

        $recentUsers = User::latest()->limit(5)->get();
        $recentCourses = Course::latest()->limit(5)->get();
        $recentLessons = \App\Models\Lesson::latest()->with('course')->limit(5)->get();
        $recentEnrollments = Enrollment::latest()->with(['user', 'course'])->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalCourses', 'totalLessons', 'totalEnrollments',
            'recentUsers', 'recentCourses', 'recentLessons', 'recentEnrollments'
        ));
    }
}
