@extends('layouts.admin')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Manage Courses</h1>
    <a href="{{ route('admin.courses.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700">Add New Course</a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-left text-sm text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
            <tr>
                <th scope="col" class="px-6 py-3">ID</th>
                <th scope="col" class="px-6 py-3">Title</th>
                <th scope="col" class="px-6 py-3">Teacher</th>
                <th scope="col" class="px-6 py-3">Enrollments</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses as $course)
            <tr class="bg-white border-b border-gray-100 hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-900">{{ $course->id }}</td>
                <td class="px-6 py-4 font-bold text-gray-900 line-clamp-1">{{ $course->title }}</td>
                <td class="px-6 py-4">{{ $course->teacher->name ?? 'None' }}</td>
                <td class="px-6 py-4">{{ $course->enrollments_count }}</td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $course->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($course->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 flex items-center space-x-3">
                    <a href="{{ route('admin.courses.edit', $course) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this course?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-medium text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No courses available.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
