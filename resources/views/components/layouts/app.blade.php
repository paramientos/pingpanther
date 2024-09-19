<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="lofi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            zoom: 95%
        }

        .input {
            height: 35px !important;
        }

        textarea:focus, .input:focus {
            border: 1px solid #18181b !important;
            outline: none;
        }

        .select {
            height: 42px !important;
        }
    </style>
</head>
<body class="h-full">

<!-- ========== HEADER ========== -->

<!-- ========== END HEADER ========== -->

<!-- ========== MAIN CONTENT ========== -->
<main id="content">
    <!-- Secondary Navbar -->
    <div class="min-h-full">
            <!-- Collapse -->
            <x-includes.top-menu/>
            <!-- End Collapse -->
    </div>
    <!-- End Secondary Navbar -->

    <div class="max-w-[95rem] min-h-[75rem] mx-auto py-10 px-4 sm:px-6 lg:px-8">
        {{ $slot }}
    </div>
</main>
<!-- ========== END MAIN CONTENT ========== -->

<x-toast/>
</body>
</html>
