@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href = '{{ route('index') }}'>Main page</a></li>
            <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses list</a></li>
            <li class="breadcrumb-item">{{ $course->title }}</li>
        </ol>
    </nav>
    <div class = 'mt-2'>
        @can('update', $course)
            <a href = '{{ route('courses.edit', $course) }}' class = 'btn btn-success'>Edit Course</a>
        @endcan

        @can('delete', $course)
            <form action = '{{ route('courses.destroy', $course) }}' method = 'POST' class = 'mt-2'>
                @csrf
                @method('delete')

                <label>Delete type</label>
                <select name = 'delete_type' class = 'form-control w-auto mt-2'>
                    <option value = 'soft'>Soft Delete</option>
                    <option value = 'force'>Complete removal</option>
                </select>
                <input type = 'submit' class = 'btn btn-danger mt-2'
                    onclick="return confirm('Are you sure?')">
            </form>
        @endcan
    </div>
    <h2>Course {{ $course->title }}</h2>

    <h3>Description: {{ $course->description }}</h3>

    <div class="course-thumbnail">
        @if($course->thumbnail)
            <img
                src="{{ asset('storage/' . $course->thumbnail) }}"
                alt="Course thumbnail"
                class="img-fluid"
            >
        @else
            <p>Without image</p>
        @endif
    </div>

    <div>Level: {{ $course->level }}</div>

    <div>Price: {{ $course->price }}</div>

@endsection
