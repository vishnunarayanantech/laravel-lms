<h1>Courses</h1>

<a href="/courses/create">Add Course</a>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Teacher</th>
    <th>Action</th>
</tr>

@foreach($courses as $course)
<tr>
    <td>{{ $course->id }}</td>
    <td>{{ $course->title }}</td>
    <td>{{ $course->teacher->name }}</td>
    <td>
        <a href="/courses/{{ $course->id }}/edit">Edit</a>
   


<form action="/courses/{{ $course->id }}" method="POST" style="display:inline">

@csrf
@method('DELETE')

<button type="submit">Delete</button>

</form>


</tr>
@endforeach

</table>