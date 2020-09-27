<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Zaplatit objednávku</h2>
    </x-slot>

    <div class="py-12">
        <x-dashboard-card>
            <div class="pt-6">
                Objednávku zaplaťte bankovním převodem.<br />
                Číslo účtu: 101831946/0300<br />
                Variabilní symbol: <b>2020{{fill_number_to_length($order->id, 4)}}</b><br />
                Částka: <b>{{$order->price()}},- Kč</b><br />
                Datum splatnosti: <b>{{format_date($order->due_date)}}</b>.<br />
                Jinou formu úhrady náš systém nepodporuje.
            </div>
        </x-dashboard-card>
    </div>

</div>
