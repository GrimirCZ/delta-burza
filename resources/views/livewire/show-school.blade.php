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
                        <a href="http://maps.google.com/?q={{$school->address}}" target="_blank" class="font-bold">
                            {{$school->address}}
                        </a>
                        <div class="mt-4"></div>
                        <a href="mailto:{{$school->email}}" class="font-bold">{{$school->email}}</a><br/>
                        <a href="tel:{{$school->phone}}" class="font-bold">{{$school->phone}}</a><br/>
                        <a href="{{fix_url($school->web)}}" class="font-bold">{{$school->web}}</a><br/>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <span><a href="#" class="font-bold"><img src="{{asset("/images/pdf.svg")}}" alt="PDF"
                                                                 class="w-6 h-6 inline-block mr-4">Informační brožura.pdf</a></span>
                    </div>
                </div>
            </div>
            <div class="mt-8 grid school-detail-grid">
                <div>
                    <h2 class="text-2xl">Obory</h2>
                    <ul class="flex flex-col gap-row-2">
                        @foreach($school->specializations as $specialization)
                            <li class="list-disc py-2 ml-8">
                                <a href="/obor/{{$specialization->id}}">{{$specialization->prescribed_specialization->code}}
                                    - {{$specialization->prescribed_specialization->name}}</a><br/>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h2 class="text-2xl">Výstavy</h2>
                    <ul class="flex flex-col gap-row-2">
                        @foreach($school->registrations as $registration)
                            <li class="list-disc ml-8 py-2">
                                <span class="inline-block">
                                    <a href="/vystava/{{$registration->exhibition->id}}">{{format_date($registration->exhibition->date)}} {{$registration->exhibition->district->name}}
                                        ({{$registration->exhibition->name}})</a><br/>
                                </span>
                                <span class="inline-block">
                                    {{--                                TODO: variable hours--}}
                                    {{--                                zobrazit jen pokud se kona dnes--}}
                                    <span class="flex flex-col sm:ml-8 sm:inline justify-end sm:text-right">
                                        <a href="/vstoupit/ranni/{{$registration->id}}"
                                           class="btn text-center btn-primary">Online 8:00-9:00</a>
                                        <a href="/vstoupit/vecerni/{{$registration->id}}"
                                           class="mt-4 sm:mt-0 sm:ml-2 text-center btn btn-primary">Online 18:00 - 21:00</a>
                                    </span>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

