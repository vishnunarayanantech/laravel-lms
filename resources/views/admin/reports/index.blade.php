@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Platform Reports</h1>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
        <p class="text-sm font-medium text-gray-500 uppercase tracking-widest mb-1">Total Users</p>
        <p class="text-3xl font-bold text-gray-900">{{ number_format($totalUsers) }}</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
        <p class="text-sm font-medium text-gray-500 uppercase tracking-widest mb-1">Total Courses</p>
        <p class="text-3xl font-bold text-gray-900">{{ number_format($totalCourses) }}</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
        <p class="text-sm font-medium text-gray-500 uppercase tracking-widest mb-1">Total Enrollments</p>
        <p class="text-3xl font-bold text-gray-900">{{ number_format($totalEnrollments) }}</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <h2 class="text-lg font-bold text-gray-900">Top Courses by Enrollments</h2>
    </div>
    <table class="w-full text-left text-sm text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
            <tr>
                <th scope="col" class="px-6 py-3">Course Title</th>
                <th scope="col" class="px-6 py-3">Teacher</th>
                <th scope="col" class="px-6 py-3 text-right">Total Enrollments</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topCourses as $course)
            <tr class="bg-white border-b border-gray-100 hover:bg-gray-50">
                <td class="px-6 py-4 font-bold text-gray-900 line-clamp-1">{{ $course->title }}</td>
                <td class="px-6 py-4">{{ $course->teacher->name ?? 'Unknown' }}</td>
                <td class="px-6 py-4 text-right font-bold text-blue-600">{{ $course->enrollments_count }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="px-6 py-4 text-center text-gray-500">No data available.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
