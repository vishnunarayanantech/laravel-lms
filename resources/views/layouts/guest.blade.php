<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Outfit', sans-serif; }
            .bg-pattern {
                background-color: #f8fafc;
                background-image: radial-gradient(#2563eb 0.5px, transparent 0.5px), radial-gradient(#2563eb 0.5px, #f8fafc 0.5px);
                background-size: 20px 20px;
                background-position: 0 0, 10px 10px;
                opacity: 0.05;
            }
        </style>
    </head>
    <body class="antialiased text-gray-900">
        <div class="relative min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50 overflow-hidden">
            <!-- Decoration -->
            <div class="absolute inset-0 bg-pattern"></div>
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-100 rounded-full blur-3xl opacity-50"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-indigo-100 rounded-full blur-3xl opacity-50"></div>

            <div class="relative z-10 w-full max-w-md">
                <div class="text-center mb-8">
                    <a href="/" class="inline-flex items-center text-3xl font-black text-blue-600 tracking-tighter">
                        LMS<span class="text-gray-900">PORTAL</span>
                    </a>
                </div>

                <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 overflow-hidden">
                    <div class="p-8 sm:p-10">
                        {{ $slot }}
                    </div>
                </div>
                
                <p class="mt-8 text-center text-sm text-gray-500">
                    &copy; {{ date('Y') }} Laravel LMS. All rights reserved.
                </p>
            </div>
        </div>
    </body>
</html>
