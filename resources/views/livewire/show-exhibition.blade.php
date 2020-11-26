<div>
    <x-own-header
        top="{{$title}}">
        <span class="font-bold">{{$exhibition->city}}</span> ({{$exhibition->name}})<br>
        @if($exhibition->organizer_id != 1)
            <span class="italic text-lg">Pořadatel: {{$exhibition->organizer->short_name}}</span>
        @endif

    </x-own-header>

    <div>
        <div class="max-w-7xl mx-auto pt-0 pb-10 px-2 px-6 lg:px-8 w-100">
            <div class="py-6 bg-teal-200 mt-6 mb-5">
                <div class="pb-6 pt-2 text-base min-w-full max-w-7xl mx-auto px-6 lg:px-8 w-100 text-header"
                     id="filter-component">
                    <div class="flex justify-between">
                        <h2 class="text-header font-bold text-2xl pb-4">Vyber si školu, co tě opravdu zajímá</h2>
                        @if($type != "all")
                            <div class="ml-4 transition duration-1000">
                                <button wire:click="clear_filter"
                                        class="inline-block py-4 mx-5 focus:outline-none btn font-light hover:bg-teal-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         class="h-5 inline-block">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 13h6m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span class="align-middle font-normal">Vyčistit filtr</span>
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="mr-5 mb-3 inline-block">
                        <div>Typ vystavovatele</div>
                        <div
                            class="region-input bg-white border border-gray-200 text-gray-700 p-1 max-w-16 rounded inline-block text-gray-700">
                            <div class="relative inline-block">
                                <select
                                    class="block appearance-none py-3 pr-8 pl-2 leading-tight bg-transparent outline-none max-w-200px"
                                    wire:model="type" name="type" id="type"
                                >
                                    <option value="all">Všechny</option>
                                    <option value="skoly" selected>Školy</option>
                                    <option value="firmy">Firmy</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20">
                                        <path
                                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($type == "skoly")
                        <div class="mr-5 mb-3 inline-block">
                            <div>Typ školy</div>
                            <div
                                class="region-input bg-white border border-gray-200 text-gray-700 p-1 max-w-16 rounded inline-block text-gray-700 w-256px">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="#aeaeae"
                                     class="h-7 inline-block ml-2">
                                    <path fill="#fff" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                    <path fill="#fff"
                                          d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                                </svg>
                                <div class="relative inline-block">
                                    <select
                                        class="block appearance-none py-3 pr-8 pl-2 leading-tight bg-transparent outline-none max-w-200px"
                                        wire:model="type_of_study_id" name="type_of_study" id="type_of_study"
                                    >
                                        <option value="all">Všechny typy škol</option>
                                        @foreach($type_of_studies as $tos)
                                            <option value="{{$tos->id}}">{{$tos->name}}</option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20">
                                            <path
                                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($type_of_study_id != "all")
                            <div class="mr-5 mb-3 inline-block">
                                <div>Zaměření</div>
                                <div
                                    class="region-input bg-white border border-gray-200 text-gray-700 p-1 max-w-16 rounded inline-block text-gray-700 w-256px">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke="#aeaeae"
                                         class="h-6 inline-block ml-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <div class="relative inline-block">
                                        <select
                                            class="block appearance-none py-3 pr-8 pl-2 leading-tight bg-transparent outline-none max-w-200px"
                                            wire:model="field_of_study_id" name="field_of_study" id="field_of_study"
                                        >
                                            <option value="all">Všechna zaměření</option>
                                            @foreach($field_of_studies as $fos)
                                                <option value="{{$fos->id}}">{{$fos->name}}</option>
                                            @endforeach
                                        </select>

                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 20 20">
                                                <path
                                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($field_of_study_id != "all")
                                <div class="mr-5 mb-3 inline-block">
                                    <div>Obor</div>
                                    <div
                                        class="region-input bg-white border border-gray-200 text-gray-700 p-1 max-w-16 rounded inline-block text-gray-700 w-256px">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke="#aeaeae"
                                             class="h-6 inline-block ml-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <div class="relative inline-block">
                                            <select
                                                class="block appearance-none py-3 pr-8 pl-2 leading-tight bg-transparent outline-none max-w-200px"
                                                wire:model="prescribed_specialization_id" name="region" id="region"
                                            >
                                                <option value="all">Všechny obory</option>
                                                @foreach($prescribed_specializations as $ps)
                                                    <option value="{{$ps->id}}">{{$ps->code}} - {{$ps->name}}</option>
                                                @endforeach
                                            </select>

                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
            <div class="py-4">
                @if($is_empty)
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
                            <div
                                class="relative overflow-hidden shadow-sm box-border h-min-content bg-white {{$registration->school->type() == "school" ? "" : "border-2 border-teal-400"}}">
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
                                                    <img src="{{$registration->school->logo()}}"
                                                         alt="{{$registration->school->name}} logo" class="card-logo">
                                                </div>
                                            @endif
                                            <h3 class="text-2xl font-light">
                                                {{$registration->school->name}}
                                            </h3>
                                        </div>
                                    </a>

                                    <table class="table w-full mt-5 text-sm text-gray-600">
                                        <tbody class="divide-y divide-gray-200">
                                        @php
                                            if($type_of_study_id == "all" && $field_of_study_id == "all" && $prescribed_specialization_id == "all"){
                                                $specializations = $registration->school->ordered_specializations()->get();
                                            } else if($field_of_study_id == "all" && $prescribed_specialization_id == "all"){
                                                $specializations = $registration->school
                                                                    ->ordered_specializations()
                                                                    ->where("type_of_studies.id", "=", $type_of_study_id)
                                                                    ->select("specializations.*")
                                                                    ->get();
                                            } else if($prescribed_specialization_id == "all"){
                                                $specializations = $registration->school
                                                                    ->ordered_specializations()
                                                                    ->where("field_of_studies.id", "=", $field_of_study_id)
                                                                    ->select("specializations.*")
                                                                    ->get();
                                            } else{
                                                $specializations = $registration->school->ordered_specializations()->where("prescribed_specialization_id", $prescribed_specialization_id)->get();
                                            }
                                        @endphp
                                        @foreach($specializations as $specialization)
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

                                    <div class="flex justify-between mt-10 text-gray-900">
                                        <a href="{{$registration->get_try_link()}}" class="hover:text-teal-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor" class="h-5 inline-block">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            <span class="underline">Vyzkoušej si spojení "nanečisto"</span>
                                        </a>
                                        @php
                                            $provider = $registration->get_provider();
                                        @endphp
                                        <a href="@if($provider == 'ms') https://youtu.be/u9on9jIpQ6Y @elseif($provider == "google") https://youtu.be/UL7HrLIaodU @else {{route('jak-se-pripojit')}} @endif"
                                           class="hover:text-teal-400" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor" class="h-5 inline-block">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="underline">Návod: Jak se připojit k hovoru</span>
                                        </a>
                                    </div>

                                    @php
                                        $morning_provider = $provider;
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
                                    @endphp

                                    @if($enable_join_buttons)
                                        <a href="/vstoupit/ranni/{{$registration->id}}"
                                           target="_blank"
                                           class="btn text-sm text-center mt-2 btn-primary block">
                                            {{$morning_message}} {{settings("morning_event_start")}}
                                            - {{settings("morning_event_end")}}
                                        </a>
                                        <a href="/vstoupit/vecerni/{{$registration->id}}"
                                           target="_blank"
                                           class="btn text-sm text-center btn-primary mt-1 block">
                                            {{$evening_message}} {{settings("evening_event_start")}}
                                            - {{settings("evening_event_end")}}
                                        </a>
                                        <a href="/vstoupit/chat/{{$registration->id}}"
                                           target="_blank"
                                           class="btn text-sm text-center btn-primary mt-1 block">
                                            Chat
                                        </a>
                                    @else
                                        <span
                                            class="btn text-sm text-center mt-2 block btn-disabled">
                                              {{$morning_message}} {{settings("morning_event_start")}}
                                            - {{settings("morning_event_end")}}
                                        </span>
                                        <span
                                            class="btn text-sm text-center mt-1 block btn-disabled">
                                           {{$evening_message}} {{settings("evening_event_start")}}
                                            - {{settings("evening_event_end")}}
                                        </span>
                                        <span
                                            class="btn text-sm text-center mt-1 block btn-disabled">
                                            Chat
                                        </span>
                                    @endif

                                    <a href="/skola/{{$registration->school->id}}/zajem/{{$registration->id}}"
                                       class="btn text-sm text-center mt-1 block bg-teal-400 hover:bg-teal-500 text-white">
                                        Napište nám!
                                    </a>

                                    <a href="/skola/{{$registration->school->id}}"
                                       class="btn text-sm text-center btn-primary mt-1 block">
                                        Detail {{$registration->school->type_name(2)}}
                                    </a>

                                    <div class="mt-4 text-sm hover:underline text-gray-400">
                                        <div>

                                            <a href="{{fix_url($registration->school->web)}}" target="_blank"
                                               class="hover:text-teal-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke="currentColor" class="inline-block h-4 align-middle">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                                </svg>
                                                {{$registration->school->web}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{ $registrations->links() }}
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

                        const debounce = (func, wait) => {
                            let timeout;

                            return function executedFunction(...args) {
                                const later = () => {
                                    timeout = null;
                                    func(...args);
                                };
                                clearTimeout(timeout);

                                timeout = setTimeout(later, wait);
                            };
                        };

                        document.addEventListener("DOMContentLoaded", () => {
                            Livewire.hook('element.updated', debounce(() => {
                                console.log("re");
                                macyInstance.reInit()
                            }, 5))
                        });
                    </script>
                @endif
            </div>
        </div>
    </div>
</div>
