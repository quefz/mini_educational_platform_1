
<html>
    <head>
        <title>{{ config('app.name') }}</title>
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        <header>
            <div class = 'container'>
                <div class = 'title'>
                    {{ config('app.name') }}
                </div>
                    <nav>
                        <ul>
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login.show') }}">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register.show') }}">Register</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <span class="nav-link">{{ Auth::user()->name }}</span>
                                </li>
                                <li class="nav-item">
                                    <form method="POST" action="{{ route('login.logout') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-link nav-link">Logout</button>
                                    </form>
                                </li>
                            @endguest
                        </ul>
                    </nav>
                </div>
        </header>
        <main>
            <div class="container">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
        <footer>
            <p>Thank you for using our website!</p>
            <p>Education platform {{ date('Y')}}.</p>
        </footer>
    </body>
</html>
