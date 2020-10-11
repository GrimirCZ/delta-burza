<div>
    <x-own-header
        top="{{$exhibition->district->region->name}} {{format_date($exhibition->date)}}">
        <span class="font-bold">{{$exhibition->city}}</span> ({{$exhibition->name}})<br>
        @if($exhibition->organizer_id != 1)
            <span class="italic text-lg">Pořadatel: {{$exhibition->organizer->short_name}}</span>
        @endif
    </x-own-header>

    <div>
        <div class="max-w-7xl mx-auto pt-0 pb-10 px-2 sm:px-6 lg:px-8 w-100">
            <div class="py-10">
                @if($exhibition->registrations->isEmpty())
                    <div class="text-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                             class="h-12 inline-block align-middle">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="ml-3 inline-block text-3xl align-middle">Do této výstavy se zatím žádný vystavovatel
                            nepřihlásil. Buďte první!</h3>
                    </div>
                @else
                    <div id="macyJS">
                        @foreach($registrations as $registration)
                            <div class="relative overflow-hidden shadow-sm box-border h-min-content bg-white {{$registration->school->is_school ? "" : "border-2 border-teal-400"}}">
                                @if($registration->school->id === 1)
                                    <div class="flag bg-light-green text-sm text-center text-white shadow-md">
                                        <span class="font-light">autoři portálu</span><br>
                                        <span class="font-black">BurzaŠkol.Online</span>
                                    </div>
                                @endif
                                <div class="p-5">
                                    <div class="leading-3 text-gray-400">
                                        {!! $registration->school->pipe_text() !!}
                                    </div>
                                    <a href="/skola/{{$registration->school->id}}">
                                        <div class="flex mt-3">
                                            @if($registration->school->logo())
                                                <div class="mr-5 py-3">
                                                <img src="{{$registration->school->logo()}}" alt="{{$registration->school->name}} logo" class="card-logo">
                                                </div>
                                            @endif
                                            <h3 class="text-2xl font-light">
                                                {{$registration->school->name}}
                                            </h3>
                                        </div>
                                    </a>

                                    <table class="table w-full mt-5 text-sm text-gray-600">
                                        <tbody class="divide-y divide-gray-200">
                                        @foreach($registration->school->ordered_specializations()->get() as $specialization)
                                            <tr>
                                                <td class="py-3">
                                                    <a href="/obor/{{$specialization->id}}">
                                                        {{$specialization->prescribed_specialization->code}}
                                                        - {{$specialization->prescribed_specialization->name}} <br/>
                                                        <i>(ŠVP: {{$specialization->name}})</i>
                                                    </a>
                                                </td>
                                                <td class="py-3 text-right w-48">
                                                    <a href="/obor/{{$specialization->id}}"
                                                       class="btn btn-primary text-sm inline-block">Více
                                                        informací o oboru</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                    @if($registration->exhibition->date == current_date_str())
                                        <a href="/vstoupit/ranni/{{$registration->id}}"
                                           target="_blank"
                                           class="btn text-sm text-center btn-primary mt-13 block">
                                            Připojit se online {{settings("morning_event_start")}}
                                            - {{settings("morning_event_end")}}
                                        </a>
                                        <a href="/vstoupit/vecerni/{{$registration->id}}"
                                           target="_blank"
                                           class="btn text-sm text-center btn-primary mt-1 block">
                                            Připojit se online {{settings("evening_event_start")}}
                                            - {{settings("evening_event_end")}}
                                        </a>
                                    @else
                                        <span
                                            class="btn text-sm text-center mt-13 block btn-disabled">
                                            Připojit se online {{settings("morning_event_start")}}
                                            - {{settings("morning_event_end")}}
                                        </span>
                                        <span
                                            class="btn text-sm text-center mt-1 block btn-disabled">
                                            Připojit se online {{settings("evening_event_start")}}
                                            - {{settings("evening_event_end")}}
                                        </span>
                                    @endif

                                    <a href="/skola/{{$registration->school->id}}"
                                       class="btn text-sm text-center mt-1 block bg-teal-400 hover:bg-teal-500 text-white">
                                        Detail @if($registration->school->is_school) školy @else firmy @endif
                                    </a>

                                    <div class="mt-4 text-sm hover:underline text-gray-400">
                                        <div class="display-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor" class="inline-block h-4 align-middle">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                            </svg>
                                            <a href="{{fix_url($registration->school->web)}}" target="_blank"
                                               class="align-middle">{{$registration->school->web}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <script>
                        let macyInstance = Macy({
                            container: '#macyJS',
                            columns: 1,
                            margin: {
                                x: 10,
                                y: 10
                            },
                            mobileFirst: true,
                            breakAt: {
                                870: {
                                    columns: 2
                                }
                            }
                        });
                    </script>
                @endif
            </div>
        </div>
    </div>
</div>
