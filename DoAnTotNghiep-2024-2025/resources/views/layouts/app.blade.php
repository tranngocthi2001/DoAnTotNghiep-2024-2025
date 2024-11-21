<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản lý hệ thống')</title>
    {{-- //<link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
</head>
<body>
    <header>
        <h1>Hệ thống quản lý</h1>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <p>Bản quyền © 2024</p>
    </footer>
</body>
</html>
