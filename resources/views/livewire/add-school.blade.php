<div>
    <x-own-header>
        Přidat školu
    </x-own-header>

    <div class="py-12">
        <x-dashboard-card>
            <div>
                <div>
                    <label for="selected_school_id" class="label">Vyberte školu</label>
                    <select name="selected_school_id" id="selected_school_id"
                            wire:model="selected_school_id"
                            class="input @error('selected_school_id') input-error @enderror">
                        @if(!isset($selected_school_id))
                            <option selected>Vyberte školu</option>
                        @endif
                        @foreach($schools as $sch)
                            <option value="{{$sch->id}}" @if($selected_school_id == $sch->id) selected @endif>
                                {{$sch->name}}
                            </option>
                        @endforeach
                    </select>
                    @error('selected_school_id') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="mt-6 text-right mt-20">
                <button wire:click="complete" class="btn bg-teal-400 text-white ml-4">Dokončit</button>
            </div>
        </x-dashboard-card>
    </div>

</div>
