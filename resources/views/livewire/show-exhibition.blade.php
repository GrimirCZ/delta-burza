<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$exhibition->name}}<br/>
            <span
                class="text-gray-500 text-base">{{format_date($exhibition->date)}} - {{$exhibition->district->region->name}}</span>
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 w-100">
            <div class="flex">
                @if($exhibition->registrations->isEmpty())
                    Této výstavy se neúčastní žádné školy
                @else
                    <table class="table-auto w-full">
                        <tr>
                            <th class="px-4 py-2">Okres</th>
                            <th class="px-4 py-2">Název</th>
                            <th class="hidden sm:table-cell px-4 py-2">Ranní akce</th>
                            <th class="hidden sm:table-cell px-4 py-2">Večerní akce</th>
                        </tr>
                        @foreach($exhibition->registrations as $registration)
                            <tr>
                                <td class="border px-4 py-2">{{$registration->school->district->name}}</td>
                                <td class="border px-4 py-2">
                                    <a href="/registrace/{{$exhibition->id}}"
                                       class="underline hover:text-bold">
                                        {{$registration->school->name}}
                                    </a>
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
