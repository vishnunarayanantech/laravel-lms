@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Course Info (Main) -->
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="h-64 bg-gray-100 flex items-center justify-center relative">
                @if($course->thumbnail)
                    <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                @else
                    <div class="bg-blue-50 w-full h-full flex items-center justify-center">
                        <span class="text-blue-200 text-8xl font-bold">{{ substr($course->title, 0, 1) }}</span>
                    </div>
                @endif
                <div class="absolute top-6 left-6 bg-white/90 backdrop-blur px-3 py-1.5 rounded-lg text-xs font-bold text-gray-700 shadow-md uppercase tracking-wider">
                    {{ ucfirst($course->level ?? 'Mixed') }}
                </div>
            </div>
            
            <div class="p-8">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">{{ $course->title }}</h1>
                
                <div class="flex items-center space-x-6 mb-8 py-4 border-y border-gray-50">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold mr-3">
                            {{ substr($course->teacher->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Teacher</p>
                            <p class="text-sm font-bold text-gray-900">{{ $course->teacher->name }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Last Updated</p>
                        <p class="text-sm font-bold text-gray-900">{{ $course->updated_at->format('M Y') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Students</p>
                        <p class="text-sm font-bold text-gray-900">{{ $course->enrollments_count ?? $course->students()->count() }}</p>
                    </div>
                </div>

                <div class="prose max-w-none text-gray-700 leading-relaxed mb-10">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Description</h3>
                    {!! nl2br(e($course->description)) !!}
                </div>

                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Course Curriculum
                    </h3>
                    
                    <div class="space-y-3">
                        @forelse($course->lessons as $lesson)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100 hover:border-blue-200 transition group">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-gray-500 font-bold text-sm mr-4 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition">
                                        {{ $loop->iteration }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 group-hover:text-blue-600 transition">{{ $lesson->title }}</p>
                                        <p class="text-xs text-gray-500">{{ $lesson->duration }} mins</p>
                                    </div>
                                </div>
                                @if($isEnrolled)
                                    <a href="{{ route('lessons.show', [$course, $lesson]) }}" class="text-blue-600 font-bold text-sm hover:underline">
                                        Start
                                    </a>
                                @elseif($lesson->is_free)
                                    <span class="text-green-600 font-bold text-xs bg-green-50 px-2 py-1 rounded">FREE PREVIEW</span>
                                @else
                                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </div>
                        @empty
                            <p class="text-gray-500 italic">No lessons added to this course yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar (Action) -->
    <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 sticky top-8">
            <div class="mb-6">
                <span class="text-4xl font-extrabold text-gray-900">
                    {{ $course->price > 0 ? '$' . number_format($course->price, 2) : 'FREE' }}
                </span>
                @if($course->price > 0)
                    <span class="text-gray-400 line-through ml-2 text-lg font-medium">$199.99</span>
                @endif
            </div>

            @if($isEnrolled)
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6 text-center">
                    <p class="text-blue-700 font-bold flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        You are enrolled!
                    </p>
                </div>
                @if($course->lessons->count() > 0)
                    <a href="{{ route('lessons.show', [$course, $course->lessons->first()]) }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition shadow-md hover:shadow-lg">
                        Continue Learning
                    </a>
                @endif
            @else
                @auth
                    @if(in_array(auth()->user()->role, ['admin', 'teacher']))
                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 mb-6">
                            <h4 class="text-blue-800 font-bold mb-4">Enroll a Student</h4>
                            <form action="{{ route('courses.enroll', $course) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="user_id" class="block text-xs font-bold text-blue-600 uppercase mb-2">Select Student</label>
                                    <select name="user_id" id="user_id" required class="w-full bg-white border border-blue-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                                        <option value="">Choose a student...</option>
                                        @foreach($students as $student)
                                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition shadow-md hover:shadow-lg">
                                    Enroll into Course
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-4 mb-6 text-center">
                            <p class="text-yellow-700 text-sm font-medium">
                                You must be enrolled by a teacher or administrator to access this course.
                            </p>
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition shadow-md hover:shadow-lg mb-4">
                        Login to Enroll
                    </a>
                @endauth
                <p class="text-center text-xs text-gray-500">30-Day Money-Back Guarantee</p>
            @endif

            <hr class="my-8">

            <div class="space-y-4">
                <h4 class="font-bold text-gray-900">This course includes:</h4>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Full lifetime access
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Certificate of completion
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Downloadable resources
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
