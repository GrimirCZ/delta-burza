<div>
    <x-slot name="header">
        <img src="{{asset('storage/' . $school->logo())}}" alt="Logo {{$school->name}}">
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 w-100 px-4">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-8">{{$school->name}}</h2>
            <div>
                <h2 class="text-2xl">Informace</h2>
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 text-center sm:text-left">
                    <div>
                        <a href="http://maps.google.com/?q={{$school->address}}, {{$school->psc}} {{$school->city}}" target="_blank" class="font-bold">
                            {{$school->address}}<br/>
                            {{$school->psc}} {{$school->city}}
                        </a>
                        <div class="mt-4"></div>
                        <a href="mailto:{{$school->email}}" class="font-bold">{{$school->email}}</a><br/>
                        <a href="tel:{{$school->phone}}" class="font-bold">{{$school->phone}}</a><br/>
                        <a href="{{fix_url($school->web)}}" class="font-bold">{{$school->web}}</a><br/>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <span><a href="https://deltassie-my.sharepoint.com/:b:/g/personal/formji_delta-skola_cz/EZay0T1NZ25Kp-7G4A3oPFoBheEckjImbPqoHEw6zVh7pw?e=DK63nk" target="_blank" class="font-bold"><img src="{{asset("/images/pdf.svg")}}" alt="PDF"
                                                                 class="w-6 h-6 inline-block mr-4">Informační brožura.pdf</a></span>
                    </div>
                </div>
            </div>
            <div class="mt-8 grid school-detail-grid">
                <div>
                    <h2 class="text-2xl">Obory</h2>
                    <ul class="flex flex-col gap-row-2">
                        @foreach($school->specializations as $specialization)
                            <li class="list-disc py-1 ml-8">
                                <a href="/obor/{{$specialization->id}}">{{$specialization->prescribed_specialization->code}}
                                    - {{$specialization->prescribed_specialization->name}}</a><br/>
                                (ŠVP: <i>{{$specialization->name}}</i>)
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h2 class="text-2xl">Výstavy</h2>
                    <ul class="flex flex-col gap-row-2">
                        @foreach($school->ordered_registrations()->get() as $registration)
                            <li class="grid grid-cols-1 xl:grid-cols-2 ml-8 py-2">
                                <div>
                                    <a class="list-disc-block"
                                       href="/vystava/{{$registration->exhibition->id}}">{{format_date($registration->exhibition->date)}} {{$registration->exhibition->district->name}}
                                        ({{$registration->exhibition->name}})</a><br/>
                                </div>
                                <div class="mt-5 xl:mt-0">
                                    {{--                                TODO: variable hours--}}
                                    {{--                                zobrazit jen pokud se kona dnes--}}
                                    <span class="flex flex-col xl:ml-8 sm:inline-block sm:text-right">
                                        <a href="/vstoupit/ranni/{{$registration->id}}" target="_blank"
                                           class="btn text-sm text-center btn-primary">Online {{settings("morning_event_start")}} - {{settings("morning_event_end")}}</a>
                                        <a href="/vstoupit/vecerni/{{$registration->id}}" target="_blank"
                                           class="mt-4 text-sm sm:mt-0 sm:ml-2 text-center btn btn-primary">Online {{settings("evening_event_start")}} - {{settings("evening_event_end")}}</a>
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="mt-16">
                {!! $school->description !!}
            </div>
        </div>
    </div>
</div>

