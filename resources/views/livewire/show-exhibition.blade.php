<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span class="font-bold">{{$exhibition->city}}</span>
            ({{$exhibition->name}})<br/>
            <span
                class="text-gray-500 text-base">{{format_date($exhibition->date)}}</span>
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 w-100">
            <div>
                @if($exhibition->registrations->isEmpty())
                    Této výstavy se neúčastní žádné školy
                @else
                    <table class="table-auto w-full">
                        <tr>
                            <th class="px-4 py-2">Okres</th>
                            <th class="px-4 py-2">Nazev</th>
                            <th class="hidden sm:table-cell px-4 py-2">Ranní akce</th>
                            <th class="hidden sm:table-cell px-4 py-2">Večerní akce</th>
                        </tr>

                        @foreach($exhibition->registrations as $registration)
                            <tr>
                                <td class="hidden sm:table-cell text-center border px-4 py-2">
                                    {{$registration->school->district->name}}
                                </td>
                                <td class="hidden sm:table-cell text-center border px-4 py-2">
                                    <a href="/skola/{{$registration->school->id}}"
                                       class="underline">
                                        {{$registration->school->name}}
                                    </a>
                                    @foreach($registration->school->specializations as $specialization)
                                        <li>
                                            {{$specialization->prescribed_specialization->code}}
                                            - {{$specialization->name}}
                                        </li>
                                    @endforeach
                                </td>
                                <td class="hidden sm:table-cell text-center border px-4 py-2">
                                    <a href="/vstoupit/ranni/{{$registration->id}}"
                                       class="underline hover:text-bold">
                                        Vstoupit
                                    </a>
                                </td>
                                <td class="hidden sm:table-cell text-center border px-4 py-2">
                                    <a href="/vstoupit/vecerni/{{$registration->id}}"
                                       class="underline hover:text-bold">
                                        Vstoupit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
