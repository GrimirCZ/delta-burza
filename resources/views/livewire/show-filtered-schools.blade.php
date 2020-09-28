{{-- You can change this template using File > Settings > Editor > File and Code Templates > Code > Laravel Ideal View --}}
<div>
    <div class="max-w-7xl mx-auto pt-5 pb-3 px-2 sm:px-6 lg:px-8 w-100 text-right">
        <button
            wire:click="show_filter"
            class="inline-block text-header hover:text-teal-400 transition duration-1000 py-4 mx-5"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 inline-block">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            <span class="align-middle">
                Upravit filtr škol
            </span>
        </button>
    </div>

    <div class="max-w-7xl mx-auto pb-10 px-2 sm:px-6 lg:px-8 w-100">
        <h1 class="text-2xl ml-3 mb-3">Školy</h1>
        <div class="grid md:grid-cols-2 gap-3">
            @foreach($schools as $school)
                <div class="p-5 bg-white shadow-sm box-border h-min-content">
                    <div class="leading-3 text-gray-400">{{$school->district->name}}</div>
                    <a href="/skola/{{$school->id}}"><h3
                            class="text-2xl font-light">{{$school->name}}</h3></a>

                    <table class="table w-full mt-5 text-sm text-gray-600">
                        <tbody class="divide-y divide-gray-200">
                        @foreach($school->ordered_specializations() as $specialization)
                            <tr>
                                <td class="py-3">
                                    <a href="/obor/{{$specialization->id}}">
                                        {{$specialization->prescribed_specialization->code}}
                                        - {{$specialization->prescribed_specialization->name}} <br/>
                                        <i>(ŠVP: {{$specialization->name}})</i>
                                    </a>
                                </td>
                                <td class="py-3 text-right">
                                    <a href="/obor/{{$specialization->id}}" class="btn bg-teal-400 text-white text-sm inline-block">Více informací o oboru</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="h-20"></div>

                    <a href="/skola/{{$school->id}}"
                       class="btn text-sm text-center mt-1 block bg-teal-400 hover:bg-teal-500 text-white">
                        Detail školy
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
                                {{$exhibition->school_count}} škol
                            @elseif($exhibition->school_count > 1)
                                {{$exhibition->school_count}} školy
                            @else
                                {{$exhibition->school_count}} škola
                            @endif

                            z vyfiltrovaných škol
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
