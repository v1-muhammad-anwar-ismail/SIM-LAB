<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIM-LAB UNESA')</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap');

        :root {
            --bg-main: #02040a;
            --nav-bg: rgba(2, 4, 10, 0.85); /* Glassmorphism background */
            --primary-cyan: #00d9ff;
            --text-white: #ffffff;
            --text-muted: #94a3b8;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-white);
            min-height: 100vh;
            overflow-x: hidden;
        }

    </style>
</head>
<body>
    @include('partials.navbar')

    <!-- MAIN BODY -->
    <main class="main-content" style="padding-top: 100px; min-height: calc(100vh - 100px);">
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
