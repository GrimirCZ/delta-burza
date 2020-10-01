<div>
    <div
        class="flex flex-col md:flex-row justify-between max-w-7xl mx-auto py-10 pb-0 px-2 sm:px-6 lg:px-8 w-100 items-center">
        <div class="inline-block order-1 w-full md:w-auto">
            <div class="top text-gray-600">{{$school->district->name}}</div>
            <h1 class="font-light text-3xl text-gray-800">{{$school->name}}</h1>
        </div>
        <div class="inline-block md:order-2 text-left w-full md:w-auto mb-10 md:mb-0">
            <img src="{{$school->logo()}}" class="h-8" alt="Logo {{$school->name}}">
        </div>
    </div>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 w-100 px-4">
            <div class="grid md:grid-cols-2 gap-3">
                <div class="bg-white p-5 shadow-sm box-border default-css">
                    {!! $school->description !!}
                </div>
                <div>
                    <div class="bg-white p-5 shadow-sm box-border">
                        <h2 class="p-2">Informace</h2>
                        <dl>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    Adresa
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                    <a href="http://maps.google.com/?q={{$school->address}}, {{$school->psc}} {{$school->city}}"
                                       target="_blank">
                                        {{$school->address}}, {{$school->psc}} {{$school->city}}
                                    </a>
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    Email
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                    <a href="mailto:{{$school->email}}">{{$school->email}}</a>
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    Telefon
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                    <a href="tel:{{$school->phone}}">{{$school->phone}}</a>
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    Webové stránky
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                    <a href="{{fix_url($school->web)}}">{{$school->web}}</a>
                                </dd>
                            </div>
                        <!--<div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    Přílohy
                                </dt>
                                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                    <ul class="border border-gray-200 rounded-md">
                                        <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm leading-5">
                                            <div class="w-0 flex-1 flex items-center">
                                                <svg class="flex-shrink-0 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                     fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                          d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                                <span class="ml-2 flex-1 w-0 truncate">
                                                    Informační brožura.pdf
                                                </span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <a href="{{$school->brojure()}}"
                                                   class="font-medium text-indigo-600 hover:text-indigo-500 transition duration-150 ease-in-out"
                                                   target="_blank">
                                                    Stáhnout
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </dd>
                            </div>-->
                        </dl>

                        @if($school->brojure())
                            <div class="mt-10">
                                <a href="{{$school->brojure()}}"
                                   class="btn bg-teal-400 text-white w-100 block text-center">Informační brožura - ke
                                    stažení</a>
                            </div>
                        @endif
                    </div>
                    <div class="bg-white p-5 shadow-sm box-border mt-3">
                        <h2 class="p-2">Obory</h2>
                        @foreach ($school->specializations as $specialization)
                            <div
                                class="{{ $loop->index % 2 === 0 ? "bg-gray-50": "bg-white"}} px-4 py-5 md:grid md:grid-cols-2 sm:gap-4 md:px-6">
                                <div class="text-sm leading-5 font-medium text-gray-500">
                                    {{$specialization->prescribed_specialization->code}}
                                    - {{$specialization->prescribed_specialization->name}} <br>
                                    (ŠVP: <i>{{$specialization->name}}</i>)
                                </div>
                                <div class="mt-5 text-sm leading-5 text-gray-900 md:mt-3">
                                    <a class="btn btn-primary truncate" href="/obor/{{$specialization->id}}">Více
                                        informací o oboru</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 shadow-sm box-border mt-3">
                <h2 class="text-2xl">Výstavy</h2>
                @foreach ($school->enabled_registrations()->get() as $registration)
                    <div
                        class="{{ $loop->index % 2 === 0 ? "bg-gray-50": "bg-white"}} px-4 py-5 md:grid md:grid-cols-2 md:gap-4 md:px-6">
                        <div class="text-sm leading-5 font-medium text-gray-500">
                            <a class=""
                               href="/vystava/{{$registration->exhibition->id}}">
                                <div class="">
                                    {{$registration->exhibition->district->region->name}}
                                    {{format_date($registration->exhibition->date)}}
                                </div>
                                <div class="text-lg font-light">
                                    <span class="font-black">{{$registration->exhibition->city}}</span>
                                    ({{$registration->exhibition->name}})
                                </div>
                            </a>
                        </div>
                        <div class="mt-5 text-sm leading-5 text-gray-900 sm:mt-3">
                            {{--                                zobrazit jen pokud se kona dnes--}}
                            @if($registration->exhibition->date == current_date_str())
                                <a href="/vstoupit/ranni/{{$registration->id}}" target="_blank"
                                   class="btn text-sm text-center mr-2 btn-primary inline-block">Online {{settings("morning_event_start")}}
                                    - {{settings("morning_event_end")}}</a>
                                <a href="/vstoupit/vecerni/{{$registration->id}}" target="_blank"
                                   class="mt-4 text-sm mr-2 text-center btn btn-primary inline-block">Online {{settings("evening_event_start")}}
                                    - {{settings("evening_event_end")}}</a>
                            @else
                                <span class="btn text-sm text-center mr-2 btn-disabled inline-block">Online {{settings("morning_event_start")}}
                                    - {{settings("morning_event_end")}}</span>
                                <span class="mt-4 text-sm mr-2 text-center btn btn-disabled inline-block">Online {{settings("evening_event_start")}}
                                    - {{settings("evening_event_end")}}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

