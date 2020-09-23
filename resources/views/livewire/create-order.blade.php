<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nová objednávka
        </h2>
    </x-slot>

    <div class="py-12">
        <x-dashboard-card>
            <div>
                @if(count($selected_exhibitions) > 0)
                    <table class="table-auto w-full">
                        <tr>
                            <th class="px-4 py-2">Výstava</th>
                            <th class="px-4 py-2"></th>
                            <th class="px-4 py-2"></th>
                        </tr>
                        @foreach($selected_exhibitions as $se)
                            <tr>
                                <td class="border px-4 py-2">{{format_date($se['date'])}} - {{$se['city']}}
                                    ({{$se['name']}})
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    <button wire:click="edit({{$se['id']}})" class="link">Upravit</button>
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    <button wire:click="remove({{$se['id']}})" class="link">Odstranit</button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
                <button wire:click="add" class="link mt-4">Přidat výstavu</button>
            </div>

            <div class="flex mt-6">
                <button wire:click="cancel" class="link">Zrušit</button>
                <button wire:click="complete" class="link ml-4">Dokončit</button>
            </div>
        </x-dashboard-card>
    </div>

</div>
