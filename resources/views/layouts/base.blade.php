<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: black;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<body>
    <header>
        @include('layouts.header')
    </header>
    @include('components.alert')

    <main>
        {{ $slot }}
    </main>

    <footer>
        @include('layouts.footer')
    </footer>
</body>
<script>

    setTimeout(function () {
        const bubble = document.getElementById('alert-bubble');
        if (bubble) {
            bubble.style.opacity = '0';
            setTimeout(() => bubble.remove(), 500);
        }
    }, 5000);
</script>

</html>