<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen" style="background-color: #92C3E3; display: flex; flex-direction: column; height:100%; overflow-y:auto">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="shadow" style="background: #C4DBFD; margin-top: 65px;">
                    <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-grow">
                {{ $slot }}
                @if (session('success'))
                    <div class="position-fixed top-20 end-0 p-3" style="z-index: 100">
                        <div class="toast align-items-center bg-green-100 border-0" role="alert" aria-live="assertive"
                            aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    <i class="fa-regular fa-circle-check" style="color: #48f745;"></i>
                                    {{ session('success') }}
                                </div>
                                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                                    aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                        </div>
                    </div>
                @elseif (session('error'))
                    <div class="position-fixed top-20 end-0 p-3" style="z-index: 100">
                        <div class="toast align-items-center bg-red-100 border-0" role="alert" aria-live="assertive"
                            aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    <i class="fa-solid fa-triangle-exclamation" style="color: #dc0404;"></i>
                                    {{ session('error') }}
                                </div>
                                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                                    aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                        </div>
                    </div>
                @endif
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
