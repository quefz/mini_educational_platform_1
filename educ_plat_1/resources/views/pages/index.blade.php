@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Main page</li>
        </ol>
    </nav>
    <div class="btn-group-vertical mt-4 mb-4 ms-3">
        <a href = "{{ route('courses.index')}}" class = "btn btn-primary">Go to courses</a>
    </div>
@endsection
