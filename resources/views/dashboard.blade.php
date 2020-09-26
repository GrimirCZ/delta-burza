<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil
        </h2>
    </x-slot>

    <div class="sm:flex justify-between max-w-7xl mx-auto py-10 pb-0 px-2 sm:px-6 lg:px-8 w-100 items-center">
        <div class="inline-block">
            <div class="top text-gray-600">{{Auth::user()->school->district->name}}</div>
            <h1 class="font-light text-3xl text-gray-800">{{Auth::user()->school->name}}</h1>
        </div>
        <div class="inline-block">
            <img src="{{asset('storage/' . Auth::user()->school->logo())}}" class="h-8" alt="Logo {{Auth::user()->school->name}}">
        </div>
    </div>


    <div class="py-12">
        <x-dashboard-card>
            @if(Auth::user()->school_id == null)
                <div class="grid justify-around items-center h-72">
                    <a href="/skola/vytvorit" class="text-xl text-blue-600 underline">
                        Vložte informace o škole.
                    </a>
                </div>
            @else
                <x-school-admin-detail :school="Auth::user()->school"/>
            @endif
        </x-dashboard-card>
    </div>
</x-app-layout>
