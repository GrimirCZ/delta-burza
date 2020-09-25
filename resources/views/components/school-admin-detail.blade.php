{{-- You can change this template using File > Settings > Editor > File and Code Templates > Code > Laravel Ideal Blade View Component --}}
<div class="mt-8">
    <div class="flex justify-between align-center">
        <div>
            <img src="{{asset('storage/' . $school->logo())}}" alt="Logo {{$school->name}}" class="block h-8">
        </div>
        <div class="flex items-center">
            <a href="{{url("/skola/upravit")}}" class="btn btn-primary">Upravit</a>
        </div>
    </div>
    <h1 class="text-3xl font-semibold block mt-8">{{$school->name}}</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 mt-8">
        <div>
            <div class="field">
                <div class="field__header">Email:</div>
                <div class="field__value">
                    <a href="mailto:{{$school->email}}" target="_blank">{{$school->email}}</a>
                </div>
            </div>
            <div class="field">
                <div class="field__header">Telefon:</div>
                <div class="field__value">
                    <a href="tel:{{$school->phone}}" target="_blank">{{$school->phone}}</a>
                </div>
            </div>
            <div class="field">
                <div class="field__header">Web:</div>
                <div class="field__value">
                    <a href="{{fix_url($school->web)}}" target="_blank">{{$school->web}}</a>
                </div>
            </div>
        </div>
        <div>
            <div class="field">
                <div class="field__header">IČ:</div>
                <div class="field__value">
                    {{$school->ico}}
                </div>
            </div>
            <div class="field">
                <div class="field__header">IZO:</div>
                <div class="field__value">
                    {{$school->izo}}
                </div>
            </div>
            <div class="field">
                <div class="field__header">Adresa:</div>
                <div class="field__value">
                    <a href="http://maps.google.com/?q={{$school->address}}, {{$school->psc}} {{$school->city}}"
                       target="_blank"
                       class="font-bold">
                        {{$school->address}}<br/>
                        {{$school->psc}} {{$school->city}}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-8">{!! $school->description !!}</div>
    <div class="grid grid-cols-1 sm:grid-cols-2 mt-8">
        <div>
            <h2 class="text-2xl">Obory <a href="/obor/vytvorit" class="link text-base">přidat obor</a></h2>
            <ul class="mt-4 ml-4 sm:ml-8">
                @foreach($school->ordered_specializations() as $specialization)
                    <li class="list-disc">
                        <a href="/obor/{{$specialization->id}}">{{$specialization->prescribed_specialization->code}}
                            - {{$specialization->prescribed_specialization->name}}</a><br/>
                        (ŠVP: <i>{{$specialization->name}})</i><br/>
                        <a href="/obor/{{$specialization->id}}/upravit" class="link">Upravit</a>
                        <form action="/obor/{{$specialization->id}}/smazat" class="inline ml-4" method="post">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="link">Smazat</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="mt-6 sm:mt-0">
            <h2 class="text-2xl">Výstavy <a href="/objednavka/vytvorit" class="link text-base">zaregistrovat
                    na výstavu</a></h2>
            <ul class="mt-4 ml-4 sm:ml-8">
                @foreach($school->ordered_registrations()->get() as $registration)
                    <li class="list-disc">
                        <div>
                            <a href="/vystava/{{$registration->exhibition->id}}">{{format_date($registration->exhibition->date)}} {{$registration->exhibition->district->name}}
                                ({{$registration->exhibition->name}})</a>

                            @if(!$registration->is_disabled)
                                <span class="text-green-700 font-semibold">Zaplaceno</span>
                            @else
                                <span class="text-red-700 font-semibold">Nezaplaceno</span>
                            @endif
                            <br/>
                            <a href="/registrace/{{$registration->id}}/upravit" class="link">Upravit</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="mt-8">
        <h2 class="text-2xl align-baseline">Objednávky <a href="/objednavka/vytvorit" class="link text-base">nová
                objednávka</a></h2>
        <ul class="mt-4 ml-4 sm:ml-8">
            @foreach($school->orders as $order)
                <li class="list-disc">
                    Objednávka č. {{$order->id}} ze dne: {{format_date($order->created_at)}} datum
                    splatnosti: {{format_date($order->due_date)}} ({{$order->price()}},- Kč)
                    @if($order->fulfilled())
                        <span class="text-green-700 font-semibold">Zaplaceno</span>
                    @else
                        <span class="text-red-700 font-semibold">Nezaplaceno</span>
                    @endif
                    <br/>
                    <a href="/objednavka/{{$order->id}}" class="link">Detail</a>
                </li>

            @endforeach
        </ul>
    </div>
</div>
