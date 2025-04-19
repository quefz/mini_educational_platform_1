@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Main page</a></li>
            <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses list</a></li>
            <li class="breadcrumb-item"><a href="{{ route('courses.show', $course) }}">{{ $course->title}}</a></li>
            <li class="breadcrumb-item">Edit Course</li>
        </ol>
    </nav>

    <form action = '{{ route('courses.update', $course) }}' method = 'POST' enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <h1>Edit Course</h1>

        @include('components.form.errors')

        @php
            $fields = [
                ['name' => 'title', 'label' => 'Name of the course', 'value' => $course->title],
                ['name' => 'description', 'label' => 'Description', 'value' => $course->description],
                ['name' => 'thumbnail', 'label' => 'Picture', 'type' => 'file'],
                ['name' => 'price', 'label' => 'Price', 'value' => $course->price]
            ];
        @endphp

        @foreach ($fields as $field)
            @include('components.form.fields.input', $field)
        @endforeach

        @include('components.form.fields.select', [
            'label' => 'Level of difficulty',
            'selected' => $course->level ?? null
        ])

        <button type = 'submit' class = 'btn btn-success'>Edit Course</button>
    </form>

@endsection
