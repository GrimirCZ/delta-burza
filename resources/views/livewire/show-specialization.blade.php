<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$specialization->name}}
            <br/>
            <span
                class="text-gray-500 text-base">{{$specialization->prescribed_specialization->code}} {{$specialization->prescribed_specialization->name}}</span>
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 w-100">
            {!! $specialization->description !!}
        </div>
    </div>
</div>
