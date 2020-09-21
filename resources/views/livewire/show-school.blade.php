<div>
    <x-slot name="header">
            <img src="{{asset('storage/images/' . $school->logo())}}" alt="Logo {{$school->name}}">
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 w-100 px-4">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-8">{{$school->name}}</h2>
            <div>
                <h2 class="text-2xl">Informace</h2>
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 text-center sm:text-left">
                    <div>
                        <div class="field">
                            <span class="field__header">Email:</span>
                            <span class="field__value">
                            <a href="mailto:{{$school->email}}">{{$school->email}}</a>
                        </span>
                        </div>
                        <div class="field">
                            <span class="field__header">Telefon:</span>
                            <span class="field__value">
                            <a href="tel:{{$school->phone}}">{{$school->phone}}</a>
                        </span>
                        </div>
                        <div class="field">
                            <span class="field__header">Web:</span>
                            <span class="field__value">
                            <a href="{{fix_url($school->web)}}">{{$school->web}}</a>
                        </span>
                        </div>
                    </div>
                    <div>
                        <div class="field">
                            <span class="field__header">IČ:</span>
                            <span class="field__value">
                            {{$school->ico}}
                        </span>
                        </div>
                        <div class="field">
                            <span class="field__header">IZO:</span>
                            <span class="field__value">
                            {{$school->izo}}
                        </span>
                        </div>
                        <div class="field">
                            <span class="field__header">Adresa:</span>
                            <span class="field__value">
                                <a href="http://maps.google.com/?q={{$school->address}}" target="_blank">
                                    {{$school->address}}
                                </a>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-8">
                <h2 class="text-2xl">Obory</h2>
                <div class="flex flex-col gap-row-4">
                    @foreach($school->specializations as $specialization)
                        <div class="rounded py-4 px-8">
                            <a href="/obor/{{$specialization->id}}">{{$specialization->prescribed_specialization->code}}
                                - {{$specialization->name}}</a><br/>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mt-8">
                <h2 class="text-2xl">Výstavy</h2>
                <div class="flex flex-col gap-row-4">
                    @foreach($school->registrations as $registration)
                        <div class="grid grid-cols-2">
                            <div class="rounded py-4 px-8">
                                <a href="/vystava/{{$registration->exhibition->id}}">{{$registration->exhibition->date}} {{$registration->exhibition->district->name}}
                                    ({{$registration->exhibition->name}})</a><br/>
                            </div>
                            <div class="grid items-center">
                                {{--                                TODO: variable hours--}}
                                {{--                                zobrazit jen pokud se kona dnes--}}
                                <div class="flex justify-start">
                                    <a href="/vstoupit/ranni/{{$registration->id}}" class="btn btn-primary">Raní
                                        schůzka 8:00 - 12:00</a>
                                    <a href="/vstoupit/vecerni/{{$registration->id}}" class="ml-4 btn btn-primary">Odpolední
                                        schůzka 18:00 - 21:00</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

