{{-- You can change this template using File > Settings > Editor > File and Code Templates > Code > Laravel Ideal View --}}
<div>
    <x-own-header>
        Vyfiltrované školy
    </x-own-header>

    <div class="py-12">
        <x-dashboard-card>
            <h1>Školy</h1>
            <ul class="ml-4">
                @foreach($schools as $school)
                    <li class="list-disc">
                        <a href="{{url("/skola/$school->id")}}" class="link">{{$school->name}}</a>
                        <ul class="ml-4">
                            <li class="list-disc">{{$school->district->region->name}}</li>
                            @foreach($school->specializations as $sp)
                                <li class="list-disc">
                                    <a href="{{url("/obor/$sp->id")}}"
                                       class="link">
                                        {{$sp->prescribed_specialization->code}}
                                        - {{$sp->prescribed_specialization->name}}
                                        <br/>ŠVP: {{$sp->name}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
            <h1>Výstavy</h1>
            <ul class="ml-4">
                @foreach($exhibitions as $exhibition)
                    <li class="list-disc">
                        <a href="{{url("/vystava/$exhibition->id")}}" class="link">
                            {{format_date($exhibition->date)}} {{$exhibition->city}}
                            ({{$exhibition->name}}) -
                            @if($exhibition->school_count > 4)
                            @elseif($exhibition->school_count > 1)
                                {{$exhibition->school_count}} školy
                            @else
                                {{$exhibition->school_count}} škola
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
            <button wire:click="show_filter" class="btn btn-primary mt-6">Zpět k filtrování</button>
        </x-dashboard-card>
    </div>
</div>
