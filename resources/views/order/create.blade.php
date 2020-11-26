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
                        <label for="exhibition_id" class="label">Vyberte výstavu</label>
                        <select name="exhibition_id" id="exhibition_id"
                                wire:model="exhibition_id"
                                class="input @error('exhibition_id') input-error @enderror">
                            @if(!isset($exhibition_id))
                                <option selected></option>
                            @elseif(isset($selected_exhibition))
                                <option
                                    value="{{$selected_exhibition['id']}}">{{format_date($selected_exhibition['date'])}}
                                    - {{$selected_exhibition['city']}} ({{$selected_exhibition['name']}})

                                </option>
                            @endif
                            @foreach($exhibitions as $ue)
                                <option value="{{$ue->id}}">{{format_date($ue->date)}} - {{$ue->city}} ({{$ue->name}})
                                    @if($ue->organizer_id != 1)
                                        - Pořadatel: {{$ue->organizer->short_name}} (fakturační podmínky řeší
                                        organizátor
                                        výstavy)
                                        @if($ue->test_date != null)
                                            test
                                            připojení proběhne {{format_date($exhibition->test_date)}}
                                        @endif

                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('exhibition_id') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        <label for="morning_event" class="label">{{settings("morning_event_start")}}
                            - {{settings("morning_event_end")}} - Odkaz na Microsoft Teams/Google Meets/Zoom/...</label>
                        <input id="morning_event" type="text" wire:model="morning_event"
                               class="input input-full @error('morning_event') input-error @enderror">
                        @error('morning_event') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label for="evening_event" class="label">{{settings("evening_event_start")}}
                            - {{settings("evening_event_end")}} - Odkaz na Microsoft Teams/Google Meets/Zoom/...</label>
                        <input id="evening_event" type="text" wire:model="evening_event"
                               class="input input-full @error('evening_event') input-error @enderror">
                        @error('evening_event') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <button wire:click="back" class="btn btn-secondary">Zpět</button>
                    <button type="submit" class="btn btn-primary ml-5">Uložit</button>
                </div>
            </form>
        </x-dashboard-card>
    </div>
</div>
