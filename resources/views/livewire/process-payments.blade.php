<div>
    <x-own-header>
        Fitlrovat školy
    </x-own-header>

    <div class="pb-12 pt-3 mx-3">

        <x-dashboard-card>
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div>
                    <h2 class="subheader">Nahrát soubor s platbami</h2>
                    <div>
                        <label for="payments" class="block">Platby</label>
                        <input type="file" name="payments" id="payments" wire:model="platby">
                        @error("platby") <span class="error">{{$message}}</span> @enderror
                    </div>
                    <div class="mt-6">
                        <button wire:click="submit" class="btn btn-primary"
                                @if($platby == null) disabled @endif>
                            Odeslat
                        </button>
                    </div>
                </div>
                <div>
                    <h2 class="subheader">Výsledky</h2>
                    <table>
                        <tr>
                            <td></td>
                        </tr>
                    </table>
                    <div class="mt-6">
                        <button wire:click="download_results" class="btn btn-primary"
                                @if($output != true) disabled @endif>
                            Stáhnout výsledky
                        </button>
                    </div>
                </div>
            </div>
        </x-dashboard-card>

    </div>
</div>
