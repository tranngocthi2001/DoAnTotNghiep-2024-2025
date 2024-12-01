<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản lý hệ thống')</title>
    {{-- //<link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .header {
            background-color: #343a40;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            padding: 20px;
            justify-content: center;
        }
        .card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 10px;
            width: 200px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card h3 {
            margin: 0;
            padding: 15px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border-radius: 8px 8px 0 0;
        }
        .card a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #007bff;
        }
        .card a:hover {
            background-color: #f1f1f1;
        }
    </style>
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
