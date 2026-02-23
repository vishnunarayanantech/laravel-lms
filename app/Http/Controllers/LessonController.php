<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\LessonProgress;


class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, Lesson $lesson)
    {

    $user = auth()->user();

    $progress = LessonProgress::where('user_id',$user->id)
                ->where('lesson_id',$lesson->id)
                ->first();

    return view('lessons.show',[

    'course'=>$course,
    'lesson'=>$lesson,
    'progress'=>$progress

    ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        //
    }
    public function complete(Course $course, Lesson $lesson)
    {

    LessonProgress::updateOrCreate(

        [
            'user_id'=>auth()->id(),
            'lesson_id'=>$lesson->id
        ],

        [
            'completed'=>true,
            'completed_at'=>now()
        ]

    );

    return back();

    }
}
