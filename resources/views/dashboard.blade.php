<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil
        </h2>
    </x-slot>

    <div class="py-12">
        <x-dashboard-card>
            @if(Auth::user()->school_id == null)
                <div class="grid justify-around items-center h-72">
                    <a href="/skola/vytvorit" class="text-xl text-blue-600 underline">
                        Zatím jste nevytvořili žádnou školu. Chcete ji vytvořit nyní?
                    </a>
                </div>
            @else
                <x-school-admin-detail :school="Auth::user()->school"/>
            @endif
        </x-dashboard-card>
    </div>
</x-app-layout>
