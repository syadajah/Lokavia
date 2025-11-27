<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <script src="https://code.iconify.design/iconify-icon/2.0.0/iconify-icon.min.js"></script>
</head>

<body style="margin: 0; font-family: 'Poppins', sans-serif; background-color: #111827; color: black; display: flex;">
    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Konten utama --}}
    <main style="
        flex: 1;
        padding: 24px;
        margin-left: 250px; /* jarak kiri menyesuaikan lebar sidebar */
        overflow-y: auto;
        min-height: 100vh;
        background-color: #f5f5f5;
    ">
        @yield('content')
    </main>
</body>

</html>
