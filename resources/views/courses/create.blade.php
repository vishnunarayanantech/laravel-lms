<h1>Add Course</h1>

@if($errors->any())

<div style="color:red">

<ul>

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif

<form method="POST" action="/courses">

@csrf

Title:
<input type="text" name="title"><br><br>

Slug:
<input type="text" name="slug"><br><br>

Description:
<textarea name="description"></textarea><br><br>

Teacher ID:
<input type="text" name="teacher_id" value="1"><br><br>

Status:
<select name="status">
<option value="published">Published</option>
<option value="draft">Draft</option>
</select>

<br><br>

<button type="submit">Save</button>

</form>