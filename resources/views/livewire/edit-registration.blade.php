<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrace na výstavu
        </h2>
    </x-slot>

    <div class="py-12">
        <x-dashboard-card>
            <form wire:submit.prevent="submit">
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
                    <button type="submit" class="btn btn-primary">Upravit</button>
                </div>
            </form>
        </x-dashboard-card>
    </div>
</div>
