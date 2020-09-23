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
                            <th class="px-4 py-2">Nazev</th>
                            <th class="px-4 py-2">Okres</th>
                            <th class="hidden sm:table-cell px-4 py-2">Online {{settings("morning_event_start")}}
                                - {{settings("morning_event_end")}}</th>
                            <th class="hidden sm:table-cell px-4 py-2">Online {{settings("evening_event_start")}}
                                - {{settings("evening_event_end")}}</th>
                        </tr>

                        @foreach($registrations as $registration)
                            <tr>
                                <td class="border px-4 py-2">
                                    <div class="flex justify-start">
                                        <div>
                                            <a href="/skola/{{$registration->school->id}}"
                                               class="underline">
                                                {{$registration->school->name}}
                                            </a>
                                            <ul>
                                                @php
                                                    // ignore
                                                        $specializations = $registration
                                                                            ->school
                                                                            ->specializations()
                                                                            ->join("prescribed_specializations", "specializations.prescribed_specialization_id", "=", "prescribed_specializations.id")
                                                                            ->orderBy("prescribed_specializations.code")
                                                                            ->orderBy("prescribed_specializations.name")
                                                                            ->orderBy("specializations.name")
                                                                            ->select("specializations.*")
                                                                            ->get();
                                                @endphp
                                                @foreach($specializations as $specialization)
                                                    <li class="text-left list-disc ml-5">
                                                        <a href="/obor/{{$specialization->id}}">
                                                            {{$specialization->prescribed_specialization->code}}
                                                            - {{$specialization->prescribed_specialization->name}}
                                                            ({{$specialization->name}})
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center border px-4 py-2">
                                    {{$registration->school->district->name}}
                                </td>
                                <td class="hidden sm:table-cell text-center border px-4 py-2">
                                    <a href="/vstoupit/ranni/{{$registration->id}}"
                                       target="_blank"
                                       class="underline hover:text-bold">
                                        Vstoupit
                                    </a>
                                </td>
                                <td class="hidden sm:table-cell text-center border px-4 py-2">
                                    <a href="/vstoupit/vecerni/{{$registration->id}}"
                                       target="_blank"
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
