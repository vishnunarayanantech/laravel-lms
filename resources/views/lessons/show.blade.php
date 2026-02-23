@extends('layouts.app')

@section('content')

<h1>

{{ $lesson->title }}

</h1>


<hr>


<h3>

Lesson Content

</h3>

<p>

{{ $lesson->content }}

</p>


<hr>


@if($progress && $progress->completed)

<h3>

✔ Completed

</h3>

@else

<form method="POST"
action="{{ route('lessons.complete',
[$course,$lesson]) }}">

@csrf

<button type="submit">

Mark Complete

</button>

</form>

@endif


@endsection