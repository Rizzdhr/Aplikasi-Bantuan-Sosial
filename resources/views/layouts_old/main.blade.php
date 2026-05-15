<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('judul')</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="flex h-screen bg-gray-100 p-4 gap-4">

        <!-- Sidebar -->
        <div class="w-64 bg-white rounded-2xl shadow-md flex flex-col p-2">
            @include('layouts.sidebar')
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col gap-4">

            <!-- Navbar -->
            @include('layouts.navbar')

            <!-- Content -->
            <div class="bg-white p-6 rounded-xl shadow">
                @yield('content')
            </div>

        </div>
    </div>

</body>
</html>
