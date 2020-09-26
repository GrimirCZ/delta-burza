<x-app-layout>
    @if(Auth::user()->school_id == null)
        <x-own-header>
            Profil
        </x-own-header>
    @else
        <div class="sm:flex justify-between max-w-7xl mx-auto py-10 pb-0 px-2 sm:px-6 lg:px-8 w-100 items-center">
            <div class="inline-block">
                <div class="top text-gray-600">{{Auth::user()->school->district->name}}</div>
                <h1 class="font-light text-3xl text-gray-800">{{Auth::user()->school->name}}</h1>
            </div>
            <div class="inline-block">
                <img src="{{asset('storage/' . Auth::user()->school->logo())}}" class="h-8"
                     alt="Logo {{Auth::user()->school->name}}">
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto">
        @if(Auth::user()->school_id == null)
            <div
                class="grid justify-around items-center h-72 bg-white py-10 pb-0 px-2 sm:px-6 lg:px-8 w-100 my-7 mx-5 shadow-sm">
                <div class="text-center">
                    <i>Zatím nebyly vloženy informace o škole</i>
                    <a href="/skola/vytvorit" class="text-xl btn btn-primary block mt-2">
                        Vložte informace o škole.
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mx-5 mt-10">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Informace o škole
                    </h3>
                    <a href="{{url("/skola/upravit")}}" class="btn btn-primary">
                        Upravit informace
                    </a>
                </div>
                <div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                Název
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                {{Auth::User()->school->name}}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                Email
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                <a href="mailto:{{Auth::User()->school->email}}">
                                    {{Auth::User()->school->email}}
                                </a>
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                Telefon
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                <a href="tel:{{Auth::User()->school->phone}}">
                                    {{Auth::User()->school->phone}}
                                </a>
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                Web
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                <a href="{{fix_url(Auth::User()->school->web)}}">
                                    {{Auth::User()->school->web}}
                                </a>
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                IČ
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                {{Auth::User()->school->ico}}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                IZO
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                {{Auth::User()->school->izo}}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                Adresa
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                <a href="http://maps.google.com/?q={{Auth::User()->school->address}}, {{Auth::User()->school->psc}} {{Auth::User()->school->city}}">
                                    {{Auth::User()->school->address}}
                                </a>
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                Informace o škole
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                {!! substr(Auth::User()->school->description, 0, 50)."..." !!}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg mx-5 mt-10">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Obory
                    </h3>
                    <a href="{{url("/obor/vytvorit")}}" class="btn btn-primary">
                        Přidat obor
                    </a>
                </div>
                <div>
                    <table class="table-fixed min-w-full text-gray-500">
                        <tbody>
                        @foreach(Auth::User()->school->ordered_specializations() as $specialization)
                            <tr class="{{$loop->index %2 == 0 ? "bg-gray-100" : ""}}">
                                <td class="px-8 py-5">
                                    {{$specialization->prescribed_specialization->code}}
                                    - {{$specialization->prescribed_specialization->name}}<br/>
                                    (ŠVP: <i>{{$specialization->name}})</i>
                                </td>
                                <td class="px-8 py-5">{{substr(strip_tags($specialization->description), 0, 50)."..."}}</td>
                                <td class="px-8 py-5 text-right">
                                    <a href="/obor/{{$specialization->id}}/upravit"
                                       class="btn bg-yellow-400 text-white">Upravit</a>
                                    <form action="/obor/{{$specialization->id}}/smazat" class="inline ml-4"
                                          method="post">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="btn bg-red-700 text-white">Smazat</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg mx-5 mt-10">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Výstavy
                    </h3>
                    <a href="{{url("/objednavka/vytvorit")}}" class="btn btn-primary">
                        Zaregistovat se na další výstavy (nová objednávka)
                    </a>
                </div>
                <div>
                    <table class="table-fixed min-w-full text-gray-500">
                        <tbody>
                        @foreach(Auth::user()->school->ordered_registrations()->get() as $registration)
                            <tr class="{{$loop->index %2 == 0 ? "bg-gray-100" : ""}}">
                                <td class="px-8 py-5">
                                    {{format_date($registration->exhibition->date)}} {{$registration->exhibition->district->name}}
                                    ({{$registration->exhibition->name}})
                                </td>
                                <td class="px-8 py-5">
                                    @if(!$registration->is_disabled)
                                        <span class="text-green-700 font-semibold">Aktivní</span>
                                    @else
                                        <span class="text-red-700 font-semibold">Neaktivní</span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <a href="/registrace/{{$registration->id}}/upravit"
                                       class="btn bg-yellow-400 text-white">Upravit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg mx-5 mt-10">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Objednávky
                    </h3>
                    <a href="{{url("/objednavka/vytvorit")}}" class="btn btn-primary">
                        nová objednávka
                    </a>
                </div>
                <div>
                    <table class="table-fixed min-w-full text-gray-500">
                        <tbody>
                        @foreach(Auth::user()->school->orders as $order)
                            <tr class="{{$loop->index %2 == 0 ? "bg-gray-100" : ""}}">
                                <td class="px-8 py-5">
                                    Objednávka č. 2020{{fill_number_to_length($order->id, 4)}} ze
                                    dne: {{format_date($order->created_at)}} datum
                                    splatnosti: {{format_date($order->due_date)}}
                                    ({{number_format($order->price(), 0,",",".")}},- Kč)
                                </td>
                                <td class="px-8 py-5">
                                    @if($order->fulfilled())
                                        <span class="text-green-700 font-semibold">Zaplaceno</span>
                                    @else
                                        <span class="text-red-700 font-semibold">Nezaplaceno</span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <a href="/objednavka/{{$order->id}}" class="btn bg-yellow-400 text-white">Detail</a>
                                    @if(!$order->fulfilled())
                                        <a href="/objednavka/{{$order->id}}/zaplatit"
                                           class="btn bg-green-400 text-white">Zaplatit</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mb-10"></div>
        @endif
    </div>
</x-app-layout>
