<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
     public function index()
    {
        $user = Auth::user();

        $enrollments = $user->enrollments()
            ->with('course.lessons')
            ->get();

        return view('student.dashboard', [
            'enrollments' => $enrollments,
            'user' => $user
        ]);
    }
}
