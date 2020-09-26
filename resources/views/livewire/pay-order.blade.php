<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Zaplatit objednávku</h2>
    </x-slot>

    <div class="py-12">
        <x-dashboard-card>
            <div class="pt-6">
                Platba objednávky je možná pouze bankovním převodem. č. účtu: <b>101831946/0300</b>, V.S.:
                <b>2020{{fill_number_to_length($order->id, 4)}}</b>, částka: <b>{{$order->price()}},- Kč</b>, datum
                splatnosti: <b>{{format_date($order->due_date)}}</b>
            </div>
        </x-dashboard-card>
    </div>

</div>
