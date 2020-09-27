<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Objednávka č. 2020{{fill_number_to_length($order->id, 4)}} ze dne: {{format_date($order->created_at)}} datum
            splatnosti: {{format_date($order->due_date)}} ({{number_format($order->price(), 0,",",".")}},- Kč)
        </h2>
    </x-slot>

    <x-own-header
        bottom="ze dne: {{format_date($order->created_at)}} datum splatnosti: {{format_date($order->due_date)}} ({{$order->price()}},- Kč)">
        Objednávka č. 2020{{fill_number_to_length($order->id, 4)}}
    </x-own-header>

    <div class="py-12">
        <x-dashboard-card>
            <div>
                <table class="table-auto w-full table divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Výstava
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Cena
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">

                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">

                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($order->ordered_registrations()->get() as $or)
                            <tr>
                                @php
                                    $exhibition = $or->exhibition();
                                @endphp
                                <td class="px-4 py-2">
                                    <a href="{{url("/vystava/$exhibition->id")}}" class="">
                                        {{format_date($exhibition->date)}} - {{$exhibition->city}} ({{$exhibition->name}})
                                    </a>
                                </td>
                                <td class="px-4 py-2">
                                    {{number_format($or->price, 0,",",".")}},- Kč
                                </td>
                                <td colspan="2"></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="">
                    <tr class="mt-5 border-double border-t-4 border-gray-200">
                        <td class="px-4 py-2">Celkem</td>
                        <td class="px-4 py-2">
                            {{number_format($order->price(),0,",",".")}},- Kč
                        </td>
                        <td></td>
                        <td class="text-right">
                            @if($or->fulfilled_at != null)
                                <span class="text-green-700 font-semibold">Zaplaceno</span>
                            @else
                                <span class="text-red-700 font-semibold">Nezaplaceno</span>
                            @endif
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <div class="text-right mt-20">
                @if($order->invoice)
                    <a href="{{asset("/storage/invoices/$order->invoice")}}" class="btn btn-primary">Zálohová faktura.pdf</a>
                @endif

                @if(!$or->fulfilled_at != null)
                    <a href="/objednavka/{{$order->id}}/zaplatit" class="btn bg-teal-400 text-white">Zaplatit</a>
                @endif
            </div>

        </x-dashboard-card>
    </div>
</div>
