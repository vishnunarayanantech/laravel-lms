@extends('layouts.admin')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Manage Enrollments</h1>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-left text-sm text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
            <tr>
                <th scope="col" class="px-6 py-3">ID</th>
                <th scope="col" class="px-6 py-3">Student Name</th>
                <th scope="col" class="px-6 py-3">Course Name</th>
                <th scope="col" class="px-6 py-3">Enrollment Date</th>
                <th scope="col" class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($enrollments as $enrollment)
            <tr class="bg-white border-b border-gray-100 hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-900">{{ $enrollment->id }}</td>
                <td class="px-6 py-4 font-bold text-gray-900">{{ $enrollment->user->name ?? 'Unknown' }}</td>
                <td class="px-6 py-4">{{ $enrollment->course->title ?? 'Unknown' }}</td>
                <td class="px-6 py-4">{{ $enrollment->created_at->format('M d, Y') }}</td>
                <td class="px-6 py-4 flex items-center space-x-3">
                    <form action="{{ route('admin.enrollments.destroy', $enrollment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to remove this enrollment?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-medium text-red-600 hover:underline">Remove</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No enrollments available.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
