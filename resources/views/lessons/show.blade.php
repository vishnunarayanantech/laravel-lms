@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('courses.show', $course->id) }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Course
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
        <div class="p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $lesson->title }}</h1>
            
            <div class="prose max-w-none text-gray-700 mb-8">
                {!! nl2br(e($lesson->content)) !!}
            </div>

            <hr class="my-8">

            <div class="flex items-center justify-between">
                <div>
                    @if($progress && $progress->completed)
                        <div class="flex items-center text-green-600 font-bold">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Lesson Completed
                        </div>
                    @else
                        <form action="{{ route('lessons.complete', [$course->slug, $lesson->slug]) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 shadow-md">
                                Mark Complete
                            </button>
                        </form>
                    @endif
                </div>

                <div class="text-sm text-gray-500">
                    Duration: {{ $lesson->duration }} minutes
                </div>
            </div>
        </div>
    </div>
</div>
@endsection