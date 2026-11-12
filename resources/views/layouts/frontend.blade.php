<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    @fluxAppearance
</head>

<body class="min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 antialiased flex flex-col">
    <header>
        @include('partials.frontend.navigation')
    </header>

    <main class="flex-1">
        {{ $slot }}
    </main>

    <footer class="w-full p-6 sm:p-12 text-xs flex flex-col items-end">
        <a href="#">Juan Carlos Marchant (FullStack Developer)</a>
        <a href="#">Temuco, Chile</a>
        <a href="#">+56 9 6188 1674</a>
    </footer>

    @livewireScripts
</body>
</html>
