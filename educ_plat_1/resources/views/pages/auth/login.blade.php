@extends('layouts.app')

@section('content')
    <div class = 'container'>
        <a href = '/' class = 'btn btn-primary mt-4 mb-3 ms-3'>Go home page</a>
        <div class = 'row justify-content-left mt-4'>
            <div class = 'col-md-6'>
                <div class = 'card'>
                    <div class = 'card-header'>Login<div>

                    <div class = 'card-body'>
                        <form method = 'POST' action = "{{ route('login.login') }}">
                            @csrf

                            <div class = 'mb-3'>
                                <label for="name" class="form-label">Name</label>
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}"
                                    required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                       name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()
