<div>
    <header class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 w-100 pt-8 mx-3">
        <div class="top text-gray-600">
            {{$specialization->prescribed_specialization->code}} {{$specialization->prescribed_specialization->name}}
        </div>
        <h1 class="font-light text-gray-800 text-2xl md:text-3xl">
            {{$specialization->name}}
        </h1>
        <div class="bottom">
            <a href='/skola/{{$specialization->school->id}}' class="link">{{$specialization->school->district->name}}
                - {{$specialization->school->name}}</a>
        </div>
    </header>


    <div class="mt-10 mx-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-5 shadow-sm box-border mt-3">
                <div class="pb-6 px-4 w-100 default-css overflow-x-auto">
                    {!! $specialization->description !!}
                </div>
            </div>
        </div>

        @if(count($exam_results) > 0)
            @php
                $shown = false;
            @endphp
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-5 shadow-sm box-border mt-3">
                    <h2 class="text-2xl mb-3">
                        Výsledky maturit
                    </h2>
                    <div>
                        @foreach($subjects as $subject)
                            @php
                                $shown = true;
                            @endphp
                            <h3 class="text-xl mb-3">
                                {{$subject}}
                            </h3>
                            <div class="overflow-x-auto p-1">
                                <table class="w-100 mb-4 overflow-x-auto">
                                    <tr>
                                        <th class="cell empty"></th>
                                        <th class="cell" colspan="2">Průměrný percentil</th>
                                        <th class="cell" colspan="2">Medián</th>
                                        <th class="cell" colspan="2">% čistá úspěšnost</th>
                                        <th class="cell" colspan="2">% nekonali 1. termín</th>
                                    </tr>
                                    <tr>
                                        <th class="cell"></th>
                                        <th class="cell">škola</th>
                                        <th class="cell">ČR</th>
                                        <th class="cell">škola</th>
                                        <th class="cell">ČR</th>
                                        <th class="cell">škola</th>
                                        <th class="cell">ČR</th>
                                        <th class="cell">škola</th>
                                        <th class="cell">ČR</th>
                                    </tr>
                                    @foreach($exam_results->filter(fn($exam)=>$exam->subject === $subject) as $exam)
                                        <tr>
                                            <td class="cell">{{$exam->year}}</td>
                                            <td class="cell">{{$fmt($exam->percentil)}}</td>
                                            <td class="cell">{{$fmt($exam->cze_percentil)}}</td>
                                            <td class="cell">{{$fmt($exam->median)}}</td>
                                            <td class="cell">{{$fmt($exam->cze_median)}}</td>
                                            <td class="cell">{{$fmtPrc($exam->uspelo / $exam->prihlaseno)}}</td>
                                            <td class="cell">{{$fmt($exam->cze_konalo)}}</td>
                                            <td class="cell">{{$fmtPrc($exam->omluveno / $exam->prihlaseno)}}</td>
                                            <td class="cell">{{$fmt($exam->cze_nekonalo)}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-sm">Podrobnější výsledky dostupné z <a target="_blank"
                                                                            href="https://vysledky.cermat.cz/data/Default.aspx"
                                                                            class="link">vysledky.cermat.cz</a></div>
                </div>
            </div>
        @endif
    </div>
</div>
