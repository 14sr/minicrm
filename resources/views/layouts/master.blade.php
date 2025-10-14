<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyApp')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css.map') }}">
        <!-- <link rel="stylesheet" href="{{ asset('assets/css/icon.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/icon.min.css.map') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/icon.min.css') }}"> -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.min.css.map') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/icons/tabler-icons/tabler-icons.css') }}">


        <link rel="stylesheet" href="{{ asset('assets/css/icons/tabler-icons/tabler-icons.css') }}">

        <!-- @font-face {
            font-family: 'Tabler Icons';
            src: url('../../fonts/tabler-icons.woff2') format('woff2'),
                url('../../fonts/tabler-icons.woff') format('woff'),
                url('../../fonts/tabler-icons.ttf') format('truetype');
            font-weight: 400;
            font-style: normal;
        } -->

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
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
    $(document).ready(function() {
        var options = {
            chart: { type: 'line' },
            series: [{ name: 'Sales', data: [10, 20, 30] }],
            xaxis: { categories: ['Jan', 'Feb', 'Mar'] }
        };
        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    });
    </script>

    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
     <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>

</body>
</html>
