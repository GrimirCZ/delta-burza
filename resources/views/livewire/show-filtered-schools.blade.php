{{-- You can change this template using File > Settings > Editor > File and Code Templates > Code > Laravel Ideal View --}}
<div>
    <header class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 w-100 pt-8 flex justify-between">
        <div class="inline-block text-1xl font-light text-2xl md:text-3xl text-gray-800">
            Vybraní vystavovatelé
        </div>
        <button
            wire:click="show_filter"
            class="inline-block text-header hover:text-teal-400 transition duration-1000 py-4 mx-5 focus:outline-none"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                 class="h-5 inline-block">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            <span class="align-middle">
                Upravit filtr
            </span>
        </button>
    </header>


    <div class="max-w-7xl mx-auto pb-10 px-2 sm:px-6 lg:px-8 w-100">
        <h1 class="text-2xl ml-3 mb-3">Vystavovatelé</h1>

        @if(count($schools) === 0)
            <div class="text-center text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                     class="h-12 inline-block align-middle">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="ml-3 inline-block text-3xl align-middle">Nebyli nalezeni žádní vystavovatelé, kteří by odpovídali podmínkám.</h3>

                <div class="align-center">
                    <button
                        wire:click="show_filter"
                        class="text-gray-300 hover:text-gray-400 transition duration-1000 py-4 mx-5 inline-block focus:outline-none"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                             class="h-5 inline-block">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <span class="align-middle">
                            Upravit filtr
                        </span>
                    </button>
                </div>

            </div>
        @endif

        <div class="grid md:grid-cols-2 gap-3">
            @foreach($schools as $school)
                <div class="p-5 bg-white shadow-sm box-border h-min-content {{$school->is_school ?  "border-2 border-teal-400" : ""}}">
                    <div class="leading-3 text-gray-400">{{$school->is_school ?  "škola" : "firma"}} | okres {{$school->district->name}}</div>
                    <a href="/skola/{{$school->id}}"><h3
                            class="text-2xl font-light">{{$school->name}}</h3></a>

                    <table class="table w-full mt-5 text-sm text-gray-600">
                        <tbody class="divide-y divide-gray-200">
                        @php
                            if($prescribed_specialization_id == "all"){
                                $specializations = $school->ordered_specializations()->get();
                            }else{
                                $specializations = $school->ordered_specializations()->where("prescribed_specialization_id", $prescribed_specialization_id)->get();
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
                                <td class="py-3 text-right">
                                    <a href="/obor/{{$specialization->id}}"
                                       class="btn btn-primary text-white text-sm inline-block">Více informací o
                                        oboru</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="h-20"></div>

                    <a href="/skola/{{$school->id}}"
                       class="btn text-sm text-center mt-1 block bg-teal-400 hover:bg-teal-500 text-white">
                        Detail @if($school->is_school) školy @else firmy @endif
                    </a>

                    <div class="mt-4 text-gray-400 text-sm hover:underline">
                        <div class="display-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" class="inline-block h-4 align-middle">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                            </svg>
                            <a href="{{fix_url($school->web)}}" target="_blank"
                               class="align-middle">{{$school->web}}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-10 px-2 sm:px-6 lg:px-8 w-100">
        <h1 class="text-2xl ml-3 mb-3">Výstavy</h1>
        @if(count($exhibitions) === 0)
            <div class="text-center text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                     class="h-12 inline-block align-middle">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="ml-3 inline-block text-3xl align-middle">Nebyly nalezeny žádné výstavy s vystavovateli, kteří
                    by odpovídali podmínkám.</h3>
            </div>
        @endif
        <div class="grid md:grid-cols-2 gap-3">
            @foreach($exhibitions as $exhibition)
                <a href="/vystava/{{$exhibition->id}}">
                    <div class="exhibitions-card p-5 bg-white shadow-sm box-border text-gray-900">
                        <div
                            class="date">{{$exhibition->district->region->name}} {{format_date($exhibition->date)}}</div>
                        <h3 class="text-2xl font-light"><span
                                class="font-black">{{$exhibition->city}}</span> {{$exhibition->name}}</h3>
                        <div class="text-sm text-gray-600">
                            @if($exhibition->school_count > 4)
                                {{$exhibition->school_count}} vystavovatelů
                            @elseif($exhibition->school_count > 1)
                                {{$exhibition->school_count}} vystavovatelé
                            @else
                                {{$exhibition->school_count}} vystavovatel
                            @endif

                            z vyfiltrovaných vystavovatelů
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
