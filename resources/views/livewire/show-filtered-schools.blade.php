{{-- You can change this template using File > Settings > Editor > File and Code Templates > Code > Laravel Ideal View --}}
<div>
    <x-own-header>
        Vyfiltrované školy
    </x-own-header>

    <div class="py-12">
        <x-dashboard-card>
            <ul class="ml-4">
                @foreach($schools as $school)
                    <li class="list-disc">
                        {{$school->name}}
                        <ul class="ml-4">
                            <li class="list-disc">{{$school->district->region->name}}</li>
                            @foreach($school->specializations as $sp)
                                <li class="list-disc">{{$sp->prescribed_specialization->code}} - {{$sp->prescribed_specialization->name}}
                                    <br/>ŠVP: {{$sp->name}}</li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </x-dashboard-card>
    </div>
</div>
