<div>
    <x-own-header>
        Fitlrovat školy
    </x-own-header>

    <div class="py-12">
        <x-dashboard-card>
            <div class="grid grid-cols-1 sm:grid-cols-2">
                <div class="grid grid-cols-1 sm:grid-cols-2">
                    <div>
                        <div>
                            <label for="region">Kraj</label>
                            <select wire:model="region_id" name="region" id="region" class="block">
                                @foreach($regions as $region)
                                    <option value="{{$region->id}}">{{$region->name}}</option>
                                @endforeach
                            </select>
                            <button wire:click="add_region" class="btn btn-primary mt-4">Přidat</button>
                        </div>
                        <div>
                            <ul>
                                @if(count($selected_regions) > 0)
                                    @foreach($selected_regions as $sr)
                                        <li>{{$sr['name']}}
                                            <button class="link" wire:click="remove_region({{$sr['id']}})">Odstranit
                                            </button>
                                        </li>
                                    @endforeach
                                @else
                                    Všechny kraje
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div>
                        <div>
                            <label for="region">Kraj</label>
                            <select wire:model="prescribed_specialization_id" name="region" id="region"
                                    class="block">
                                @foreach($prescribed_specializations as $ps)
                                    <option value="{{$ps->id}}">{{$ps->code}} - {{$ps->name}}</option>
                                @endforeach
                            </select>
                            <button wire:click="add_prescribed_specialization" class="btn btn-primary mt-4">Přidat
                            </button>
                        </div>
                        <div>
                            <ul>
                                @if(count($selected_prescribed_specializations)>0)
                                    @foreach($selected_prescribed_specializations as $sps)
                                        <li>{{$sps['code']}} - {{$sps['name']}}
                                            <button class="link"
                                                    wire:click="remove_prescribed_specialization({{$sps['id']}})">
                                                Odstranit
                                            </button>
                                        </li>
                                    @endforeach
                                @else
                                    Všechny obory
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-around">
                <button class="btn btn-primary" wire:click="show_filtered_schools">Zobraz školy</button>
            </div>
        </x-dashboard-card>
    </div>
</div>
