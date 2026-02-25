@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-900">Create New User</h1>
    <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700">&larr; Back to Users</a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden max-w-2xl">
    <form action="{{ route('admin.users.store') }}" method="POST" class="p-8 space-y-6">
        @csrf
        
        <div>
            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Full Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                   class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3">
        </div>

        <div>
            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                   class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3">
        </div>

        <div>
            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password</label>
            <input type="password" name="password" id="password" required 
                   class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3">
        </div>

        <div>
            <label for="role" class="block text-sm font-bold text-gray-700 mb-2">Role</label>
            <select name="role" id="role" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3">
                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-3 text-center transition">
            Create User
        </button>
    </form>
</div>
@endsection
