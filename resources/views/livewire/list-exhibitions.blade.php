<div class="h-full">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Výstavy
        </h2>
    </x-slot>

    <div class="h-full">
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 w-100">
            @if($exhibitions->isEmpty())
                Žádné výstavy se nekonají
            @else
                <table class="table-auto w-full">
                    <tr>
                        <th class="px-4 py-2">Kraj</th>
                        <th class="px-4 py-2">Datum</th>
                        <th class="px-4 py-2">Město</th>
                        <th class="hidden sm:table-cell px-4 py-2">Název</th>
                    </tr>
                    @foreach($exhibitions as $exhibition)
                        <tr>
                            <td class="border px-4 py-2">{{$exhibition->district->region->name}}</td>
                            <td class="border px-4 py-2">{{format_date($exhibition->date)}}</td>
                            <td class="border px-4 py-2"><a href="/vystava/{{$exhibition->id}}" class="underline hover:text-bold">{{$exhibition->city}}</a></td>
                            <td class="hidden sm:table-cell border px-4 py-2"><a href="/vystava/{{$exhibition->id}}" class="underline hover:text-bold">{{$exhibition->name}}</a></td>
                            <td class="hidden sm:table-cell text-center px-4 py-2"><a href="/vystava/{{$exhibition->id}}" class="underline hover:text-bold">Zobrazit</a></td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>
</div>
