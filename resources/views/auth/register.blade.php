<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <h1 class="text-4xl">{{ config('app.name', 'Laravel') }}</h1>
        </x-slot>

        <x-jet-validation-errors class="mb-4"/>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label value="Jméno"/>
                <x-jet-input class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus
                             autocomplete="name"/>
            </div>

            <div class="mt-4">
                <x-jet-label value="Email"/>
                <x-jet-input class="block mt-1 w-full" type="email" name="email" :value="old('email')" required/>
            </div>

            <div class="mt-4">
                <x-jet-label value="Heslo"/>
                <x-jet-input class="block mt-1 w-full" type="password" name="password" required
                             autocomplete="new-password"/>
            </div>

            <div class="mt-4">
                <x-jet-label value="Potvrdit heslo"/>
                <x-jet-input class="block mt-1 w-full" type="password" name="password_confirmation" required
                             autocomplete="new-password"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    Jste již zaregistrováni?
                </a>

                <x-jet-button class="ml-4">
                    Registrovat
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
