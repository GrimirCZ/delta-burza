<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <h1 class="text-4xl">{{ config('app.name', 'Laravel') }}</h1>
        </x-slot>

        <x-jet-validation-errors class="mb-4"/>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label value="{{ __('Email') }}"/>
                <x-jet-input class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                             autofocus/>
            </div>

            <div class="mt-4">
                <x-jet-label value="Heslo"/>
                <x-jet-input class="block mt-1 w-full" type="password" name="password" required
                             autocomplete="current-password"/>
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <input type="checkbox" class="form-checkbox" name="remember">
                    <span class="ml-2 text-sm text-gray-600">Pamatovat si mě</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                       href="{{ route('password.request') }}">
                        Zapomenuté heslo
                    </a>
                @endif

                <x-jet-button class="ml-4">
                    Přihlásit se
                </x-jet-button>
            </div>
            <div class="mt-8 flex justify-center">
                <a href="{{url("register")}}" class="text-gray-700">Ještě nemáte účet? <span class="text-blue-500 underline">Registrujte se zde!</span></a>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
