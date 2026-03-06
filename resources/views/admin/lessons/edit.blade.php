@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-900">Edit Lesson: {{ $lesson->title }}</h1>
    <a href="{{ route('admin.lessons.index') }}" class="text-gray-500 hover:text-gray-700">&larr; Back to Lessons</a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden max-w-4xl">
    <form action="{{ route('admin.lessons.update', $lesson) }}" method="POST" class="p-8 space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Lesson Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $lesson->title) }}" required 
                       class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3">
            </div>

            <div class="md:col-span-2">
                <label for="slug" class="block text-sm font-bold text-gray-700 mb-2">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $lesson->slug) }}" required 
                       class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3">
            </div>

            <div class="md:col-span-2">
                <label for="course_id" class="block text-sm font-bold text-gray-700 mb-2">Course</label>
                <select name="course_id" id="course_id" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3">
                    <option value="">Select a Course</option>
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id', $lesson->course_id) == $course->id ? 'selected' : '' }}>
                        {{ $course->title }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label for="video_url" class="block text-sm font-bold text-gray-700 mb-2">Video URL</label>
                <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $lesson->video_url) }}" required 
                       class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3">
            </div>

            <div class="md:col-span-2">
                <label for="content" class="block text-sm font-bold text-gray-700 mb-2">Lesson Content</label>
                <textarea name="content" id="content" rows="4" required 
                       class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3">{{ old('content', $lesson->content) }}</textarea>
            </div>

            <div>
                <label for="duration" class="block text-sm font-bold text-gray-700 mb-2">Duration (minutes)</label>
                <input type="number" step="1" name="duration" id="duration" value="{{ old('duration', $lesson->duration) }}" required
                       class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3">
            </div>

            <div>
                <label for="order" class="block text-sm font-bold text-gray-700 mb-2">Order/Sequence</label>
                <input type="number" step="1" name="order" id="order" value="{{ old('order', $lesson->order) }}" required
                       class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3">
            </div>

             <div class="col-span-2 flex items-center mt-2">
                <input id="is_free" type="checkbox" name="is_free" value="1" {{ old('is_free', $lesson->is_free) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                <label for="is_free" class="ml-2 text-sm font-bold text-gray-900">Free Preview Lesson?</label>
            </div>
        </div>

        <button type="submit" class="w-full mt-6 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-3 text-center transition">
            Update Lesson
        </button>
    </form>
</div>
@endsection
