@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mb-12">
    <div class="mb-8">
        <a href="{{ route('teacher.dashboard') }}" class="text-blue-600 hover:text-blue-800 flex items-center text-sm font-bold mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Dashboard
        </a>
        <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Edit Course</h1>
        <p class="text-gray-600 mt-2">Refine your course content and optimize for student engagement.</p>
    </div>

    <div class="bg-white rounded-3xl shadow-lg border border-gray-200 overflow-hidden">
        <form method="POST" action="{{ route('teacher.courses.update', $course) }}" class="p-8 lg:p-10 space-y-8">
            @csrf
            @method('PUT')

            <!-- Hidden Fields -->
            <input type="hidden" name="teacher_id" value="{{ $course->teacher_id }}">

            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Course Title</label>
                    <input type="text" name="title" id="title" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                           placeholder="e.g. Advanced Laravel Development" value="{{ old('title', $course->title) }}">
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-sm font-bold text-gray-700 mb-2">URL Slug</label>
                    <div class="flex items-center">
                        <span class="px-3 py-3 bg-gray-50 border border-r-0 border-gray-300 rounded-l-xl text-gray-500 text-sm">/courses/</span>
                        <input type="text" name="slug" id="slug" required
                               class="flex-1 px-4 py-3 rounded-r-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                               placeholder="advanced-laravel" value="{{ old('slug', $course->slug) }}">
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="5" required
                              class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                              placeholder="Describe what students will learn...">{{ old('description', $course->description) }}</textarea>
                </div>

                <!-- Meta Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="level" class="block text-sm font-bold text-gray-700 mb-2">Level</label>
                        <select name="level" id="level" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="beginner" {{ $course->level === 'beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate" {{ $course->level === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="advanced" {{ $course->level === 'advanced' ? 'selected' : '' }}>Advanced</option>
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-bold text-gray-700 mb-2">Publication Status</label>
                        <select name="status" id="status" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="draft" {{ $course->status === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ $course->status === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-bold text-gray-700 mb-2">Price ($)</label>
                    <input type="number" step="0.01" name="price" id="price" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                           placeholder="0.00 for FREE" value="{{ old('price', $course->price) }}">
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex items-center justify-between space-x-4">
                <button type="button" onclick="if(confirm('Are you sure you want to delete this course?')) document.getElementById('delete-course-form').submit();" 
                        class="text-red-500 hover:text-red-700 font-bold transition">Delete Course</button>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('teacher.dashboard') }}" class="px-6 py-3 font-bold text-gray-600 hover:text-gray-900 transition">Cancel</a>
                    <button type="submit" class="px-10 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition shadow-lg hover:shadow-xl">
                        Update Course
                    </button>
                </div>
            </div>
        </form>
        
        <form id="delete-course-form" action="{{ route('teacher.courses.destroy', $course) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection