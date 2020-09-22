<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrace na výstavu
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
                            @foreach($upcoming_exhibitions as $ue)
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
                <div class="form-row-2">
                    <div>
                        <label for="morning_event_start" class="label">Začátek ranní akce</label>
                        <input id="morning_event_start" type="text" wire:model="morning_event_start"
                               class="input @error('morning_event') input-error @enderror">
                        @error('morning_event') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="morning_event_end" class="label">Konec ranní akce</label>
                        <input id="morning_event_end" type="text" wire:model="morning_event_end"
                               class="input @error('morning_event_end') input-error @enderror">
                        @error('morning_event_end') <span class="error">{{ $message }}</span> @enderror
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
                <div class="form-row-2">
                    <div>
                        <label for="evening_event_start" class="label">Začátek ranní akce</label>
                        <input id="evening_event_start" type="text" wire:model="evening_event_start"
                               class="input @error('evening_event') input-error @enderror">
                        @error('evening_event') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="evening_event_end" class="label">Konec ranní akce</label>
                        <input id="evening_event_end" type="text" wire:model="evening_event_end"
                               class="input @error('evening_event_end') input-error @enderror">
                        @error('evening_event_end') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <button type="submit" class="btn btn-primary">Vytvořit</button>
                </div>
            </form>
        </x-dashboard-card>
    </div>
</div>
