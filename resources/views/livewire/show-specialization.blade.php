<div>
    <header class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 w-100 pt-8 mx-3">
        <div class="top text-gray-600">
            {{$specialization->prescribed_specialization->code}} {{$specialization->prescribed_specialization->name}}
        </div>
        <h1 class="font-light text-gray-800 text-2xl md:text-3xl">
            {{$specialization->name}}
        </h1>
        <div class="bottom">
            <a href='/skola/{{$specialization->school->id}}' class="link">{{$specialization->school->district->name}} - {{$specialization->school->name}}</a>
        </div>
    </header>


    <div class="mt-10 mx-3">
        <x-dashboard-card>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 w-100 default-css">
                {!! $specialization->description !!}
            </div>
        </x-dashboard-card>
    </div>
</div>
