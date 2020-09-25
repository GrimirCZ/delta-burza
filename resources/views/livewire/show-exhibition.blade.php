<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span class="font-bold">{{$exhibition->city}}</span>
            ({{$exhibition->name}})<br/>
            <span
                class="text-gray-500 text-base">{{format_date($exhibition->date)}}</span>
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 px-2 sm:px-6 lg:px-8 w-100">
            <div>
                @if($exhibition->registrations->isEmpty())
                    Této výstavy se neúčastní žádné školy
                @else
                    <div class="grid md:grid-cols-2 gap-3">
                        @foreach($registrations as $registration)
                            <div class="p-5 bg-white shadow-sm box-border">
                                <div class="leading-3 text-gray-400">{{$registration->school->district->name}}</div>
                                <a href="/skola/{{$registration->school->id}}"><h3 class="text-2xl font-light">{{$registration->school->name}}</h3></a>
                                @foreach($registration->school->ordered_specializations() as $specialization)
                                    <div class="text-left list-disc ml-5 mb-3">
                                        <a href="/obor/{{$specialization->id}}">
                                            {{$specialization->prescribed_specialization->code}}
                                            - {{$specialization->prescribed_specialization->name}} <br/>
                                            <i>(ŠVP: {{$specialization->name}})</i>
                                        </a>
                                    </div>
                                @endforeach

                                <a href="/vstoupit/ranni/{{$registration->id}}"
                                       target="_blank"
                                       class="btn text-sm text-center btn-primary mt-13 block">
                                    Online {{settings("morning_event_start")}} - {{settings("morning_event_end")}}
                                </a>
                                <a href="/vstoupit/vecerni/{{$registration->id}}"
                                   target="_blank"
                                   class="btn text-sm text-center btn-primary mt-1 block">
                                    Online {{settings("evening_event_start")}} - {{settings("evening_event_end")}}
                                </a>
                                <a href="/skola/{{$registration->school->id}}"
                                   class="btn text-sm text-center mt-1 block bg-teal-400 hover:bg-teal-500 text-white">
                                    Detail školy
                                </a>

                                <div class="mt-4 text-gray-400 text-sm hover:underline">
                                    <div class="display-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="inline-block h-4 align-middle">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                        </svg>
                                        <a href="{{fix_url($registration->school->web)}}" target="_blank" class="align-middle">{{$registration->school->web}}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
