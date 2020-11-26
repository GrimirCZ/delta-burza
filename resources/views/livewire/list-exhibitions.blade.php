<div class="h-full">
    @push("scripts")
        @once
        <script src="/js/app.js" defer></script>
        @endonce
    @endpush

    <div class="h-full px-2">
        <div class="max-w-7xl mx-auto pt-5 pb-10 sm:px-6 lg:px-8 w-100">
            <div class="mb-5">
                <div
                    class="region-input bg-gray-200 border border-gray-200 text-gray-700 p-1 max-w-18 rounded inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#aeaeae"
                         class="h-7 inline-block ml-2">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <div class="relative inline-block">
                        <select
                            class="block appearance-none py-3 pr-8 pl-2 leading-tight bg-transparent outline-none"
                            onChange="redirectToRegion(this)">
                            <option value="">Všechny kraje</option>
                            @foreach($regions as $region)
                                @if($region->id === $regionSelected)
                                    <option value={{$region->id}} selected>{{$region->name}}</option>
                                @else
                                    <option value={{$region->id}}>{{$region->name}}</option>
                                @endif
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
                <a href="/skola/filtrovat"
                   class="inline-block text-header hover:text-teal-400 transition duration-1000 py-4 mx-5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                         class="h-5 inline-block">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <span class="align-middle">
                            Filtrovat vystavovatele
                        </span>
                </a>
            </div>

            @if($exhibitions->isEmpty())
                <div class="text-center text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                         class="h-12 inline-block align-middle">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="ml-3 inline-block text-3xl align-middle">Žádné výstavy se nekonají</h3>
                </div>
            @else
                <div class="grid md:grid-cols-2 gap-3">
                    @foreach($exhibitions as $exhibition)
                        <a href="/vystava/{{$exhibition->id}}">
                            <div class="exhibitions-card p-5 bg-white shadow-sm hover:shadow-lg box-border text-gray-900">
                                <div
                                    class="date">{{$exhibition->region_name}} {{format_date($exhibition->date)}} <i>(test připojení {{format_date($exhibition->test_date)}})</i></div>
                                <h3 class="text-2xl font-light"><span
                                        class="font-black">{{$exhibition->city}}</span> {{$exhibition->name}}</h3>
                                @if($exhibition->organizer_id != 1)
                                    <span class="italic">Pořadatel: {{$exhibition->organizer->short_name}}</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
