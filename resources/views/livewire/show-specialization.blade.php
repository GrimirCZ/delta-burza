<div>
    <x-slot name="header">
        <div class="flex justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight block">
                    {{$specialization->name}}
                    <br/>
                    <span
                        class="text-gray-500 text-base">{{$specialization->prescribed_specialization->code}} {{$specialization->prescribed_specialization->name}}</span>
                </h2>
            </div>
            <div class="flex items-center">
                @if(Auth::check() && Auth::user()->school != null && Auth::user()->school->id == $specialization->school->id)
                    <a href="/obor/{{$specialization->id}}/upravit" class="btn btn-primary block">Upravit</a>
                @endif
            </div>
        </div>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 w-100">
            {!! $specialization->description !!}
        </div>
    </div>
</div>
