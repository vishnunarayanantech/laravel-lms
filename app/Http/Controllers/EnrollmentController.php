<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Course;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;

use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function enroll(Course $course)
    {

    Enrollment::firstOrCreate([

    'user_id'=>auth()->id(),
    'course_id'=>$course->id

    ],[

    'status'=>'active',
    'enrolled_at'=>now()

    ]);

    return back();

    }

}
