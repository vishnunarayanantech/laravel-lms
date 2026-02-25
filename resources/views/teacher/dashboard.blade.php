@extends('layouts.app')

@section('content')
<div class="mb-12">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Teacher Dashboard</h1>
            <p class="text-gray-600 mt-2">Manage your courses and track student performance.</p>
        </div>
        <a href="{{ route('courses.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-bold text-white uppercase tracking-widest hover:bg-blue-700 transition shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create New Course
        </a>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 italic">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Courses</p>
            <p class="text-3xl font-extrabold text-gray-900">{{ $courses->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 italic">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Students</p>
            <p class="text-3xl font-extrabold text-gray-900">{{ $courses->sum('enrollments_count') }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 italic">
            <p class="text-xs font-bold text-green-400 uppercase tracking-wider mb-1">Published</p>
            <p class="text-3xl font-extrabold text-gray-900">{{ $courses->where('status', 'published')->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 italic">
            <p class="text-xs font-bold text-yellow-400 uppercase tracking-wider mb-1">Drafts</p>
            <p class="text-3xl font-extrabold text-gray-900">{{ $courses->where('status', '!=', 'published')->count() }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Course Info</th>
                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Engagement</th>
                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-8 py-5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($courses as $course)
                        <tr class="hover:bg-gray-50/50 transition duration-150">
                            <td class="px-8 py-5">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-lg mr-4 border border-blue-100">
                                        {{ substr($course->title, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">{{ $course->title }}</div>
                                        <div class="text-xs text-gray-400">Created {{ $course->created_at->format('M d, Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-2">
                                    <div class="flex -space-x-2">
                                        @for($i = 0; $i < min($course->enrollments_count, 3); $i++)
                                            <div class="w-6 h-6 rounded-full bg-gray-200 border-2 border-white flex items-center justify-center text-[10px] font-bold text-gray-500">
                                                U
                                            </div>
                                        @endfor
                                    </div>
                                    <span class="text-sm font-medium text-gray-600">{{ $course->enrollments_count }} Students</span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $course->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($course->status) }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-4">
                                    <a href="{{ route('courses.edit', $course) }}" class="text-blue-600 hover:text-blue-900 font-bold">Edit</a>
                                    <a href="{{ route('courses.show', $course) }}" class="text-gray-400 hover:text-gray-900 font-bold">View</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <p class="text-gray-500 font-medium">You haven't created any courses yet.</p>
                                <a href="{{ route('courses.create') }}" class="text-blue-600 font-bold hover:underline mt-2 inline-block">Start by creating your first course</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
