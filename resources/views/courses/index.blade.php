<!DOCTYPE html>
<html>
<head>

<title>Courses</title>

@vite(['resources/css/app.css'])

</head>

<body class="bg-gray-100">

<div class="max-w-5xl mx-auto mt-10">

<h1 class="text-3xl font-bold mb-6">

Courses

</h1>

<a href="/courses/create"
class="bg-blue-600 text-white px-4 py-2 rounded">

Add Course

</a>


@if(session('success'))

<div class="bg-green-200 p-3 mt-4">

{{ session('success') }}

</div>

@endif


<table class="w-full mt-6 bg-white shadow">

<tr class="bg-gray-200">

<th class="p-3 text-left">Title</th>

<th class="p-3">Actions</th>

</tr>


@foreach($courses as $course)

<tr class="border-t">

<td class="p-3">

{{ $course->title }}

</td>

<td class="p-3 text-center">

<a href="/courses/{{$course->id}}/edit"
class="text-blue-600">

Edit

</a>

<form method="POST"
action="/courses/{{$course->id}}"
class="inline">

@csrf

@method('DELETE')

<button class="text-red-600 ml-4">

Delete

</button>

</form>

</td>

</tr>

@endforeach

</table>

</div>

</body>
</html>