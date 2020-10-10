<div>
    <x-own-header>
        Administrace
    </x-own-header>

    <div class="max-w-7xl mx-auto">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mx-5 mt-10">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Články
                    <a href="{{url("/admin/clanek/vytvorit")}}" class="text-header ml-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" class="inline h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="inline-block align-middle">Přidat článek</span>
                    </a>
                </h3>
            </div>
            <div>
                @if(count($articles) > 0)
                    <table class="table-fixed min-w-full text-gray-500">
                        <tbody>
                        @foreach($articles as $article)
                            <tr class="{{$loop->index %2 == 0 ? "bg-gray-100" : ""}}">
                                <td class="px-8 py-5">
                                    <a href="/clanek/{{$article->id}}" class="link">
                                        {{$article->title}}
                                    </a>
                                </td>
                                <td class="px-8 py-5">{{substr(strip_tags($article->content), 0, 50)."..."}}</td>
                                <td class="px-8 py-5 text-right">
                                    @if($article->show)
                                        <button class="ml-6 text-header" wire:click="hideArticle({{$article->id}})">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor" class="inline h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                            </svg>
                                            <span class="inline-block align-middle">Skrýt</span>
                                        </button>
                                    @else
                                        <button class="ml-6 text-header" wire:click="showArticle({{$article->id}})">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor" class="inline h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            <span class="inline-block align-middle">Zobrazit</span>
                                        </button>
                                    @endif

                                    <a href="/admin/clanek/{{$article->id}}/upravit" class="text-header ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor" class="inline h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                        <span class="inline-block align-middle">Upravit</span>
                                    </a>

                                    <button class="ml-6 delete-btn" data-article-id="{{$article->id}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor" class="inline h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <span class="inline-block align-middle">Smazat</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="px-8 py-5 text-gray-500">
                        Zatím nebyly přídány žádné články
                    </div>
                @endif
            </div>
        </div>
    </div>
    @push("scripts")
        @once
        <script>
            document.addEventListener('livewire:load', function () {
                const lw = @this;

                const deleteBtns = document.querySelectorAll(".delete-btn");

                for (let deleteBtn of deleteBtns) {
                    deleteBtn.addEventListener("click", () => {
                        if (confirm("Chcete tento článek smazat??")) {
                            lw.call('deleteArticle', deleteBtn.dataset.articleId)
                        }
                    })
                }
            });
        </script>
        @endonce
    @endpush
</div>
