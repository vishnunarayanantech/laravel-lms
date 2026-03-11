<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\Request;

class AdminLessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::with('course')->latest()->paginate(10);
        return view('admin.lessons.index', compact('lessons'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.lessons.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:lessons,slug',
            'course_id' => 'required|exists:courses,id',
            'video_url' => 'required|url',
            'content' => 'required',
            'duration' => 'required|numeric',
            'order' => 'required|numeric'
        ]);

        $data = $request->all();
        $data['is_free'] = $request->has('is_free');

        Lesson::create($data);

        return redirect()->route('admin.lessons.index')->with('success', 'Lesson created successfully.');
    }

    public function edit(Lesson $lesson)
    {
        $courses = Course::all();
        return view('admin.lessons.edit', compact('lesson', 'courses'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:lessons,slug,' . $lesson->id,
            'course_id' => 'required|exists:courses,id',
            'video_url' => 'required|url',
            'content' => 'required',
            'duration' => 'required|numeric',
            'order' => 'required|numeric'
        ]);

        $data = $request->all();
        $data['is_free'] = $request->has('is_free');

        $lesson->update($data);

        return redirect()->route('admin.lessons.index')->with('success', 'Lesson updated successfully.');
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('admin.lessons.index')->with('success', 'Lesson deleted successfully.');
    }
}
