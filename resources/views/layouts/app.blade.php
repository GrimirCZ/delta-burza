<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700" rel="stylesheet">
        <link rel="stylesheet" href="https://use.typekit.net/vxo6dnf.css">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.2.1/dist/alpine.js" defer></script>
        <script src="{{asset("js/app.js")}}"></script>
    </head>
    <body>
        <div class="min-h-screen bg-gray-100">
            <nav wire:id="ZiuiHGx76v8LUg3bcjyP" x-data="{ open: false }" class="bg-header border-b border-gray-100 p-7">
                <!-- Primary Navigation Menu -->

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
                    <a href="/" class="font-weight-semibold text-3xl font-freude">
                        {{ config('app.name', 'Laravel') }}
                    </a>

                    <div class="flex justify-between items-center">
                        <div class="inline-flex">
                            <a class="items-center px-1 pt-1 mr-8 text-sm font-medium leading-5 focus:outline-none hover:text-blue-400 transition duration-150 ease-in-out"
                                href="{{route("vystavy")}}">
                                Výstavy
                            </a>

                            <a class="items-center px-1 pt-1 mr-8 text-sm font-medium leading-5 focus:outline-none hover:text-blue-400 transition duration-150 ease-in-out"
                                href="{{route("info_zs")}}">
                                Pro žáky ZŠ
                            </a>
                            <a class="items-center px-1 pt-1 text-sm font-medium leading-5 focus:outline-none hover:text-blue-400 transition duration-150 ease-in-out"
                                href="{{route("info_ss")}}">
                                Pro střední školy
                            </a>
                        </div>
                        <div class="inline-flex">
                            @if(Auth::check())
                                <a class="mr-6 btn bg-white text-header"
                                   href="/dashboard">
                                    Profil
                                </a>
                                <form action="{{url("logout")}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn bg-white text-header">Odhlásit se</button>
                                </form>
                            @else
                                <a href="{{url("/login")}}" class="btn bg-white text-header">Vstup pro školy</a>
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
                    Vytvořil Vít Falta a Matěj Půhoný 2020
                </p>
            </footer>
        </div>

        @stack('modals')

        @livewireScripts
    </body>

</html>
