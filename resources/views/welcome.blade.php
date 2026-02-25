@extends('layouts.app')

@section('content')
<div class="text-center mb-16">
    <h1 class="text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">
        Master Your Skills with <span class="text-blue-600">Laravel LMS</span>
    </h1>
    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
        Join over 10,000 students learning from industry experts. Start your journey today with our curated selection of professional courses.
    </p>
    @guest
        <div class="mt-8 space-x-4">
            <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-bold text-white uppercase tracking-widest hover:bg-blue-700 transition duration-150">
                Get Started for Free
            </a>
            <a href="{{ route('courses.index') }}" class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-lg font-bold text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition duration-150 shadow-sm">
                Browse Courses
            </a>
        </div>
    @else
        <div class="mt-8">
            @php
                $dashboardRoute = route('dashboard');
                if(auth()->user()->role === 'teacher') $dashboardRoute = route('teacher.dashboard');
                if(auth()->user()->role === 'admin') $dashboardRoute = route('admin.dashboard');
            @endphp
            <a href="{{ $dashboardRoute }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-bold text-white uppercase tracking-widest hover:bg-blue-700 transition duration-150">
                Go to Dashboard
            </a>
        </div>
    @endguest
</div>

<div class="mb-12">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Featured Courses</h2>
        <a href="{{ route('courses.index') }}" class="text-blue-600 font-semibold hover:underline flex items-center">
            View All Courses
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($courses as $course)
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-200 overflow-hidden flex flex-col">
                <div class="h-48 bg-gray-100 flex items-center justify-center relative overflow-hidden">
                    @if($course->thumbnail)
                        <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="bg-blue-50 w-full h-full flex items-center justify-center">
                            <span class="text-blue-200 text-6xl font-bold">{{ substr($course->title, 0, 1) }}</span>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-2 py-1 rounded-md text-xs font-bold text-gray-700 shadow-sm">
                        {{ ucfirst($course->level ?? 'Mixed') }}
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $course->title }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                        {{ $course->description }}
                    </p>
                    <div class="mt-auto flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs mr-2">
                                {{ substr($course->teacher->name, 0, 1) }}
                            </div>
                            <span class="text-xs text-gray-500 font-medium whitespace-nowrap">by {{ $course->teacher->name }}</span>
                        </div>
                        <span class="text-lg font-bold text-gray-900">
                            {{ $course->price > 0 ? '$' . number_format($course->price, 2) : 'FREE' }}
                        </span>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('courses.show', $course) }}" class="block w-full text-center bg-gray-50 hover:bg-gray-100 text-blue-600 font-bold py-2 rounded-lg border border-gray-200 transition">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="bg-blue-600 rounded-2xl p-8 lg:p-12 text-center text-white relative overflow-hidden shadow-xl">
    <div class="relative z-10">
        <h2 class="text-3xl font-bold mb-4">Ready to start learning?</h2>
        <p class="text-blue-100 mb-8 text-lg max-w-xl mx-auto">
            Get unlimited access to specialized courses and start building your future today.
        </p>
        <a href="{{ route('register') }}" class="inline-block bg-white text-blue-600 font-bold px-8 py-3 rounded-xl hover:bg-blue-50 transition shadow-lg">
            Create Free Account
        </a>
    </div>
    <!-- Decor element -->
    <div class="absolute -top-12 -right-12 w-64 h-64 bg-blue-500 rounded-full opacity-20"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-400 rounded-full opacity-20"></div>
</div>
@endsection
