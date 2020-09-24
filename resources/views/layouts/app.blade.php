<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.2.1/dist/alpine.js" defer></script>
        <script src="{{asset("js/app.js")}}"></script>
    </head>
    <body>
        <div class="min-h-screen bg-gray-100">
            <nav wire:id="ZiuiHGx76v8LUg3bcjyP" x-data="{ open: false }" class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <a href="/" class="font-weight-semibold text-black text-lg">
                                    {{ config('app.name', 'Laravel') }}
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <a class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-900 focus:outline-none hover:text-black transition duration-150
                                 ease-in-out"
                                   href="{{route("info_zs")}}">
                                    Pro žáky ZŠ
                                </a>
                                <a class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-900 focus:outline-none hover:text-black transition duration-150
                                 ease-in-out"
                                   href="{{route("info_ss")}}">
                                    Pro střední školy
                                </a>
                            </div>
                        </div>
                        <div class="flex items-center">
                            @if(Auth::check())
                                <a class="link mr-6"
                                   href="/dashboard">
                                    Profil
                                </a>
                                <form action="{{url("logout")}}" method="post">
                                    @csrf
                                    <button type="submit" class="text-blue-500 underline">Odhlásit se</button>
                                </form>
                            @else
                                <a href="{{url("/login")}}" class="text-blue-500 underline">Vstup pro školy</a>
                            @endif
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main class="h-full">
                {{ $slot }}
            </main>

            <footer class="py-6 flex justify-between align-center max-w-7xl mx-auto sm:px-6 lg:px-8">
                <p>
                    <a href="{{route("obchodni_podminky")}}" class="link">Obchodní podmínky</a>
                </p>
                <p class="text-right text-gray-600 text-sm">
                    Vytvořil Vít Falta 2020
                </p>
            </footer>
        </div>

        @stack('modals')

        @livewireScripts
    </body>

</html>
