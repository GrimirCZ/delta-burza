<div>
    <div
        class="flex flex-col md:flex-row justify-between max-w-7xl mx-auto py-10 pb-0 px-2 sm:px-6 lg:px-8 w-100 items-center">
        <div class="inline-block order-1 w-full md:w-auto">
            <div class="top text-gray-600">{!! $school->pipe_text() !!}</div>
            <h1 class="font-light text-3xl text-gray-800">{{$school->name}}</h1>
        </div>
        <div class="inline-block md:order-2 text-left w-full md:w-auto mb-10 md:mb-0">
            @if($school->has_logo())
                <img src="{{$school->logo()}}" class="school-logo" alt="Logo {{$school->name}}">
            @endif
        </div>
    </div>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 w-100 px-4">
            <div class="grid md:grid-cols-2 gap-3">
                <div class="bg-white p-5 shadow-sm box-border default-css overflow-x-auto">
                    {!!  $school->description !!}
                </div>
                <div>
                    <div class="bg-white p-5 shadow-sm box-border">
                        <div class="p-2">
                            <h2 class="text-lg">Informace</h2>
                        </div>
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
                            @if($school->email != null)
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm leading-5 font-medium text-gray-500">
                                        Email
                                    </dt>
                                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                        <a href="mailto:{{$school->email}}">{{$school->email}}</a>
                                    </dd>
                                </div>
                            @endif
                            @if($school->phone != null)
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm leading-5 font-medium text-gray-500">
                                        Telefon
                                    </dt>
                                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                        <a href="tel:{{$school->phone}}">{{$school->phone}}</a>
                                    </dd>
                                </div>
                            @endif
                            @if($school->web != null)
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm leading-5 font-medium text-gray-500">
                                        Webové stránky
                                    </dt>
                                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                        <a href="{{fix_url($school->web)}}">{{$school->web}}</a>
                                    </dd>
                                </div>
                            @endif
                        </dl>

                        @if($school->brojure() !== "#")
                            <div class="mt-10">
                                <a href="{{$school->brojure()}}"
                                   class="btn bg-teal-400 text-white w-100 block text-center">Informační brožura - ke
                                    stažení</a>
                            </div>
                        @endif
                        @if($school->is_registered())
                            <div class="mt-2">
                                <a href="/skola/{{$school->id}}/zajem"
                                   class="btn bg-teal-400 text-white w-100 block text-center">
                                    Napište nám!
                                </a>
                            </div>
                        @endif
                    </div>
                    @if($school->type_can_have_specializations())
                        <div class="bg-white p-5 shadow-sm box-border mt-3">
                            <h2 class="p-2 text-lg">Obory</h2>
                            @if($show_maturita_exam_result_notice)
                                <p class="p-2">V detailu maturitních oborů najdete <b>výsledky školy u státních
                                        maturit</b> za posledních 5 let.
                                    <i class="text-sm">(zdroj: <a class="link" href="https://vysledky.cermat.cz"
                                                                  target="_blank">https://vysledky.cermat.cz</a>)</i>
                                </p>
                            @endif
                            @foreach ($specializations as $specialization)
                                <div
                                    class="{{ $loop->index % 2 === 0 ? "bg-gray-50": "bg-white"}} px-4 py-5 md:grid md:grid-cols-2 sm:gap-4 md:px-6">
                                    <div class="text-sm leading-5 font-medium text-gray-500">
                                        {{$specialization->prescribed_specialization->code}}
                                        - {{$specialization->prescribed_specialization->name}} <br>
                                        @if($school->is_registered())(ŠVP: <i>{{$specialization->name}}</i>)@endif
                                    </div>
                                    <div
                                        class="mt-5 leading-5 text-gray-900 md:mt-0 md:flex md:place-items-center
                                        md:justify-end">
                                        <a class="btn btn-primary truncate" href="/obor/{{$specialization->id}}">Více
                                            informací o oboru</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if($school->type_can_be_related_to())
                        @if($school->related_companies()->count() > 0)
                            <div class="bg-white p-5 shadow-sm box-border mt-3">
                                <h2 class="p-2 text-lg">Spolupracující firmy</h2>
                                @foreach ($school->related_companies as $related_company)
                                    <div
                                        class="{{ $loop->index % 2 === 0 ? "bg-gray-50": "bg-white"}} px-4 py-5 md:grid md:grid-cols-2 sm:gap-4 md:px-6">
                                        <div class="text-sm leading-5 font-medium text-gray-500">
                                            {{$related_company->name}}
                                        </div>
                                        <div class="mt-5 leading-5 text-gray-900 md:mt-0 md:flex md:place-items-center
                                            md:justify-end">
                                            <a class="btn btn-primary truncate" href="/skola/{{$related_company->id}}">
                                                Zobrazit detail firmy
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endif
                    @if($school->type_can_have_related())
                        <div class="bg-white p-5 shadow-sm box-border mt-3">
                            <h2 class="p-2">Spolupracující školy</h2>
                            @foreach ($school->related_schools as $related_schools)
                                <div
                                    class="{{ $loop->index % 2 === 0 ? "bg-gray-50": "bg-white"}} px-4 py-5 md:grid md:grid-cols-2 sm:gap-4 md:px-6">
                                    <div class="text-sm leading-5 font-medium text-gray-500">
                                        {{$related_schools->name}}
                                    </div>
                                    <div class="mt-5 leading-5 text-gray-900 md:mt-0 md:flex md:place-items-center
                                        md:justify-end">
                                        <a class="btn btn-primary truncate" href="/skola/{{$related_schools->id}}">
                                            Zobrazit detail školy
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if($school->type_can_show_contest_results() && count($contest_results) > 0)
                        <div class="bg-white p-5 shadow-sm box-border mt-3">
                            <div class="p-2">
                                <h2 class="text-lg">Výsledky v soutěžích MŠMT</h2>
                                <i class="text-sm">(zdroj: <a class="link" href="https://excelence.msmt.cz"
                                                              target="_blank">https://excelence.msmt.cz</a>)</i>
                            </div>
                            <p class="p-2">
                                Pravidelné úspěchy v soutěžích ukazují na <b>systematickou práci</b> školy <b>s&nbsp;talentovanými
                                    studenty</b>. U středních odborných škol a učilišť odráží <b>úroveň
                                    výuky odborných předmětů</b>. Gymnázia mívají úspěchy především v&nbsp;humanitních a
                                přírodovědných olympiádách.
                            </p>
                            <div class="p-2">
                                <i>Ročník soutěží MŠMT 2020 byl kvůli COVIDU úplně zrušen.</i>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-100 mb-4">
                                    <tr>
                                        <th class="cell tighter empty"></th>
                                        <th class="cell th-background text-center relative px-6 fw">
                                            <b>&sum;</b>
                                            <div class="livewire-tooltip">
                                                <livewire:tooltip title="Body"
                                                                  :content="$textBody"/>
                                            </div>
                                        </th>
                                        <th class="cell tighter th-background text-center relative px-6 fw">
                                            <b>Umístění v soutěži</b>
                                        </th>
                                    </tr>
                                    @foreach($contest_result_years as $year)
                                        @php
                                            $all_year_contest_results = collect($contest_results)->filter(fn($cr) => $cr['year'] == $year);
                                            $point_sum = $all_year_contest_results->sum(fn($cr) => $cr['points']);
                                            $year_contest_results = $all_year_contest_results->take(3);
                                        @endphp

                                        @foreach($year_contest_results as $ycr)
                                            <tr>
                                                @if($loop->first)
                                                    <td class="cell tighter"
                                                        rowspan="{{$year_contest_results->count()}}">
                                                        {{$year}}
                                                    </td>
                                                    <td class="cell tighter"
                                                        rowspan="{{$year_contest_results->count()}}">
                                                        <b>
                                                            {{round($point_sum, 1)}}
                                                        </b>
                                                        @if($year_contest_results->count() < $all_year_contest_results->count())
                                                            <br/>
                                                            <button class="link"
                                                                    wire:click="$emitSelf('openDetail', {{$year}})">
                                                                více
                                                            </button>
                                                        @endif
                                                    </td>
                                                @endif
                                                <td class="cell tighter" style="text-align: left !important;">
                                                    <b>{{$ycr['place']}}. místo - {{$ycr['level_name']}}</b>
                                                    {{$ycr['name']}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        @if($show_more_for_year != null)
                            @php
                                $all_year_contest_results = collect($contest_results)->filter(fn($cr) => $cr['year'] == $show_more_for_year);
                                $point_sum = $all_year_contest_results->sum(fn($cr) => $cr['points']);
                            @endphp
                            <x-overlay>
                                <x-slot name="title">
                                    Výsledky soutěží pro rok {{$show_more_for_year}}
                                </x-slot>
                                <table class="w-100 mb-4 overflow-x-auto">
                                    <tr>
                                        <th class="cell th-background text-center relative px-6 fw">
                                            <b>&sum;</b>
                                            <div class="livewire-tooltip">
                                                <livewire:tooltip title="Body"
                                                                  :content="$textBody"/>
                                            </div>
                                        </th>
                                        <th class="cell tighter th-background text-center relative px-6 fw">
                                            <b>Umístění v soutěži</b>
                                        </th>
                                        <th class="cell tighter th-background text-center relative px-6 fw">
                                            Počet bodů
                                        </th>
                                    </tr>
                                    @foreach($all_year_contest_results as $ycr)
                                        <tr>
                                            @if($loop->first)
                                                <td class="cell"
                                                    rowspan="{{$all_year_contest_results->count()}}">
                                                    <b>
                                                        {{round($point_sum, 1)}}
                                                    </b>
                                                </td>
                                            @endif
                                            <td class="cell tighter" style="text-align: left !important;">
                                                <b>{{$ycr['place']}}. místo - {{$ycr['level_name']}}</b>
                                                {{$ycr['name']}}
                                            </td>
                                            <td class="cell tighter">
                                                @if($ycr['points'] == 0)
                                                    -
                                                @else
                                                    {{$ycr['points']}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </x-overlay>
                        @endif
                    @endif

                    @if($school->type_can_have_inspection_reports() && count($inspection_reports) > 0)
                        <div class="bg-white p-5 shadow-sm box-border mt-3">
                            <div class="p-2">
                                <h2 class="text-lg">Inspekční zprávy</h2>
                                <i class="text-sm">(zdroj: Portál České školní inspekce <a class="link"
                                                                                           href="https://csisr.cz/cz/Dokumenty/Inspekcni-zpravy"
                                                                                           target="_blank">https://csisr.cz/cz/Dokumenty/Inspekcni-zpravy</a>)</i>
                            </div>
                            @foreach($inspection_reports as $inspection_report)
                                <div
                                    class="{{ $loop->index % 2 === 0 ? "bg-gray-50": "bg-white"}} px-4 py-3 text-gray-500 text-sm flex justify-between">
                                    <div>{{format_date($inspection_report->start_date)}}
                                        - {{format_date($inspection_report->end_date)}}
                                    </div>
                                    <div>
                                        <a class="btn btn-primary truncate text-xs" target="_blank"
                                           href="{{$inspection_report->url}}">Zobrazit zprávu</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            @if($school->is_registered())
                <div class="bg-white p-5 shadow-sm box-border mt-3">
                    <h2 class="text-2xl mb-3">
                        Výstavy
                        <a href="{{route("try-connect")}}"
                           class="text-header ml-4 text-lg hover:text-teal-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 class="h-5 inline-block">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            Vyzkoušej si spojení "nanečisto"
                        </a>
                        <a href="https://youtu.be/u9on9jIpQ6Y" target="_blank"
                           class="text-header ml-4 text-lg hover:text-teal-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 class="h-5 inline-block">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Návod: Jak se připojit k hovoru
                        </a>
                    </h2>
                    @foreach ($school->enabled_registrations_today()->get() as $registration)
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
                            <div class="mt-5 text-sm leading-5 text-gray-900 sm:mt-3 text-right">
                                @php
                                    $exhibition = $registration->exhibition;
                                    $morning_provider = $registration->get_provider('morning');
                                    $evening_provider = $registration->get_provider('evening');

                                    $morning_message = "Připojit se ";
                                    $evening_message = "Připojit se ";

                                    if($morning_provider == 'ms'){
                                        $morning_message .= 'k Teams';
                                    }else if($morning_provider == 'google'){
                                        $morning_message .= 'k Meets';
                                    }else{
                                        $morning_message .= 'online';
                                    }

                                    if($evening_provider == 'ms'){
                                        $evening_message .= 'k Teams';
                                    }else if($evening_provider == 'google'){
                                        $evening_message .= 'k Meets';
                                    }else{
                                        $evening_message .= 'online';
                                    }

                                    $has_morning = $exhibition->has_morning_event;
                                    $has_evening = $exhibition->has_evening_event;
                                    $has_test = $exhibition->has_test_event;
                                    $has_chat = $exhibition->has_chat;

                                    $enable_morning_join_buttons = $exhibition->enable_morning_join_buttons() || $exhibition->enable_test_join_buttons();
                                    $enable_evening_join_buttons = $exhibition->enable_evening_join_buttons() || $exhibition->enable_test_join_buttons();
                                    $enable_chat = $exhibition->enable_chat() || $exhibition->enable_test_join_buttons();
                                @endphp

                                @if($has_morning)
                                    @if($enable_morning_join_buttons)

                                        <a href="/vstoupit/ranni/{{$registration->id}}" target="_blank"
                                           class="btn text-sm mr-1 text-center btn-primary inline-block">{{$morning_message}} {{$registration->exhibition->morning_event_start}}
                                            - {{$registration->exhibition->morning_event_end}}</a>
                                    @else
                                        <span
                                            class="btn text-sm mr-1 text-center btn-disabled inline-block">{{$morning_message}} {{$registration->exhibition->morning_event_start}}
                                    - {{$registration->exhibition->morning_event_end}}</span>
                                    @endif
                                @endif
                                @if($has_evening)
                                    @if($enable_evening_join_buttons)

                                        <a href="/vstoupit/vecerni/{{$registration->id}}" target="_blank"
                                           class="mt-4 text-sm mr-1 text-center btn btn-primary inline-block">{{$evening_message}} {{$registration->exhibition->evening_event_start}}
                                            - {{$registration->exhibition->evening_event_end}}</a>
                                    @else

                                        <span
                                            class="mt-4 text-sm mr-1 text-center btn btn-disabled inline-block">{{$evening_message}}  {{$registration->exhibition->evening_event_start}}
                                    - {{$registration->exhibition->evening_event_end}}</span>
                                    @endif
                                @endif
                                @if($has_chat)
                                    @if($enable_chat)

                                        <a href="/vstoupit/chat/{{$registration->id}}" target="_blank"
                                           class="mt-4 text-sm mr-2 text-center btn btn-primary inline-block">Chat</a>
                                    @else
                                        <span
                                            class="mt-4 text-sm mr-2 text-center btn btn-disabled inline-block">Chat</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

