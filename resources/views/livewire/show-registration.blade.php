<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="/skola/{{$registration->school->id}}">{{$registration->school->name}}
                <span class="text-sm ml-2 text-blue-500 hover:text-blue-600">Zobrazit</span></a>
            <br/>
            <span
                class="text-gray-500 text-base">{{$registration->exhibition->name}}</span>
            <br/>
            <span
                class="text-gray-500 text-base">{{format_date($registration->exhibition->date)}} - {{$registration->exhibition->district->region->name}}</span>
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 w-100">
            @php
                if(!empty($registration)){
                    $links = [
                            [
                             "title" => "Ranní akce",
                             "link" => "/vstoupit/ranni/$registration->id"
                            ],
                            [
                                "title" => "Večerní akce",
                                "link" => "/vstoupit/vecerni/$registration->id"
                            ]
                    ];
                }
            @endphp
            <div class="h-full flex flex-col sm:flex-row justify-around items-center sm:mt-32">
                @foreach($links as $link)
                    <div
                        class="mt-10 flex flex-col align-center text-center bg-gray-300 sm:px-32 sm:py-16 px-16 py-8 rounded w-3/4 sm:w-auto">
                        <h1 class="text-2xl">{{$link['title']}}</h1>
                        <a href="{{$link['link']}}"
                           class="hover:text-bold self-center text-white bg-blue-700 py-1 px-2 sm:py-2 sm:px-4 sm:w-36 w-full mt-5 block">
                            Vstoupit
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
