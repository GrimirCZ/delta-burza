<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Vytvořit školu
        </h2>
    </x-slot>

    <div class="py-12">
        <x-dashboard-card>
            <form wire:submit.prevent="submit">
                <div class="form-row-2">
                    <div class="form-field">
                        <label for="name" class="label">Název školy</label>
                        <input id="name" type="text" wire:model="name"
                               class="input @error('name') input-error @enderror">
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-field">
                        <label for="address" class="label">Ulice a č.p.</label>
                        <input id="address" type="text" wire:model="address"
                               class="input @error('address') input-error @enderror">
                        @error('address') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-row-2">
                    <div class="form-field">
                        <label for="psc" class="label">PSČ</label>
                        <input id="psc" type="text" wire:model="psc" class="input @error('psc') input-error @enderror">
                        @error('psc') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-field">
                        <label for="city" class="label">Město</label>
                        <input id="city" type="text" wire:model="city"
                               class="input @error('city') input-error @enderror">
                        @error('city') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-row-2">
                    <div class="form-field">
                        <label for="ico" class="label">IČ</label>
                        <input id="ico" type="text" wire:model="ico" class="input @error('ico') input-error @enderror">
                        @error('ico') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-field">
                        <label for="izo" class="label">IZO</label>
                        <input id="izo" type="text" wire:model="izo" class="input @error('izo') input-error @enderror">
                        @error('izo') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-row-2">
                    <div class="form-field">
                        <label for="email" class="label">Emailová adresa</label>
                        <input id="email" type="text" wire:model="email"
                               class="input @error('email') input-error @enderror">
                        @error('email') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-field">
                        <label for="web" class="label">Adresa webu</label>
                        <input id="web" type="text" wire:model="web" class="input @error('web') input-error @enderror">
                        @error('web') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-row-2">
                    <div>
                        <label for="phone" class="label">Telefon</label>
                        <input id="phone" type="text" wire:model="phone"
                               class="input @error('phone') input-error @enderror">
                        @error('phone') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="district_id" class="label">Okres</label>
                        <select name="district" id="district_id" wire:model="district_id"
                                class="input @error('address') input-error @enderror">
                            <option value="" selected></option>
                            @foreach($districts as $district)
                                <option value="{{$district->id}}">{{$district->name}}</option>
                            @endforeach
                        </select>
                        @error('district_id') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-row-2">
                    <div>
                        <label for="logo" class="label">Logo</label>
                        <input type="file" wire:model="logo" id="logo" class="input" onchange="checkFileSizeLogo(this)">
                        @error('logo') <span class="error" id="logo-error-laravel">{{ $message }}</span> @enderror

                        <div class="error" id="logo-error" wire:ignore="always"></div>

                        <script>
                            function checkFileSizeLogo(el) {
                                if(el.files.length > 0) {
                                    const size = Math.round(el.files[0].size /1024/1024 * 100) / 100;

                                    if(size > 1) {
                                        document.getElementById('logo-error').innerHTML = "maximální povolená velikost souboru je 1MB. (velikost vašeho souboru: "+size+"MB)"
                                        return false;
                                    }
                                }

                                document.getElementById('logo-error').innerHTML = "";
                                return true;
                            }
                        </script>
                    </div>
                    <div>
                        <label for="brojure" class="label">Brožura</label>
                        <input type="file" wire:model="brojure" id="brojure" class="input" onchange="checkFileSizeBrojure(this)">
                        @error('brojure') <span class="error">{{ $message }}</span> @enderror

                        <div class="error" id="brojure-error" wire:ignore="always"></div>

                        <script>
                            function checkFileSizeBrojure(el) {
                                if(el.files.length > 0) {
                                    const size = Math.round(el.files[0].size /1024/1024 * 100) / 100;

                                    if(size > 5) {
                                        document.getElementById('brojure-error').innerHTML = "maximální povolená velikost souboru je 5MB. (velikost vašeho souboru: "+size+"MB)"
                                        return false;
                                    }
                                }

                                document.getElementById('brojure-error').innerHTML = "";
                                return true;
                            }
                        </script>
                    </div>
                </div>

                <div class="form-row">
                    <x-rich-text-editor label="Text o škole" field="description"/>
                </div>


                <div class="form-row">
                    <button type="submit" class="btn btn-primary">Uložit</button>
                </div>
            </form>
        </x-dashboard-card>
    </div>
</div>
