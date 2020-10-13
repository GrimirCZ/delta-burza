<div>
    <x-own-header>
        Přihlásit se jako
    </x-own-header>

    <div class="py-12">
        <x-dashboard-card>
            <div class="form-row">
                <div>
                    <label for="exhibitioner" class="label">Vystavovatel</label>
                    <select id="exhibitioner" type="text" wire:model="user_id"
                            class="input input-full @error('user_id') input-error @enderror">
                        @foreach($schools as $school)
                            <option value="{{$school->user_id}}">{{$school->name}}</option>
                        @endforeach
                    </select>
                    @error('user_id') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <button class="btn btn-primary">Přihlásit</button>
            </div>
        </x-dashboard-card>
    </div>
</div>
