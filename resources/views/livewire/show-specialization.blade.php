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

        @if($school->type_can_show_exam_results() && count($exam_results) > 0)
            @php
                $shown = false;
            @endphp
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-5 shadow-sm box-border mt-3">
                    <h2 class="text-2xl mb-3">
                        Výsledky státních maturit
                    </h2>
                    <div>
                        @foreach($subjects as $subject)
                            @php
                                $shown = true;
                            @endphp
                            <div class="flex justify-content-start">
                                <div class="relative pr-8 py-4">
                                    <div class="text-xl">
                                        {{$subject}} - Didaktický test
                                    </div>
                                    <livewire:tooltip title="Didaktický test" :content="$textDidaktak"/>
                                </div>
                            </div>
                            <div class="overflow-x-auto p-1 mb-6">
                                <table class="w-100 mb-4 overflow-x-auto">
                                    <tr>
                                        <th class="cell empty"></th>
                                        <th class="cell text-center relative px-6" colspan="2">
                                            Průměrný percentil
                                            <livewire:tooltip title="Průměrný percentil" :content="$textPercentil"/>
                                        </th>
                                        <th class="cell text-center relative px-6" colspan="2">
                                            Medián
                                            <livewire:tooltip title="Medián" :content="$textMedian"/>
                                        </th>
                                        <th class="cell text-center relative px-6" colspan="2">
                                            Celková úspěšnost %
                                            <livewire:tooltip title="Celková úspěšnost %"
                                                              :content="$textUspesnost"/>
                                        </th>
                                        <th class="cell text-center relative px-6" colspan="2">
                                            Nekonalo 1. termín %
                                            <livewire:tooltip title="Nekonalo 1. termín %"
                                                              :content="$textNeuspesnost"/>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="cell empty"></th>
                                        <th class="cell text-center relative px-6">
                                            lepší <br/> než...
                                            <livewire:tooltip title="Lepší než..." :content="$textLepsiNez"/>
                                        </th>
                                        <th class="cell">škola</th>
                                        <th class="cell text-center relative px-6">
                                            lepší <br/> než...
                                            <livewire:tooltip title="Lepší než..." :content="$textMedian"/>
                                        </th>
                                        <th class="cell">škola</th>
                                        <th class="cell text-center relative px-6">
                                            lepší <br/> než...
                                            <livewire:tooltip title="Lepší než..." :content="$textMedian"/>
                                        </th>
                                        <th class="cell">škola</th>
                                        <th class="cell text-center relative px-6">
                                            lepší <br/> než...
                                            <livewire:tooltip title="Lepší než..." :content="$textMedian"/>
                                        </th>
                                        <th class="cell">škola</th>
                                    </tr>
                                    @foreach($years_to_display as $year)
                                        @php
                                            $exam = $exam_results->first(fn($exam)=>$exam->subject === $subject && $exam->year == $year);
                                        @endphp
                                        @if($exam != null)
                                            <tr>
                                                <td class="cell">{{$year}}</td>
                                                <td class="cell">{{$fmt($exam->cze_percentil)}}%</td>
                                                <td class="cell">{{$fmt($exam->percentil)}}</td>
                                                <td class="cell">{{$fmt($exam->cze_median)}}%</td>
                                                <td class="cell">{{$fmt($exam->median)}}</td>
                                                <td class="cell">{{$fmt($exam->cze_uspesnost)}}%</td>
                                                <td class="cell">{{$fmtPrc($exam->uspelo / $exam->prihlaseno)}}%</td>
                                                <td class="cell">{{$fmt($exam->cze_nepripusteno)}}%</td>
                                                <td class="cell">{{$fmtPrc($exam->omluveno / $exam->prihlaseno)}}%</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td class="cell">{{$year}}</td>
                                                <td class="cell">-</td>
                                                <td class="cell">-</td>
                                                <td class="cell">-</td>
                                                <td class="cell">-</td>
                                                <td class="cell">-</td>
                                                <td class="cell">-</td>
                                                <td class="cell">-</td>
                                                <td class="cell">-</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </table>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-sm">Podrobnější výsledky dostupné z <a target="_blank"
                                                                            href="https://vysledky.cermat.cz/data/Default.aspx"
                                                                            class="link">vysledky.cermat.cz</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
