<div>
    <x-own-header>
        @if(isset($edit))
            Upravit článek
        @else
            Vytvořit článek
        @endif
    </x-own-header>

    <div class="py-12">
        <x-dashboard-card>
            <form wire:submit.prevent="submit">
                <div class="form-row-2">
                    <div>
                        <label for="title" class="label">Nadpis</label>
                        <input id="title" type="text" wire:model="title"
                               class="input @error('title') input-error @enderror">
                        @error('title') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <x-rich-text-editor label="Text" field="content"/>
                </div>


                <div class="form-row">
                    <button type="submit" class="btn btn-primary">Uložit</button>
                </div>
            </form>
        </x-dashboard-card>
    </div>
</div>
