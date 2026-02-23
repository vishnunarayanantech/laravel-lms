<!DOCTYPE html>
<html>
<head>

<title>Laravel LMS</title>

@vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gray-100">

<div class="flex">

<!-- Sidebar -->

<div class="w-64 bg-gray-800 text-white min-h-screen p-5">

<h2 class="text-xl font-bold mb-6">
Laravel LMS
</h2>

<ul>

<li class="mb-3">
<a href="/courses" class="hover:text-gray-300">
Courses
</a>
</li>

</ul>

</div>


<!-- Content -->

<div class="flex-1 p-10">

@yield('content')

</div>

</div>

</body>

</html>