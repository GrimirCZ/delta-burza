<x-app-layout>
    @if($school == null)
        <x-own-header>
            Profil
        </x-own-header>
    @else
        <div class="sm:flex justify-between max-w-7xl mx-auto py-10 pb-0 px-2 sm:px-6 lg:px-8 w-100 items-center">
            <div class="inline-block">
                <div class="top text-gray-600">{{$school->district->name}}</div>
                <h1 class="font-light text-3xl text-gray-800">{{$school->name}}</h1>
            </div>
            <div class="inline-block">
                <img src="{{$school->logo()}}" class="h-8"
                     alt="Logo {{$school->name}}">
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto">
        @if($school == null)
            <div
                class="grid justify-around items-center h-72 bg-white py-10 pb-0 px-2 sm:px-6 lg:px-8 w-100 my-7 mx-5 shadow-sm">
                <div class="text-center">
                    <i>Zatím nebyly vloženy informace o vystavovateli.</i>
                    <a href="/skola/vytvorit" class="text-xl btn btn-primary block mt-2">
                        Vložte informace o vystavovateli.
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mx-5 mt-10">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Informace o vystavovateli
                        <a href="{{url("/entita/upravit")}}"
                           class="text-header ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" class="inline h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            <span class="inline-block align-middle">Upravit</span>
                        </a>
                        <a href="{{url("/skola/".$school->id)}}" class="text-header ml-4 inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" class="inline h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            <span class="inline-block align-middle">Zobrazit detail vystavovatele</span>
                        </a>
                    </h3>
                </div>
                <div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                Název
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                {{$school->name}}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                Email
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                <a href="mailto:{{$school->email}}">
                                    {{$school->email}}
                                </a>
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                Telefon
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                <a href="tel:{{$school->phone}}">
                                    {{$school->phone}}
                                </a>
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                Web
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                <a href="{{fix_url($school->web)}}">
                                    {{$school->web}}
                                </a>
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                IČ
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                {{$school->ico}}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                IZO
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                {{$school->izo}}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                Adresa
                            </dt>

                            <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                <a href="http://maps.google.com/?q={{$school->address}}, {{$school->psc}} {{$school->city}}">
                                    {{$school->address}}
                                    , {{$school->psc}} {{$school->city}}
                                </a>
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-5 font-medium text-gray-500">
                                Informace o škole
                            </dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ substr(strip_tags($school->description), 0, 50)."..." }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            @if($school->type_can_have_specializations())
                <div class="bg-white shadow overflow-hidden sm:rounded-lg mx-5 mt-10">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Obory
                            <a href="{{url("/obor/vytvorit")}}" class="text-header ml-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" class="inline h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="inline-block align-middle">Přidat obor</span>
                            </a>
                        </h3>
                    </div>
                    <div>
                        <table class="table-fixed min-w-full text-gray-500">
                            <tbody>
                            @foreach($school->ordered_specializations()->get() as $specialization)
                                <tr class="{{$loop->index %2 == 0 ? "bg-gray-100" : ""}}">
                                    <td class="px-8 py-5">
                                        {{$specialization->prescribed_specialization->code}}
                                        - {{$specialization->prescribed_specialization->name}}<br/>
                                        (ŠVP: <i>{{$specialization->name}})</i>
                                    </td>
                                    <td class="px-8 py-5">{{substr(strip_tags($specialization->description), 0, 50)."..."}}</td>
                                    <td class="px-8 py-5 text-right">
                                        <a href="/obor/{{$specialization->id}}/upravit" class="text-header ml-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor" class="inline h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                            <span class="inline-block align-middle">Upravit</span>
                                        </a>
                                        <form action="/obor/{{$specialization->id}}/smazat" class="inline ml-4"
                                              method="post">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke="currentColor" class="inline h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                <span class="inline-block align-middle">Smazat</span>
                                            </button>

                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            @if($school->type_can_be_related_to())
                <div class="bg-white shadow overflow-hidden sm:rounded-lg mx-5 mt-10">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Spolupracující firmy
                        </h3>
                    </div>
                    <div>
                        <table class="table-fixed min-w-full text-gray-500">
                            <tbody>
                            @foreach($school->related_companies as $related_company)
                                <tr class="{{$loop->index %2 == 0 ? "bg-gray-100" : ""}}">
                                    <td class="px-8 py-5">
                                        <a href="/school/{{$related_company->id}}" class="link">
                                            {{$related_company->name}}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            @if($school->type_can_have_related())
                <div class="bg-white shadow overflow-hidden sm:rounded-lg mx-5 mt-10">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Spolupracující školy

                            <a href="{{url("/spolecnost/skola/pridat")}}" class="text-header ml-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" class="inline h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="inline-block align-middle">Přidat spolupracující školu</span>
                            </a>
                        </h3>
                    </div>
                    <div>
                        <able class="table-fixed min-w-full text-gray-500">
                            <tbody>
                            @foreach($school->related_schools()->orderBy("name")->get() as $related_school)
                                <tr class="{{$loop->index %2 == 0 ? "bg-gray-100" : ""}}">
                                    <td class="px-8 py-5">
                                        <a href="/school/{{$related_school->id}}" class="link">
                                            {{$related_school->name}}
                                        </a>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <form action="/spolecnost/skola/{{$related_school->id}}/smazat"
                                              class="inline ml-4"
                                              method="post">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke="currentColor" class="inline h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                <span class="inline-block align-middle">Smazat</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        able>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow overflow-hidden sm:rounded-lg mx-5 mt-10">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Výstavy
                        <a href="{{url("/objednavka/vytvorit")}}" class="text-header ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" class="inline h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="inline-block align-middle">Nová přihláška</span>
                        </a>
                    </h3>
                </div>
                <div>
                    <table class="table-fixed min-w-full text-gray-500">
                        <tbody>
                        @foreach($school->ordered_registrations()->get() as $registration)
                            <tr class="{{$loop->index %2 == 0 ? "bg-gray-100" : ""}}">
                                <td class="px-8 py-5">
                                    <a href="{{url('/vystava/'.$registration->exhibition->id)}}">
                                        {{format_date($registration->exhibition->date)}} {{$registration->exhibition->city}}
                                        ({{$registration->exhibition->name}})
                                    </a>
                                </td>
                                <td class="px-8 py-5">
                                    @if($registration->order_registration != null && !$registration->order_registration->fulfilled_at != null)
                                        <span class="text-red-700 font-semibold">Nezaplaceno</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="/registrace/{{$registration->id}}/chat" class="underline">Chat</a>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <a href="/registrace/{{$registration->id}}/upravit" class="text-header ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor" class="inline h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                        <span class="inline-block align-middle">Upravit</span>
                                    </a>
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
                        Přehled objednávek
                    </h3>
                </div>
                <div>
                    <table class="table-fixed min-w-full text-gray-500">
                        <tbody>
                        @foreach($school->orders as $order)
                            <tr class="{{$loop->index %2 == 0 ? "bg-gray-100" : ""}}">
                                <td class="px-8 py-5">
                                    <a href="/objednavka/{{$order->id}}" class="link">
                                        Objednávka č. 2020{{fill_number_to_length($order->id, 4)}} ze
                                        dne: {{format_date($order->created_at)}} datum
                                        splatnosti: {{format_date($order->due_date)}}
                                        ({{number_format($order->price(), 0,",",".")}},- Kč)
                                    </a>
                                </td>
                                <td class="px-8 py-5">
                                    @if(!$order->fulfilled())
                                        <span class="text-red-700 font-semibold">Nezaplaceno</span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right">
                                    @if(!$order->fulfilled())
                                        <a href="/objednavka/{{$order->id}}/zaplatit"
                                           class="btn bg-teal-400 text-white">Zaplatit</a>
                                    @endif
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
                        Zprávy od uchazečů
                    </h3>
                </div>
                <div>
                    <table class="table-fixed min-w-full text-gray-500">
                        <tbody>
                        @foreach($school->contacts as $contact)
                            <tr class="{{$loop->index %2 == 0 ? "bg-gray-100" : ""}}">
                                <td class="px-8 py-5">
                                    <a href="/zprava/{{$contact->id}}" class="link">
                                        {{$contact->name}} - {{$contact->email}}
                                    </a>
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
