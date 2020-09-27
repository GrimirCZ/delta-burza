<div>
    <x-own-header>
        Fitlrovat školy
    </x-own-header>

    <div class="py-12">
        <x-dashboard-card>
            <div class="grid grid-cols-1 sm:grid-cols-2">
                <div>
                    <div>
                        <div>
                            <label for="type_of_study">Typ studia</label>
                            <select wire:model="type_of_study_id" name="type_of_study" id="type_of_study"
                                    class="block">
                                <option value="all">Všechny typy studia</option>
                                @foreach($type_of_studies as $tos)
                                    <option value="{{$tos->id}}">{{$tos->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if($type_of_study_id != "all")
                            <div>
                                <label for="field_of_study">Zaměření</label>
                                <select wire:model="field_of_study_id" name="field_of_study" id="field_of_study"
                                        class="block">
                                    <option value="all">Všechna zaměření</option>
                                    @foreach($field_of_studies as $fos)
                                        <option value="{{$fos->id}}">{{$fos->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        @if($field_of_study_id != "all")
                            <div>
                                <label for="region">Obor</label>
                                <select wire:model="prescribed_specialization_id" name="region" id="region"
                                        class="block">
                                    <option value="all">Všechny obory</option>
                                    @foreach($prescribed_specializations as $ps)
                                        <option value="{{$ps->id}}">{{$ps->code}} - {{$ps->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
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
            </div>
            <div class="flex justify-around mt-16">
                <div>
                    <button class="btn btn-primary" wire:click="clear_filter">Vyčistit filtr</button>
                    <button class="btn btn-primary" wire:click="show_filtered_schools">Filtrovat</button>
                </div>
            </div>
        </x-dashboard-card>
    </div>
</div>
