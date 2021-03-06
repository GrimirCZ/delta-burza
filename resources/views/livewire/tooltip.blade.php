<div class="absolute right-1.5 top36">
    <span class="cursor-pointer select-none text-gray-500 text-xl"
         wire:click="$emitSelf('showTooltip')"
    ><img src="{{url("images/questionmark.png")}}" alt="question mark">
    </span>
    @if($show)
        <div class="fixed z-20 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-black opacity-75"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                    role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                    {{$title}}
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 font-normal">
                                        {!! $content !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" class="btn btn-primary" wire:click="$emitSelf('closeTooltip')">
                            Zavřít
                        </button>
                    </div>
                </div>
            </div>
        </div>

    @endif
</div>
