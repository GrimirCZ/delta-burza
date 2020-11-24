<div>
    <x-own-header>
        Kontaktovat školu
    </x-own-header>


    <div class="py-4">
        <x-dashboard-card>
            <form wire:submit.prevent="submit">
                <div class="mt-6">
                    <label for="name" class="label">Jméno a přijmení</label>
                    <input id="name" type="text" wire:model="name"
                           class="input input-full @error('name') input-error @enderror">
                    @error('name') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-row-2">
                    <div class="form-field">
                        <label for="email" class="label">Email</label>
                        <input id="email" type="text" wire:model="email"
                               class="input @error('email') input-error @enderror">
                        @error('email') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-field">
                        <label for="phone" class="label">Telefon</label>
                        <input id="phone" type="text" wire:model="phone"
                               class="input @error('phone') input-error @enderror">
                        @error('phone') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="mt-6">
                    <label for="body" class="label">Napište nám Vaše dotazy a my Vám na ně odpovíme e-mailem.</label>
                    <textarea name="body" id="body" cols="30" rows="10" wire:model="body"
                              class="input input-full @error('body') input-error @enderror"></textarea>
                    @error('body') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="mt-6">
                    <button class="btn btn-primary" type="submit">Odeslat</button>
                </div>
            </form>
        </x-dashboard-card>
    </div>
</div>
