{{-- You can change this template using File > Settings > Editor > File and Code Templates > Code > Laravel Ideal View --}}
<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Výběr výstavy
        </h2>
    </x-slot>

    <div class="py-12">
        <x-dashboard-card>
            <form wire:submit.prevent="submit">
                <div>
                    <div>
                        <label for="exhibition_id" class="label">Výstavy</label>
                        <select name="exhibition_id" id="exhibition_id"
                                wire:model="exhibition_id"
                                class="input @error('exhibition_id') input-error @enderror">
                            <option selected></option>
                            @foreach($exhibitions as $ue)
                                <option value="{{$ue->id}}">{{$ue->city}} ({{$ue->name}})</option>
                            @endforeach
                        </select>
                        @error('exhibition_id') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        <label for="morning_event" class="label">Ranní akce url</label>
                        <input id="morning_event" type="text" wire:model="morning_event"
                               class="input input-full @error('morning_event') input-error @enderror">
                        @error('morning_event') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label for="evening_event" class="label">Ranní akce url</label>
                        <input id="evening_event" type="text" wire:model="evening_event"
                               class="input input-full @error('evening_event') input-error @enderror">
                        @error('evening_event') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <button type="submit" class="btn btn-primary">Vytvořit</button>
                </div>
            </form>
        </x-dashboard-card>
    </div>
</div>
