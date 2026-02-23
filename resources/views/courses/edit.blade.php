<!DOCTYPE html>
<html>

<head>

<title>Edit Course</title>

@vite(['resources/css/app.css'])

</head>

<body class="bg-gray-100">

<div class="max-w-xl mx-auto mt-10 bg-white p-6 shadow">

<h2 class="text-2xl mb-6">

Edit Course

</h2>

<form method="POST"
action="/courses/{{$course->id}}">

@csrf

@method('PUT')

<input type="text"
name="title"
value="{{$course->title}}"
class="border p-2 w-full mb-4">

<textarea
name="description"
class="border p-2 w-full mb-4">

{{$course->description}}

</textarea>

<button class="bg-blue-600 text-black px-4 py-2">

Update
</button>
</form>
</div>
</body>
</html>