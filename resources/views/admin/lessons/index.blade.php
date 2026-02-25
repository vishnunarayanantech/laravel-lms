@extends('layouts.admin')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Manage Lessons</h1>
    <a href="{{ route('admin.lessons.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700">Add New Lesson</a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-left text-sm text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
            <tr>
                <th scope="col" class="px-6 py-3">ID</th>
                <th scope="col" class="px-6 py-3">Title</th>
                <th scope="col" class="px-6 py-3">Course Name</th>
                <th scope="col" class="px-6 py-3">Created Date</th>
                <th scope="col" class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lessons as $lesson)
            <tr class="bg-white border-b border-gray-100 hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-900">{{ $lesson->id }}</td>
                <td class="px-6 py-4 font-bold text-gray-900 line-clamp-1">{{ $lesson->title }}</td>
                <td class="px-6 py-4">{{ $lesson->course->title ?? 'None' }}</td>
                <td class="px-6 py-4">{{ $lesson->created_at->format('M d, Y') }}</td>
                <td class="px-6 py-4 flex items-center space-x-3">
                    <a href="{{ route('admin.lessons.edit', $lesson) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this lesson?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-medium text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No lessons available.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
