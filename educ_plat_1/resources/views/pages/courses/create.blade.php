@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Main page</a></li>
            <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses list</a></li>
            <li class="breadcrumb-item">Add Course</li>
        </ol>
    </nav>

    <form action = '{{ route('courses.store') }}' method = 'POST'>
        @csrf
        <h1>Add course</h1>

        @include('components.form.errors')

        @php
            $fields = [
                ['name' => 'title', 'label' => 'Name of the course'],
                ['name' => 'description', 'label' => 'Description'],
                ['name' => 'thumbnail', 'label' => 'Picture', 'type' => 'file'],
                ['name' => 'price', 'label' => 'Price']
            ];
        @endphp

        @foreach ($fields as $field)
            @include('components.form.fields.input', $field)
        @endforeach

        @include('components.form.fields.select', [
            'label' => 'Level of difficulty',
            'selected' => $course->level ?? null
        ])

        <button type = 'submit' class = 'btn btn-success'>Add Course</button>
    </form>
@endsection
