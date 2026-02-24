@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">My Courses</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($enrollments as $enrollment)
            @php
                $course = $enrollment->course;
                $progress = $course->progressForUser($user->id);
            @endphp
            <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
                <h2 class="text-xl font-bold mb-2">{{ $course->title }}</h2>
                <p class="text-gray-600 mb-4">{{ Str::limit($course->description, 100) }}</p>
                
                <div class="mt-4">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium text-blue-700">Progress: {{ $progress }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('courses.show', $course->id) }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Go to Course
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    @if($enrollments->isEmpty())
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
            <p class="text-blue-700">You are not enrolled in any courses yet. <a href="/courses" class="font-bold underline">Browse Courses</a></p>
        </div>
    @endif
</div>
@endsection
