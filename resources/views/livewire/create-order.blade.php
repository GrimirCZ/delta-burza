<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nová objednávka
        </h2>
    </x-slot>

    <div class="py-12">
        <x-dashboard-card>
            <div>
                <table>
                    <tr>
                        <th>Výstava</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($selected_exhibitions as $se)
                        <tr>
                            <td>{{$se->exhibition_name}}</td>
                            <td>
                                <button wire:click="edit({{$se->id}})">Upravit</button>
                            </td>
                            <td>
                                <button wire:click="remove({{$se->id}})">Odstranit</button>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <button wire:click="$set('state', 'NEW')" class="link">Přidat výstavu</button>
            </div>

            <button wire:click="complete" class="link mt-6">Dokončit</button>
        </x-dashboard-card>
    </div>

</div>
