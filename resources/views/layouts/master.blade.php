<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyApp')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    

    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #fff;
            border-right: 1px solid #dee2e6;
            min-height: calc(100vh - 56px); /* minus header height */
            padding-top: 20px;
        }

        .sidebar .list-group-item {
            border: none;
            border-radius: 0;
        }

        .content-area {
            flex-grow: 1;
            padding: 20px;
        }

        footer {
            background: #f8f9fa;
            text-align: center;
            padding: 10px 0;
            border-top: 1px solid #dee2e6;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    @include('layouts.header')

    {{-- Sidebar + Content --}}
    <div class="main-content">
        <div class="sidebar">
            @include('layouts.sidebar')
        </div>

        <div class="content-area">
            @yield('content')
        </div>
    </div>

    {{-- Footer --}}
    @include('layouts.footer')

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
