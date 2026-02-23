<h1>Edit Course</h1>

<form method="POST" action="/courses/{{ $course->id }}">

@csrf
@method('PUT')

Title:
<input type="text" name="title" value="{{ $course->title }}"><br><br>

Slug:
<input type="text" name="slug" value="{{ $course->slug }}"><br><br>

Description:
<textarea name="description">{{ $course->description }}</textarea><br><br>

Teacher ID:
<input type="text" name="teacher_id" value="{{ $course->teacher_id }}"><br><br>

Status:
<select name="status">
<option value="published">Published</option>
<option value="draft">Draft</option>
</select>

<br><br>

<button type="submit">Update</button>

</form>