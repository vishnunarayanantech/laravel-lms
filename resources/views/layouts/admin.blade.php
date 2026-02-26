<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Laravel LMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 antialiased font-sans text-gray-900">

    <!-- Screen Wrapper -->
    <div class="flex h-screen overflow-hidden w-full">

        <!-- Sidebar (Fixed Width & No Overflow Clipping onto it) -->
        <aside class="w-64 bg-gray-900 text-white flex-shrink-0 flex flex-col z-30 shadow-xl hidden md:flex">
            <!-- Logo Header -->
            <div class="h-16 flex items-center px-6 border-b border-gray-800">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-white tracking-widest uppercase block w-full">
                    LMS Admin
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto block">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} rounded-lg transition-colors cursor-pointer relative z-40">
                    Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="block px-4 py-3 {{ request()->routeIs('admin.users.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} rounded-lg transition-colors cursor-pointer relative z-40">
                    Users
                </a>
                <a href="{{ route('admin.courses.index') }}" class="block px-4 py-3 {{ request()->routeIs('admin.courses.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} rounded-lg transition-colors cursor-pointer relative z-40">
                    Courses
                </a>
                <a href="{{ route('admin.lessons.index') }}" class="block px-4 py-3 {{ request()->routeIs('admin.lessons.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} rounded-lg transition-colors cursor-pointer relative z-40">
                    Lessons
                </a>
                <a href="{{ route('admin.enrollments.index') }}" class="block px-4 py-3 {{ request()->routeIs('admin.enrollments.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} rounded-lg transition-colors cursor-pointer relative z-40">
                    Enrollments
                </a>
                <a href="{{ route('admin.reports.index') }}" class="block px-4 py-3 {{ request()->routeIs('admin.reports.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} rounded-lg transition-colors cursor-pointer relative z-40">
                    Reports
                </a>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden w-full relative z-10">
            
            <!-- Topbar header -->
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-20 flex-shrink-0">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-gray-900 tracking-widest uppercase md:hidden">LMS Admin</span>
                </div>
                
                <div class="flex items-center space-x-4 ml-auto">
                    <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 transition cursor-pointer">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main Scrollable Body -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 z-0 pointer-events-auto">
                
                @if (session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow-sm">
                        <ul class="list-disc pl-5 m-0 pointer-events-none">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
                
            </main>
        </div>

    </div>

</body>
</html>
