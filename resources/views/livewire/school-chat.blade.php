<div>
    <x-own-header>
        Chat k výstavě {{$registration->exhibition->name}}
    </x-own-header>

    <div class="max-w-7xl mx-auto pt-5 pb-10 sm:px-6 lg:px-8 w-100">
        <div class="bg-white shadow-sm text-center p-5 mx-5">
            <div class="px-4 py-5 border-b border-gray-200 mb-4 sm:px-6 flex justify-between">
                <div
                    class="region-input bg-gray-200 border border-gray-200 text-gray-700 p-1 max-w-16 rounded inline-block text-gray-700">
                    <div class="relative inline-block">
                        <select
                            class="block appearance-none py-3 pr-8 pl-2 leading-tight bg-transparent outline-none max-w-200px"
                            wire:model="selected_messenger_id" name="type" id="type"
                        >
                            <option value="">Vyberte chat</option>
                            @foreach($messengers as $messenger)
                                <option value="{{$messenger->id}}">Chat č.{{$loop->iteration}}</option>
                            @endforeach
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20">
                                <path
                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            @if($selected_messenger_id != null && $selected_messenger_id != '')
                <div class="flex flex-col chat-window gap-y-6 px-4 overflow-y-scroll">
                    @foreach($messages as $message)
                        @if($message->sender->id == $selected_messenger_id)
                            <div class="text-left">
                                {{$message->body}}
                                <div class="text-gray-500 text-base">Zájemce</div>
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
            @endif
        </div>
    </div>
    @push('scripts')
        @once
        <script>
            const selected_messenger_id = "{{$selected_messenger_id}}";

            document.addEventListener('livewire:load', function () {
                Echo.private("new_messenger.{{$me->id}}").listen("NewMessenger", e => {
                    if (e && e.new_messenger_id !== undefined && e.new_messenger_id !== null) {
                        Echo.channel(`chat.${e.new_messenger_id}.{{$me->id}}`).listen("NewMessage", e => {
                            if (e.sender_id != selected_messenger_id) {
                                notyf.open({
                                    type: 'info',
                                    message: '<h1>Nová zpráva</h1>Přišla vám nová zpráva.<br/>Kliknutím zobrazíte.'
                                }).on("click", () => @this.set("selected_messenger_id", e.sender_id))
                            }

                        @this.call('render')
                        })

                        notyf.open({
                            type: 'info',
                            message: '<h1>Nový chat</h1>Připojil se nový zájemce. <br/>Kliknutím přejdete na chat.'
                        }).on("click", () => @this.set("selected_messenger_id", e.new_messenger_id))
                    }

                @this.call('render')
                })
            })
        </script>
        @endonce

        <script>
            document.addEventListener('livewire:load', function () {
                @foreach($messengers as $messenger)
                Echo.channel("chat.{{$messenger->id}}.{{$me->id}}").listen("NewMessage", e => {
                    console.log(e, selected_messenger_id)
                    if (e.sender_id != selected_messenger_id) {
                        notyf.open({
                            type: 'info',
                            message: '<h1>Nová zpráva</h1>Přišla vám nová zpráva.<br/>Kliknutím zobrazíte.'
                        }).on("click", () => @this.set("selected_messenger_id", e.sender_id))
                    }

                @this.call('render')
                })
                @endforeach
            })
        </script>
    @endpush
</div>
