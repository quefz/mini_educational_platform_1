
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
            </div>
        </header>
        <main>
            <div class="container">
                @yield('content')
            </div>
        </main>
        <footer>
            <p>Education platform {{ date('Y')}}</p>
            <p>Thank you for using our website</p>
        </footer>
    </body>
</html>
