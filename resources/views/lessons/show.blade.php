@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Breadcrumbs -->
    <nav class="flex mb-8 text-sm" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('courses.index') }}" class="text-gray-500 hover:text-blue-600 font-medium">Courses</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <a href="{{ route('courses.show', $course) }}" class="ml-1 text-gray-500 hover:text-blue-600 font-medium md:ml-2">{{ $course->title }}</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="ml-1 text-gray-900 font-bold md:ml-2 line-clamp-1">{{ $lesson->title }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-1 space-y-4">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden sticky top-8">
                <div class="p-6 border-b border-gray-100 bg-gray-50">
                    <h3 class="font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        Course Curriculum
                    </h3>
                </div>
                <div class="max-h-[60vh] overflow-y-auto">
                    @foreach($course->lessons as $l)
                        <a href="{{ route('lessons.show', [$course, $l]) }}" 
                           class="flex items-center p-4 hover:bg-gray-50 transition border-b border-gray-50 last:border-0 {{ $l->id === $lesson->id ? 'bg-blue-50 border-l-4 border-l-blue-600' : '' }}">
                            <div class="w-6 h-6 rounded-full {{ $l->id === $lesson->id ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-400' }} flex-shrink-0 flex items-center justify-center text-[10px] font-bold mr-3">
                                {{ $loop->iteration }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold {{ $l->id === $lesson->id ? 'text-blue-700' : 'text-gray-700' }} truncate">{{ $l->title }}</p>
                                <p class="text-[10px] text-gray-400">{{ $l->duration }} mins</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3 space-y-6">
            <div class="bg-white rounded-3xl shadow-lg border border-gray-200 overflow-hidden">
                <!-- Video/Media Header -->
                @if($lesson->video_url)
                    @php
                        $url = $lesson->video_url;
                        preg_match('/(youtu\.be\/|v=|embed\/)([a-zA-Z0-9_-]+)/', $url, $matches);
                        $videoId = $matches[2] ?? null;
                        $embedUrl = $videoId ? "https://www.youtube.com/embed/".$videoId : $url;
                    @endphp
                    <div class="aspect-video bg-black relative">
                        <iframe class="absolute inset-0 w-full h-full" src="{{ $embedUrl }}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                @else
                    <div class="h-2 bg-blue-600"></div>
                @endif

                <div class="p-8 lg:p-12">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-3xl font-black text-gray-900 tracking-tight mb-2">{{ $lesson->title }}</h2>
                            <div class="flex items-center text-sm font-medium text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $lesson->duration }} minutes
                            </div>
                        </div>

                        <!-- Completion Toggle -->
                        <div class="flex-shrink-0">
                            @if($progress && $progress->completed)
                                <div class="flex items-center px-4 py-2 bg-green-50 text-green-700 rounded-xl font-bold border border-green-100 animate-pulse">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Completed
                                </div>
                            @else
                                <form action="{{ route('lessons.complete', [$course, $lesson]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition shadow-md hover:shadow-lg">
                                        Mark as Finished
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="prose max-w-none text-gray-700 leading-relaxed bg-gray-50 p-6 rounded-2xl border border-gray-100">
                        {!! nl2br(e($lesson->content)) !!}
                    </div>

                    <!-- Navigation Footer -->
                    <div class="mt-12 pt-8 border-t border-gray-100 flex items-center justify-between">
                        @php
                            $currentIndex = $course->lessons->search(fn($l) => $l->id === $lesson->id);
                            $prevLesson = $course->lessons->get($currentIndex - 1);
                            $nextLesson = $course->lessons->get($currentIndex + 1);
                        @endphp

                        @if($prevLesson)
                            <a href="{{ route('lessons.show', [$course, $prevLesson]) }}" class="flex items-center text-sm font-bold text-gray-600 hover:text-blue-600 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                Previous Lesson
                            </a>
                        @else
                            <div></div>
                        @endif

                        @if($nextLesson)
                            <a href="{{ route('lessons.show', [$course, $nextLesson]) }}" class="flex items-center text-sm font-bold text-gray-900 hover:text-blue-600 transition">
                                Next Lesson
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection