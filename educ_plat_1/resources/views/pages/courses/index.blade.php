@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href = '{{ route('index') }}'>Main page</a></li>
            <li class="breadcrumb-item">Courses List</li>
        </ol>
    </nav>
    <div class="btn-group-vertical mt-4 mb-4 ms-3">
        @auth
        <a href = "{{ route('courses.create') }}" class = 'btn btn-success mt-2'>Add course</a>
        @endauth
    </div>
    <table class = 'table'>
        <thead>
            <tr>
                <th scope = 'col'>Id</th>
                <th scope = 'col'>Title</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
                <tr>
                    <td>{{ $course->id }}</td>
                    <td>
                        <a href = "{{ route('courses.show', $course) }}"
                            class = 'btn btn-primary btn-sm'>{{ $course->title }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
