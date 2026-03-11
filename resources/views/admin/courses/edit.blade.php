@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-900">Edit Course: {{ $course->title }}</h1>
    <a href="{{ route('admin.courses.index') }}" class="text-gray-500 hover:text-gray-700">&larr; Back to Courses</a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden max-w-4xl">
    <form action="{{ route('admin.courses.update', $course) }}" method="POST" class="p-8 space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $course->title) }}" required 
                       class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3">
            </div>

            <div class="md:col-span-2">
                <label for="slug" class="block text-sm font-bold text-gray-700 mb-2">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $course->slug) }}" required 
                       class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3">
            </div>

            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="4" required 
                       class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3">{{ old('description', $course->description) }}</textarea>
            </div>

            <div>
                <label for="teacher_id" class="block text-sm font-bold text-gray-700 mb-2">Assign Teacher</label>
                <select name="teacher_id" id="teacher_id" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3">
                    <option value="">Select a Teacher</option>
                    @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $course->teacher_id) == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }} ({{ $teacher->email }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                <select name="status" id="status" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3">
                    <option value="draft" {{ old('status', $course->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $course->status) == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>

            <div>
                <label for="price" class="block text-sm font-bold text-gray-700 mb-2">Price ($)</label>
                <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $course->price) }}" 
                       class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3">
            </div>

            <div>
                <label for="level" class="block text-sm font-bold text-gray-700 mb-2">Level</label>
                <input type="text" name="level" id="level" value="{{ old('level', $course->level) }}" 
                       class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3">
            </div>
        </div>

        <button type="submit" class="w-full mt-6 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-3 text-center transition">
            Update Course
        </button>
    </form>
</div>

<div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden max-w-4xl">
    <div class="p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Student Enrollment</h2>
        
        <form action="{{ route('admin.courses.enrollStudents', $course) }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="students" class="block text-sm font-bold text-gray-700 mb-2">Select Students</label>
                <select name="students[]" id="students" multiple required class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3 h-48">
                    @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                    @endforeach
                </select>
                <p class="mt-2 text-xs text-gray-500 italic">Hold Ctrl (Cmd) to select multiple students.</p>
            </div>
            
            <button type="submit" class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-bold rounded-lg text-sm px-5 py-3 text-center transition">
                Enroll Selected Students
            </button>
        </form>
    </div>
</div>

<div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden max-w-4xl">
    <div class="p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Enrolled Students</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3">Student Name</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enrolledStudents as $enrollment)
                    <tr class="bg-white border-b border-gray-100 hover:bg-gray-50">
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $enrollment->user->name ?? 'Unknown' }}</td>
                        <td class="px-6 py-4">{{ $enrollment->user->email ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $enrollment->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($enrollment->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">No students enrolled.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
