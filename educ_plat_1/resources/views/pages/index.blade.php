@extends('layouts.app')

@section('content')
    <div class="btn-group-vertical mt-4 mb-4 ms-3">
        <a href = "{{ route('courses.index')}}" class = "btn btn-primary">Go to courses</a>
    </div>
@endsection
