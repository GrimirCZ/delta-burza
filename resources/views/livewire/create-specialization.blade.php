<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Přidat obor
        </h2>
    </x-slot>

    <div class="py-12">
        <x-dashboard-card>
            <form wire:submit.prevent="submit">
                <div class="form-row-2">
                    <div>
                        <label for="prescribed_specialization_id" class="label">Obor</label>
                        <select name="prescribed_specialization" id="prescribed_specialization_id" wire:model="prescribed_specialization_id"
                                class="input @error('prescribed_specialization_id') input-error @enderror">
                            <option value="" selected></option>
                            @foreach($prescribed_specializations as $ps)
                                <option value="{{$ps->id}}">{{$ps->code}} - {{$ps->name}}</option>
                            @endforeach
                        </select>
                        @error('prescribed_specialization_id') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="name" class="label">Název ŠVP</label>
                        <input id="name" type="text" wire:model="name" class="input @error('name') input-error @enderror">
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <label for="description">Popis oboru (je možné využít html značek k formátování)</label>
                    <textarea name="description" id="description" cols="30" rows="10" wire:model="description" class="input @error('address') input-error @enderror"></textarea>
                    @error('description') <span class="error">{{ $message }}</span> @enderror
                </div>


                <div class="form-row">
                    <button type="submit" class="btn btn-primary">Vytvořit</button>
                </div>
            </form>
        </x-dashboard-card>
    </div>
</div>
