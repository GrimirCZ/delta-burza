<div>
    <div class="hidden md:block">
        <x-own-header>
            Chat s {{$registration->school->name}}
        </x-own-header>
    </div>

    <div class="max-w-7xl mx-auto md:pt-5 pb-10 sm:px-6 lg:px-8 w-100">
        <div class="bg-white shadow-sm text-center p-5 mx-5">
            <div class="px-4 py-5 border-b border-gray-200 mb-4 sm:px-6 flex justify-between">
                <h3 class="text-2xl font-bold">Chat</h3>
                <div id="currently_responding_to">
                    @if($currently_responding_to > 0)
                        Právě odpovída {{$currently_responding_to}} lidem
                    @endif
                </div>
            </div>
            <div id="chat-user" class="flex flex-col gap-y-6 px-4 chat-window overflow-y-scroll">
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
                <input type="text" wire:model="message" placeholder="Zde napište svou zprávu" id="message"
                       class="h-full mb-4 md:mb-0 h-4 sm:h-12 text-xl py-2 px-4 bg-gray-200 outline-none">
                <button wire:click="send" id="sendBtn" class="btn btn-primary h-full">Odeslat</button>
            </div>
        </div>
    </div>
    @push('scripts')
        @once
        <script>
            const scroll_down = () => {
                const el = document.querySelector("#chat-user")
                el.scrollTop = el.scrollHeight
            }
            scroll_down()

            function render() {
            @this.call('render')
            }

            window.addEventListener('rendered', () => scroll_down())

            // send on enter
            document.querySelector("#message").addEventListener("keyup", e => {
                if (e.keyCode === 13 && !e.shiftKey) {
                    document.querySelector("#sendBtn").click()
                }
            })

            Echo.channel("active-chats.{{$registration->id}}").listen("ActiveChatsChanged", e => {
                if (e.count > 0) {
                    document.querySelector("#currently_responding_to").innerText = `Právě odpovída ${e.count} lidem`
                } else {
                    document.querySelector("#currently_responding_to").innerText = ""
                }
            })
        </script>
        @endonce
    @endpush
</div>
