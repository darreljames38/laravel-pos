<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'SystemHub')
    </title>

    <link
        rel="stylesheet"
        href="{{ asset('css/app.css') }}"
    >

    @stack('styles')
</head>

<body>
    {{-- Shared SystemHub navigation --}}
    @include('layouts.navigation')

    {{-- Page content --}}
    <main class="container">
        @yield('content')
    </main>

    {{-- Shared footer --}}
    <footer class="site-footer">
        <p>
            &copy; {{ date('Y') }} SystemHub.
            Developed by Darrel James Sanchez.
        </p>
    </footer>

    @stack('scripts')
</body>
</html>