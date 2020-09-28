<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <h1 class="text-4xl">{{ config('app.name', 'Laravel') }}</h1>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            Zapomenuli jste heslo? Nevadí. Napište nám prosím vaší emailovou adresu a my vám zašleme odkaz na změnu hesla.
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-jet-label value="Email" />
                <x-jet-input class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    Odkaz na resetování hesla
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
