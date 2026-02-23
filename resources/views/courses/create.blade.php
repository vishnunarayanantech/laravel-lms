<!DOCTYPE html>
<html>

<head>

<title>Create Course</title>

@vite(['resources/css/app.css'])

</head>

<body class="bg-gray-100">

<div class="max-w-xl mx-auto mt-10 bg-white p-6 shadow">

<h2 class="text-2xl mb-6">

Create Course

</h2>

<form method="POST" action="/courses">

@csrf

<input type="text"
name="title"
placeholder="Course Title"
class="border p-2 w-full mb-4">

<textarea
name="description"
placeholder="Description"
class="border p-2 w-full mb-4">

</textarea>

<button class="bg-blue-600 text-black px-4 py-2">

Save

</button>

</form>

</div>

</body>
</html>