<div>
    <x-own-header
        top="Registrace na výstavu"
        bottom="{{format_date($exhibition->date)}}">
        <b>{{$exhibition->city}}</b> {{$exhibition->name}}
    </x-own-header>

    <div class="py-12">
        <x-dashboard-card>
            <form wire:submit.prevent="submit">
                @if($exhibition->has_morning_event)
                    <div class="form-row">
                        <div>
                            <label for="morning_event" class="label">url odkaz na on-line
                                schůzku {{$exhibition->morning_event_start)}}-{{$exhibition->morning_event_end}} (Microsoft
                                Teams/Google Meets/...)</label>
                            <input id="morning_event" type="text" wire:model="morning_event"
                                   class="input input-full @error('morning_event') input-error @enderror">
                            @error('morning_event') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif

                @if($exhibition->has_evening_event)
                    <div class="form-row">
                        <div>
                            <label for="evening_event" class="label">url odkaz na on-line
                                schůzku {{$exhibition->evening_event_start}}-{{$exhibition->evening_event_end}}
                                (Microsoft
                                Teams/Google Meets/...)</label>
                            <input id="evening_event" type="text" wire:model="evening_event"
                                   class="input input-full @error('evening_event') input-error @enderror">
                            @error('evening_event') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif

                <div class="form-row">
                    <button type="submit" class="btn btn-primary">Upravit</button>
                </div>
            </form>
        </x-dashboard-card>
    </div>
</div>
