@extends('layouts.app')

@section('content')
<div class="mb-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">My Courses</h1>
            <p class="text-gray-600 mt-2">Welcome back, {{ auth()->user()->name }}! Continue where you left off.</p>
        </div>
        <div class="hidden md:block">
            <span class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg font-bold text-sm border border-blue-100">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.394 2.827a1 1 0 00-.788 0l-7 3a1 1 0 000 1.846l7 3a1 1 0 00.788 0l7-3a1 1 0 000-1.846l-7-3zM3.106 8.11l3.393 1.454-3.393 1.454V8.11zM16.894 8.11v2.908l-3.393-1.454 3.393-1.454zM12 9.577l-2 1.454-2-1.454V11.22l2 1.454 2-1.454V9.577z" />
                </svg>
                Enrolled in {{ $enrollments->count() }} Courses
            </span>
        </div>
    </div>

    @if($enrollments->isEmpty())
        <div class="text-center py-24 bg-white rounded-3xl border shadow-sm">
            <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">No active enrollments</h2>
            <p class="text-gray-500 mb-8 max-w-sm mx-auto">Explore our catalog to find your next learning adventure.</p>
            <a href="{{ route('courses.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition shadow-lg">
                Browse All Courses
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($enrollments as $enrollment)
                @php
                    $course = $enrollment->course;
                    $progress = $course->progressForUser(auth()->id());
                @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col group hover:shadow-md transition duration-300">
                    <div class="h-40 bg-gray-100 relative overflow-hidden">
                        @if($course->thumbnail)
                            <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="bg-blue-50 w-full h-full flex items-center justify-center">
                                <span class="text-blue-200 text-5xl font-bold">{{ substr($course->title, 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="text-white text-xs font-bold bg-blue-600 px-2 py-1 rounded shadow-sm uppercase tracking-wider">
                                {{ ucfirst($course->level ?? 'Mixed') }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-1">{{ $course->title }}</h3>
                        <p class="text-gray-500 text-sm mb-6 line-clamp-2">{{ $course->description }}</p>
                        
                        <div class="mt-auto">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-bold text-gray-700">Course Progress</span>
                                <span class="text-xs font-bold text-blue-600">{{ $progress }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 mb-6 overflow-hidden">
                                <div class="bg-blue-600 h-full rounded-full transition-all duration-1000" style="width: {{ $progress }}%"></div>
                            </div>
                            
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('courses.show', $course) }}" class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-lg transition text-sm shadow-sm group-hover:shadow-md">
                                    {{ $progress > 0 ? 'Continue' : 'Start' }} Course
                                </a>
                                @if($progress == 100)
                                    <div class="p-2.5 bg-green-50 text-green-600 rounded-lg border border-green-100" title="Completed">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
