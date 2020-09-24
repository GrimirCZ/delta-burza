<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Filtrovat školy
        </h2>
    </x-slot>

    <div class="py-12">
        <x-dashboard-card>
            <div class="grid grid-cols-1 sm:grid-cols-2">
                <div class="grid grid-cols-3 sm:grid-cols-6">
                    @foreach($regions as $region)
                        <input type="checkbox" wire:model="regions.{{ $label['id'] }}.checked" name="labels"
                               @if($task->labels->contains($label['id'])) checked @endif>
                        <span class="ml-2 text-sm">{{ $label['name'] }}</span>
                    @endforeach
                </div>
                <div></div>
            </div>
        </x-dashboard-card>
    </div>
</div>
