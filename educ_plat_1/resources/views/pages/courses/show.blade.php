@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href = '{{ route('index') }}'>Main page</a></li>
            <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses list</a></li>
            <li class="breadcrumb-item">{{ $course->title }}</li>
        </ol>
    </nav>

    @can('update', $course)
        <a href = '{{ route('courses.edit', $course) }}' class = 'btn btn-success mb-4'>Edit Course</a>
    @endcan

    <h2>Course {{ $course->title }}</h2>

    <h3>Description: {{ $course->description }}</h3>

    <div>{{ $course->thumbnail }}</div>

    <div>Level: {{ $course->level }}</div>

    <div>Price: {{ $course->price }}</div>

@endsection
