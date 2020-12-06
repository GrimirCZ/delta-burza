<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-179066839-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', 'UA-179066839-1');
        </script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700" rel="stylesheet">
        <link rel="stylesheet" href="https://use.typekit.net/vxo6dnf.css">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/desc.css') }}">

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.2.1/dist/alpine.js" defer></script>
        <script src="{{asset("js/app.js")}}"></script>

        <script src="https://cdn.jsdelivr.net/npm/macy@2"></script>

        <link rel="stylesheet" href="{{asset("/notyf/notyf.min.css")}}">
    </head>
    <body>
        <div class="min-h-screen bg-gray-100">
            <nav wire:id="ZiuiHGx76v8LUg3bcjyP" x-data="{ open: false }"
                 class="bg-header border-b border-gray-100 py-7 px-3 md:px-7 pb-5 header-image">
                <!-- Primary Navigation Menu -->

                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-white">
                    <div class="justify-between items-center flex">
                        <a href="/"
                           class="inline-flex font-weight-semibold text-2xl sm:text-3xl font-freude title-shadow">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                        <div onClick="toggleMenu()" class="btn bg-white text-header lg:hidden cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" class="inline-block h-5 align-middle">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            <div class="inline-block align-middle font-freude">Menu</div>
                        </div>
                    </div>

                    <div class="justify-between items-center hidden lg:flex">
                        <div class="inline-flex text-shadow">
                            <a class="items-center px-1 pt-1 mr-3 md:mr-6 text-sm font-medium leading-5 focus:outline-none hover:text-blue-400 transition duration-150 ease-in-out font-freude"
                               href="{{route("vystavy")}}">
                                Výstavy
                            </a>

                            <a class="items-center px-1 pt-1 mr-3 md:mr-6 text-sm font-medium leading-5 focus:outline-none hover:text-blue-400 transition duration-150 ease-in-out font-freude"
                               href="{{route("info_zs")}}">
                                Pro žáky ZŠ
                            </a>
                            <a class="items-center px-1 pt-1 mr-3 md:mr-6 text-sm font-medium leading-5 focus:outline-none hover:text-blue-400 transition duration-150 ease-in-out font-freude"
                               href="{{route("info_ss")}}">
                                Pro vystavovatele
                            </a>
                            <a class="items-center px-1 pt-1 mr-3 md:mr-6 text-sm font-medium leading-5 focus:outline-none hover:text-blue-400 transition duration-150 ease-in-out font-freude"
                               href="{{route("info_poradatele")}}">
                                Pro pořadatele
                            </a>
                            <a class="items-center px-1 pt-1 mr-3 md:mr-6 text-sm font-medium leading-5 focus:outline-none hover:text-blue-400 transition duration-150 ease-in-out font-freude"
                               href="{{route("skoly")}}">
                                Registrované školy
                            </a>
                            <a class="items-center px-1 pt-1 mr-3 md:mr-6 text-sm font-medium leading-5 focus:outline-none hover:text-blue-400 transition duration-150 ease-in-out font-freude"
                               href="{{route("o_nas")}}">
                                O nás
                            </a>
                        </div>
                        <div class="inline-flex">
                            @if(Auth::check())
                                @if(Auth::user()->is_admin)
                                    <a class="mr-6 btn bg-white text-header font-freude header-btn-border"
                                       href="{{route('admin-dashboard')}}">
                                        Administrace
                                    </a>
                                @endif
                                <a class="mr-6 btn bg-white text-header font-freude header-btn-border"
                                   href="{{route("dashboard")}}">
                                    Profil
                                </a>
                                <form action="{{url("logout")}}" method="post">
                                    @csrf
                                    <button type="submit"
                                            class="btn bg-white text-header font-freude header-btn-border">
                                        Odhlásit se
                                    </button>
                                </form>
                            @else
                                <a href="{{url("/login")}}"
                                   class="btn bg-white text-header font-freude header-btn-border">Vstup
                                    pro vystavovatele</a>
                            @endif
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Side Menu -->
            <div class="fixed inset-0 overflow-hidden z-50 w-0" id="burger-menu">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                    <section class="absolute inset-y-0 right-0 pl-10 max-w-full flex">
                        <div class="relative w-screen max-w-md">
                            <div class="absolute top-0 left-0 -ml-8 pt-4 pr-2 flex sm:-ml-10 sm:pr-4">
                                <button aria-label="Close panel"
                                        class="text-gray-300 hover:text-white transition ease-in-out duration-150"
                                        onClick="toggleMenu()">
                                    <!-- Heroicon name: x -->
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="h-full flex flex-col space-y-6 py-6 bg-white shadow-xl overflow-y-auto">
                                <header class="px-4 sm:px-6">
                                    <h2 class="text-lg leading-7 font-medium text-gray-900 pt-5 pb-3">
                                        <a href="/" class="font-weight-semibold text-2xl font-freude text-header">
                                            {{ config('app.name', 'Laravel') }}
                                        </a>
                                    </h2>

                                </header>
                                <div class="relative flex-1 px-4 sm:px-6 text-gray-700">
                                    <div class="absolute inset-0 px-4 sm:px-6">
                                        <a href="{{route("vystavy")}}"
                                           class="block hover:text-blue-400 border-solid border-b-2 py-3 border-gray-200 font-freude">
                                            Výstavy
                                        </a>
                                        <a href="{{route("info_zs")}}"
                                           class="block hover:text-blue-400 border-solid border-b-2 py-3 border-gray-200 font-freude">
                                            Pro žáky ZŠ
                                        </a>
                                        <a href="{{route("info_ss")}}"
                                           class="block hover:text-blue-400 border-solid border-b-2 py-3 border-gray-200 font-freude">
                                            Pro vystavovatele
                                        </a>
                                        <a href="{{route("info_poradatele")}}"
                                           class="block hover:text-blue-400 border-solid border-b-2 py-3 border-gray-200 font-freude">
                                            Pro pořadatele
                                        </a>
                                        <a href="{{route("skoly")}}"
                                           class="block hover:text-blue-400 border-solid border-b-2 py-3 border-gray-200 font-freude">
                                            Registrované školy
                                        </a>
                                        <a href="{{route("o_nas")}}"
                                           class="block hover:text-blue-400 py-3 font-freude">
                                            O nás
                                        </a>


                                        <div class="mt-8">
                                            @if(Auth::check())
                                                @if(Auth::user()->is_admin)
                                                    <a class="mr-6 btn bg-header text-white font-freude inline-block"
                                                       href="{{route('admin-dashboard')}}">
                                                        Administrace
                                                    </a>
                                                @endif
                                                <a class="mr-6 btn bg-header text-white font-freude inline-block"
                                                   href="/dashboard">
                                                    Profil
                                                </a>
                                                <form action="{{url("logout")}}" method="post" class="inline-block">
                                                    @csrf
                                                    <button type="submit"
                                                            class="btn bg-header text-white font-freude inline-block">
                                                        Odhlásit se
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{url("/login")}}"
                                                   class="btn bg-header text-white font-freude">Vstup pro střední
                                                    školy</a>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <!-- Page Content -->
            <main class="h-full">
                <div>
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>

                {{ $slot }}
            </main>

            <!--
            <div class="backers px-3 sm:px-0 py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="md:flex justify-between">
                    <div class="">
                        <div class="backers-title text-gray-400 mb-3 text-left">Projekt vznikl za podpory:</div>
                        <div class="mx-5 text-center">
                            <a target="_blank" href="https://www.khkpce.cz/" class="m-3 mb-10">
                                <img src="/images/khk-pk.png" alt="Krajská hospodářská komora pardubického kraje"
                                     class="footer-img"/>
                            </a>
                            <a target="_blank" href="https://www.pardubickykraj.cz/" class="mx-3 mb-10">
                                <img src="/images/pardubickykraj.png" alt="Pardubický kraj" class="footer-img k-pce"/>
                            </a>
                            <a target="_blank" href="https://www.uradprace.cz/" class="mx-3 mb-10">
                                <img src="/images/up.png" alt="Úřad práce" class="footer-img urad-prace"/>
                            </a>
                        </div>
                    </div>
                    <div class="">
                        <div class="backers-title text-gray-400 mb-3 text-left">Záštitu nad projektem převzali:</div>
                        <div class="mx-5 text-center">
                            <a target="_blank" href="/clanek/16" class="m-3 mb-10">
                                <img src="/images/hspkcr.svg" alt="Hospodářská komora ČR"
                                     class="footer-img"/>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            -->

            <div class="backers px-3 sm:px-0 py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="backers-title text-gray-400 mb-3 text-center">Projekt podporují:</div>
                <div class="mx-5 text-center">
                    <a target="_blank" href="/clanek/1003" class="m-3 mb-10">
                        <img src="/images/msmt.png" alt="MŠMT"
                             class="footer-img"/>
                    </a>
                    <a target="_blank" href="https://www.uradprace.cz/" class="mx-3 mb-10">
                        <img src="/images/up.png" alt="Úřad práce" class="footer-img urad-prace"/>
                    </a>
                    <a target="_blank" href="/clanek/16" class="m-3 mb-10">
                        <img src="/images/hspkcr.svg" alt="Hospodářská komora ČR"
                             class="footer-img"/>
                    </a>
                    <a target="_blank" href="https://www.pardubickykraj.cz/" class="mx-3 mb-10">
                        <img src="/images/pardubickykraj.png" alt="Pardubický kraj" class="footer-img k-pce"/>
                    </a>
                    <a target="_blank" href="https://www.khkpce.cz/" class="m-3 mb-10">
                        <img src="/images/khk-pk.png" alt="Krajská hospodářská komora pardubického kraje"
                             class="footer-img"/>
                    </a>
                </div>
                </div>
            </div>

            <footer>
                <div class="px-3 sm:px-0 pt-6 md:flex justify-between align-center max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="text-left">
                        <a href="{{route("osobni-udaje")}}" class="link">Ochrana osobních údajů a Podmínky
                            užití</a>
                    </div>
                    <div></div>
                </div>
                <div class="px-3 sm:px-0 py-6 md:flex justify-between align-center max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <p class="text-right md:text-left mb-2 md:mb-0">
                        <a href="{{route("obchodni_podminky")}}" class="link">Obchodní podmínky</a>
                    </p>
                    <div class="text-right">
                        <p class="text-right text-gray-600 text-sm">
                            Vytvořil Vít Falta a Matěj Půhoný, studenti <br class="inline sm:hidden"/> <a
                                href="{{url("/skola/1")}}" class="link">DELTA - Střední škola informatiky a ekonomie,
                                s.r.o.</a>
                            2020
                        </p>
                    </div>
                </div>
            </footer>
        </div>

        <script src="{{asset("/notyf/notyf.min.js")}}"></script>

        <script>
            const currentTime = () => `${(new Date()).getHours()}:${(new Date()).getMinutes()}`
            const currentTimePart = () => `<span style="font-size: 0.9em">${(new Date()).getHours()}:${(new Date()).getMinutes()}</span>`
            const notyf = new Notyf({
                duration: 0,
                position: {
                    x: 'right',
                    y: 'top',
                },
                dismissible: true,
                types: [
                    {
                        type: 'info',
                        background: 'blue',
                        icon: true
                    }
                ]
            });
            
            
            //notyf.open({
            //        type: 'info',
            //        duration: 5000,
            //        message: `Informace o údržbě severu<br>Z důvodu údržby bude server od 18:15 do 18:30 vypnut.<br>Děkujeme za pochopení!`
            //})

            const get_registration_id = (regex) => {
                const regexRes = regex.exec(location.href);

                return regexRes === null ? null : regexRes.groups.id
            }

            @if(Auth::check() && Auth::user()->school_id != null)
            @php
                $_school_id  = Auth::user()->school_id;
            @endphp
            const selected_messenger_id = () => parseQuery()['selected_messenger_id'] || null
            const school_chat_url_regex = /\/registrace\/(?<id>\d+)\/chat/
            const is_school_chat = school_chat_url_regex.test(location.href)

            Echo.private("new_messenger.{{$_school_id}}").listen("NewMessenger", e => {
                notyf.open({
                    type: 'info',
                    message: `<h1>Nový chat</h1>Připojil se nový zájemce. <br/>Kliknutím přejdete na chat.<br>${currentTimePart()}`
                }).on("click", () => {
                    const registration_id = get_registration_id(school_chat_url_regex)

                    if (is_school_chat && registration_id === e.registration_id) {
                        setMessengerId(e.messenger_id) // declared in SchoolChat
                    } else {
                        location.href = `/registrace/${e.messenger_registration_id}/chat?selected_messenger_id=${e.messenger_id}`
                    }
                })

                if (is_school_chat)
                    render()// declared in SchoolChat
            })

            Echo.channel("chat-school.{{$_school_id}}").listen("NewMessage", e => {
                if (!is_school_chat || e.sender_id != selected_messenger_id()) {
                    console.log(e.sender_id, selected_messenger_id())
                    notyf.open({
                        type: 'info',
                        message: `<h1>Nová zpráva</h1>Přišla vám nová zpráva.<br/>Kliknutím zobrazíte.<br>${currentTimePart()}`
                    }).on("click", () => {
                        const registration_id = get_registration_id(school_chat_url_regex)

                        if (is_school_chat && registration_id === e.registration_id) {
                            setMessengerId(e.sender_id)// declared in SchoolChat
                        } else {
                            location.href = `/registrace/${e.registration_id}/chat?selected_messenger_id=${e.sender_id}`
                        }
                    })
                }

                if (is_school_chat)
                    render()// declared in SchoolChat
            })
            @endif
            @if(session("messenger_key") != null)
            const visitor_url_regex = /\/vstoupit\/chat\/(?<id>\d+)/
            const is_visitor_chat = visitor_url_regex.test(location.href)
            const visitor_get_registration_id = () => {
                const regexRes = visitor_url_regex.exec(location.href);

                return regexRes === null ? null : regexRes.groups.id
            }

            Echo.channel("chat.{{session("messenger_key")}}").listen("NewMessage", e => {
                const notify = () => notyf.open({
                    type: 'info',
                    message: `<h1>Nová zpráva</h1>${e.school_name}<br/>Kliknutím zobrazíte.<br>${currentTimePart()}`
                }).on("click", () => {
                    location.href = `/vstoupit/chat/${e.registration_id}`
                })

                if (is_visitor_chat) {
                    const registration_id = get_registration_id(visitor_url_regex)

                    if (+registration_id === +e.registration_id)
                        render()// declared in VisitorChat
                    else
                        notify()// declared in VisitorChat
                } else
                    notify()// declared in VisitorChat

            })
            @endif
        </script>

        @stack('modals')

        @stack('scripts')

        @livewireScripts

    </body>
</html>
