<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{

    public function index()
    {
        $courses = Course::latest()->get();

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|min:3',
            'description' => 'nullable'
        ]);

        Course::create([

            'title'=>$request->title,

            'slug'=>Str::slug($request->title),

            'description'=>$request->description,

            'teacher_id'=>1,

            'status'=>'published'

        ]);

        return redirect('/courses')
                ->with('success','Course Created');

    }

    public function edit(Course $course)
    {
        return view('courses.edit',compact('course'));
    }

    public function update(Request $request, Course $course)
    {

        $request->validate([
            'title'=>'required|min:3'
        ]);

        $course->update([

            'title'=>$request->title,

            'slug'=>Str::slug($request->title),

            'description'=>$request->description

        ]);

        return redirect('/courses')
                ->with('success','Updated');

    }

    public function destroy(Course $course)
    {

        $course->delete();

        return back()->with('success','Deleted');

    }

}