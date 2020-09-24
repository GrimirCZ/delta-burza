<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Objednávka č. {{$order->id}}
            do {{format_date($order->due_date)}}</h2>
    </x-slot>

    <div class="py-12">
        <x-dashboard-card>
            <table class="table-auto w-full">
                <tr>
                    <th class="px-4 py-2">Výstava</th>
                    <th class="px-4 py-2">Cena</th>
                    <th class="px-4 py-2">Zaplaceno</th>
                </tr>
                @foreach($order->ordered_registrations()->get() as $or)
                    <tr>
                        @php
                            $exhibition = $or->exhibition();
                        @endphp
                        <td class="border px-4 py-2">
                            <a href="{{url("/vystava/$exhibition->id")}}" class="link">
                                {{format_date($exhibition->date)}} - {{$exhibition->city}} ({{$exhibition->name}})
                            </a>
                        </td>
                        <td class="border px-4 py-2 text-center">{{$or->price}} kč</td>
                        <td class="border px-4 py-2 text-center">
                            @if($or->fulfilled_at != null)
                                <span class="text-green-700 font-semibold">Ano</span>
                            @else
                                <span class="text-red-700 font-semibold">Ne</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>

        </x-dashboard-card>
    </div>
</div>
