@extends('layouts.app')

@section('content')
<div class="mb-12">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Explore Courses</h1>
            <p class="text-gray-600 mt-2">Discover the perfect course to advance your career.</p>
        </div>
        
        @auth
            @if(auth()->user()->role === 'teacher' || auth()->user()->role === 'admin')
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.courses.create') : route('teacher.courses.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-bold text-white uppercase tracking-widest hover:bg-blue-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New Course
                </a>
            @endif
        @endauth
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($courses as $course)
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-200 overflow-hidden flex flex-col">
                <div class="h-48 bg-gray-100 flex items-center justify-center relative overflow-hidden">
                    @if($course->thumbnail)
                        <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="bg-blue-50 w-full h-full flex items-center justify-center">
                            <!-- <span class="text-blue-200 text-6xl font-bold">{{ substr($course->title, 0, 1) }}</span> -->
                        </div>
                    @endif
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-2 py-1 rounded-md text-xs font-bold text-gray-700 shadow-sm">
                        {{ ucfirst($course->level ?? 'Mixed') }}
                    </div>
                    @if($course->status !== 'published')
                        <div class="absolute top-4 left-4 bg-yellow-100/90 backdrop-blur px-2 py-1 rounded-md text-xs font-bold text-yellow-700 shadow-sm border border-yellow-200">
                            {{ ucfirst($course->status) }}
                        </div>
                    @endif
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-gray-900 line-clamp-1 flex-1">{{ $course->title }}</h3>
                        @auth
                            @if(auth()->user()->role === 'admin' || auth()->id() === $course->teacher_id)
                                <div class="flex items-center space-x-2 ml-2">
                                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.courses.edit', $course) : route('teacher.courses.edit', $course) }}" class="text-gray-400 hover:text-blue-600 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        @endauth
                    </div>
                    
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                        {{ $course->description }}
                    </p>
                    
                    <div class="mt-auto pt-4 border-t border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <span class="text-xs text-gray-400">by</span>
                                <span class="text-xs font-semibold text-gray-700 ml-1">{{ $course->teacher->name }}</span>
                            </div>
                            <span class="text-lg font-bold text-blue-600">
                                {{ $course->price > 0 ? '$' . number_format($course->price, 2) : 'FREE' }}
                            </span>
                        </div>
                        
                        <a href="{{ route('courses.show', $course) }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-lg transition shadow-sm">
                            View Course
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($courses->isEmpty())
        <div class="text-center py-20 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <h3 class="text-lg font-bold text-gray-900">No courses found</h3>
            <p class="text-gray-500">Check back later for new content.</p>
        </div>
    @endif
</div>
@endsection