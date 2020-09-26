<div>
    <x-own-header
        top="{{$specialization->prescribed_specialization->code}} {{$specialization->prescribed_specialization->name}}">
        {{$specialization->name}}
    </x-own-header>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 w-100">
            {!! $specialization->description !!}
        </div>
    </div>
</div>
