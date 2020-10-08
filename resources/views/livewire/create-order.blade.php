<div>
    <x-own-header>
        Nová objednávka
    </x-own-header>

    <div class="py-12">
        <x-dashboard-card>
            <div>
                <table class="table-auto w-full table divide-y divide-gray-200">
                    <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Výstava
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Cena
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">

                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">

                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach($selected_exhibitions as $se)
                        <tr>
                            <td class="px-4 py-2">{{format_date($se['date'])}} - {{$se['city']}}
                                ({{$se['name']}})
                            </td>
                            <td class="px-4 py-2">
                                {{number_format(calc_price($school_id, $se['exhibition_id'], $loop->index), 0,",",".")}}
                                ,- Kč
                            </td>
                            <td class="px-4 py-2 text-center">
                                <button wire:click="edit({{$se['id']}})" class="link">Upravit</button>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <button wire:click="remove({{$se['id']}})" class="link">Odstranit</button>
                            </td>
                        </tr>
                    @endforeach

                    @if(count($selected_exhibitions) < 1)
                        <tr>
                            <td class="w-1/2"></td>
                            <td colspan="3" class="text-center pb-4">

                            </td>
                        </tr>
                    @endif
                    </tbody>
                    <tfoot class="">
                    <tr class="mt-5 border-double border-t-4 border-gray-200">
                        <td class="px-4 py-2">Celkem</td>
                        <td class="px-4 py-2">
                            {{number_format($price,0,",",".")}},- Kč
                        </td>
                        <td></td>
                        <td class="text-right">
                            <button wire:click="add" class="btn btn-primary mt-4 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" class="inline-block h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div class="align-middle inline-block">Přidat výstavu</div>
                            </button>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-6 text-right mt-20">
                <button wire:click="cancel" class="text-gray-400">Zrušit</button>
                <button id="complete" class="btn bg-teal-400 text-white ml-4">Dokončit</button>
            </div>
        </x-dashboard-card>
    </div>
    <script>
        const completeBtn = document.querySelector("#complete");

        completeBtn.addEventListener("click", () => {
            if (confirm("Chcete tuto objednávku odeslat?")) {
                console.log(window.Livewire)
                window.Livewire.emit('complete')
            }
        })
    </script>

</div>
