@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard Overview</h1>
    <p class="text-gray-600">Welcome to the LMS Administration Panel.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Users -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex items-center">
        <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mr-4">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-widest mb-1">Users</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($totalUsers) }}</p>
        </div>
    </div>

    <!-- Total Courses -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex items-center">
        <div class="w-14 h-14 rounded-xl bg-green-50 text-green-600 flex items-center justify-center mr-4">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-widest mb-1">Courses</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($totalCourses) }}</p>
        </div>
    </div>

    <!-- Total Lessons -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex items-center">
        <div class="w-14 h-14 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mr-4">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-widest mb-1">Lessons</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($totalLessons) }}</p>
        </div>
    </div>

    <!-- Total Enrollments -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex items-center">
        <div class="w-14 h-14 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mr-4">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-widest mb-1">Enrollments</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($totalEnrollments) }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Users -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
            <h2 class="text-lg font-bold text-gray-900">Recent Users</h2>
            <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">View All</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recentUsers as $user)
            <div class="px-6 py-4 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold mr-4">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : ($user->role === 'teacher' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
            @empty
            <div class="px-6 py-4 text-center text-sm text-gray-500">No users found.</div>
            @endforelse
        </div>
    </div>

    <!-- Recent Courses -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
            <h2 class="text-lg font-bold text-gray-900">Recent Courses</h2>
            <a href="{{ route('admin.courses.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">View All</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recentCourses as $course)
            <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-bold text-gray-900 line-clamp-1">{{ $course->title }}</p>
                    <p class="text-xs text-gray-500">By {{ $course->teacher->name ?? 'Unknown' }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $course->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($course->status) }}
                    </span>
                    <span class="text-xs font-medium text-gray-900 bg-gray-100 px-2 py-1 rounded">
                        {{ $course->price > 0 ? '$'.number_format($course->price, 2) : 'Free' }}
                    </span>
                </div>
            </div>
            @empty
            <div class="px-6 py-4 text-center text-sm text-gray-500">No courses found.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
