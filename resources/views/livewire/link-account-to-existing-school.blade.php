<div>
    <x-own-header>
        Propojit s předvyplněnou školou
    </x-own-header>

    <div class="py-12">
        <x-dashboard-card>
            <form wire:submit.prevent="submit">
                <div class="form-row">
                    <div class="form-field">
                        <label for="selected_school_id" class="label">Vyberte školu</label>
                        <select name="school_id" id="school_id"
                                wire:model="school_id"
                                class="input @error('school_id') input-error @enderror">
                            <option selected value="all">Vyberte školu</option>
                            @foreach($unassociated_schools as $sch)
                                <option value="{{$sch->id}}">
                                    {{$sch->name}}
                                </option>
                            @endforeach
                        </select>
                        @error('school_id') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-field">
                        <label for="ico" class="label">IČ školy - vložte pro ověření</label>
                        <input id="ico" type="text" wire:model="ico"
                               class="input @error('ico') input-error @enderror">
                        @error('ico') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-row">
                    <button type="submit" class="btn btn-primary">Uložit</button>
                </div>
            </form>
        </x-dashboard-card>
    </div>
</div>
