<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Objednávka č. 2020{{fill_number_to_length($order->id, 4)}} ze dne: {{format_date($order->created_at)}} datum
            splatnosti: {{format_date($order->due_date)}} ({{$price}},- Kč)
        </h2>
    </x-slot>

    <x-own-header
        bottom="ze dne: {{format_date($order->created_at)}} datum splatnosti: {{format_date($order->due_date)}} ({{$price}},- Kč)">
        Objednávka č. 2020{{fill_number_to_length($order->id, 4)}}
    </x-own-header>

    <div class="py-12">
        <x-dashboard-card>
            <div>
                @if(count($order_registrations) > 0)
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
                        @foreach($order_registrations as $or)
                            <tr>
                                @php
                                    $exhibition = $or->exhibition();
                                @endphp
                                <td class="px-4 py-2">
                                    <a href="{{url("/vystava/$exhibition->id")}}" class="">
                                        {{format_date($exhibition->date)}} - {{$exhibition->city}}
                                        ({{$exhibition->name}})
                                        @if($or->registration->exhibition->organizer_id != 1)
                                            <br>
                                            <i>Pořadatel: {{$or->registration->exhibition->organizer->short_name}}</i>
                                        @endif
                                    </a>
                                </td>
                                <td class="px-4 py-2">
                                    {{number_format($or->price, 0,",",".")}},- Kč
                                </td>
                                <td class="text-right" colspan="2">
                                    @if($or->fulfilled_at != null)
                                        @if($or->registration->exhibition->organizer_id == 1)
                                            <span class="text-green-700 font-semibold">Zaplaceno</span>
                                        @else
                                            Fakturační podmínky řeší organizátor výstavy
                                        @endif
                                    @else
                                        <span class="text-red-700 font-semibold">Nezaplaceno</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                        <tfoot class="">
                        <tr class="mt-5 border-double border-t-4 border-gray-200">
                            <td class="px-4 py-2">Celkem</td>
                            <td class="px-4 py-2">
                                {{$price}},- Kč
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        </tfoot>
                    </table>
                @else
                    Tato objednávka nemá žádné výstavy.
                @endif
            </div>

            <div class="text-right mt-20">
                @if($order->invoice)
                    <a href="{{$order->invoice}}" class="btn btn-primary">Faktura - daňový doklad.pdf</a>
                @endif

                @if($order->proforma_invoice)
                    <a href="{{$order->proforma_invoice}}" class="btn btn-primary">Zálohová
                        faktura.pdf</a>
                @endif

                @if(!$is_complete)
                    <a href="/objednavka/{{$order->id}}/zaplatit" class="btn bg-teal-400 text-white">Zaplatit</a>
                @endif
            </div>

        </x-dashboard-card>
    </div>
</div>
