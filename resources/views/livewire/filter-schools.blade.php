<div>
    <x-own-header>
        Fitlrovat školy
    </x-own-header>

    <div class="pb-12 pt-3">
        <div class="max-w-7xl mx-auto pt-0 pb-10 sm:px-6 lg:px-8 w-100 flex  text-gray-700">
            <div class="mr-5">
                <div>Typ studia</div>
                <div class="region-input bg-gray-200 border border-gray-200 text-gray-700 p-1 max-w-16 rounded inline-block text-gray-700 w-256px">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#aeaeae" class="h-7 inline-block ml-2">
                        <path fill="#fff" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path fill="#fff" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                    <div class="relative inline-block">
                        <select
                            class="block appearance-none py-3 pr-8 pl-2 leading-tight bg-transparent outline-none max-w-200px"
                            wire:model="type_of_study_id" name="type_of_study" id="type_of_study"
                        >
                            <option value="all">Všechny typy studia</option>
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
                <div class="mr-5">
                    <div>Zaměření</div>
                    <div class="region-input bg-gray-200 border border-gray-200 text-gray-700 p-1 max-w-16 rounded inline-block text-gray-700 w-256px">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#aeaeae" class="h-6 inline-block ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
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
            @endif
            @if($field_of_study_id != "all")
                <div class="mr-5">
                    <div>Obor</div>
                    <div class="region-input bg-gray-200 border border-gray-200 text-gray-700 p-1 max-w-16 rounded inline-block text-gray-700 w-256px">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#aeaeae" class="h-6 inline-block ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
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
        </div>

        <x-dashboard-card>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#aeaeae"
                     class="h-5 inline-block">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Kraj
            </div>

            <div class="mt-4">
                <div class="grid grid-cols-1 sm:grid-cols-2">
                    @foreach($regions as $index => $region)
                        <div>
                            <input type="checkbox" wire:model="regions.{{$index}}.selected"
                                   id="skola{{$region['id']}}">
                            <label for="skola{{$region['id']}}">{{$region['name']}}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </x-dashboard-card>

        <div class="max-w-7xl mx-auto pt-5 sm:px-6 lg:px-8 w-100">
            <button class="btn btn-primary" wire:click="show_filtered_schools">Filtrovat</button>
            <button wire:click="clear_filter" class="inline-block text-header hover:text-teal-400 transition duration-1000 py-4 mx-5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 inline-block">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <span class="align-middle">
                    Vyčistit filtr
                </span>
            </button>
        </div>
    </div>
</div>
