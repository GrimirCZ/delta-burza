{{-- You can change this template using File > Settings > Editor > File and Code Templates > Code > Laravel Ideal Blade View Component --}}
<div class="mt-8">
    <div class="flex justify-between align-center">
        <div>
            <img src="{{asset('storage/' . $school->logo())}}" alt="Logo {{$school->name}}" class="block">
        </div>
        <div class="flex items-center">
            <a href="{{url("/skola/$school->id/upravit")}}" class="btn btn-primary">Upravit</a>
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
                    <a href="http://maps.google.com/?q={{$school->address}}" target="_blank"
                       class="font-bold">{{$school->address}}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-8">{!! $school->description !!}</div>
    <div class="grid grid-cols-1 sm:grid-cols-2 mt-8">
        <div>
            <h2 class="text-2xl">Obory</h2>
            <ul class="mt-4 ml-4 sm:ml-8">
                @foreach($school->specializations as $specialization)
                    <li class="list-disc">
                        <a href="/obor/{{$specialization->id}}">{{$specialization->prescribed_specialization->code}}
                            - {{$specialization->prescribed_specialization->name}}</a><br/>
                        (ŠVP: <i>{{$specialization->name}})</i><br/>
                        <a href="/obor/{{$specialization->id}}/upravit" class="link">Upravit</a>
                        <form action="/obor/{{$specialization->id}}/smazat" class="inline ml-4">
                            <button type="submit" class="link">Smazat</button>
                        </form>
                    </li>
                @endforeach
                <li class="mt-4"><a href="/obor/vytvorit" class="text-blue-500 underline">Přidat
                        obor</a></li>
            </ul>
        </div>
        <div class="mt-6 sm:mt-0">
            <h2 class="text-2xl">Výstavy</h2>
            <ul class="mt-4 ml-4 sm:ml-8">
                @foreach($school->registrations as $registration)
                    <li class="list-disc">
                        <div>
                            <a href="/vystava/{{$registration->exhibition->id}}">{{format_date($registration->exhibition->date)}} {{$registration->exhibition->district->name}}
                                ({{$registration->exhibition->name}})</a><br/>
                            <a href="/registrace/{{$registration->id}}/upravit" class="link">Upravit</a>
                            <form action="/registrace/{{$registration->id}}/smazat" class="inline ml-4">
                                <button type="submit" class="link">Smazat</button>
                            </form>
                        </div>
                    </li>
                @endforeach
                <li class="mt-4"><a href="/objednavka/vytvorit" class="text-blue-500 underline">Zaregistrovat
                        na výstavu</a></li>
            </ul>
        </div>
    </div>
</div>
