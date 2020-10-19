<div>
    <x-own-header>
        Chat s {{$registration->school->name}}
    </x-own-header>

    <div class="max-w-7xl mx-auto pt-5 pb-10 sm:px-6 lg:px-8 w-100">
        <div class="bg-white shadow-sm text-center p-5 mx-5">
            <div class="px-4 py-5 border-b border-gray-200 mb-4 sm:px-6 flex justify-between">
                <h3 class="text-2xl font-bold">Chat</h3>
            </div>
            <div class="flex flex-col gap-y-6 px-4 h-1/2 overflow-y-scroll">
                @foreach($messages as $message)
                    @if($message->sender->id == $school->id)
                        <div class="text-left">
                            {{$message->body}}
                            <div class="text-gray-500 text-base">Škola</div>
                        </div>
                    @else
                        <div class="w-full text-right text-lg">
                            {{$message->body}}
                            <div class="text-gray-500 text-base">Vy</div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="send mt-6">
                <input type="text" wire:model="message"
                       class="h-full mb-4 md:mb-0 h-4 sm:h-12 text-xl py-2 px-4 bg-gray-200 outline-none">
                <button wire:click="send" class="btn btn-primary h-full">Odeslat</button>
            </div>
        </div>
    </div>
    @push('scripts')
        @once
        <script>
            document.addEventListener('livewire:load', function () {
                // sorry just livewire fuckery
                const lw = @this;

                Echo.channel("chat.{{$school->id}}.{{$me->id}}").listen("NewMessage", () => {
                @this.call('render')
                })
            })
        </script>
        @endonce
    @endpush
</div>
