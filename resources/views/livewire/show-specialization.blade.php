<?php

?>

<div>
    <header class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 w-100 pt-8 mx-3">
        <div class="top text-gray-600">
            {{$specialization->prescribed_specialization->code}} {{$specialization->prescribed_specialization->name}}
        </div>
        @if($school->is_registered())
            <h1 class="font-light text-gray-800 text-2xl md:text-3xl">
                {{$specialization->name}}
            </h1>
        @endif
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

        @if($school->type_can_show_exam_results() && $spec_group != null && count($exam_results) > 0)
            @php
                $shown = false;
            @endphp
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-5 shadow-sm box-border mt-3">
                    <div class="flex justify-content-start mmb-3">
                        <div class="relative pr-8 py-4 pb-0">
                            <div class="text-2xl">
                                Výsledky státních maturit za skupinu oborů {{$spec_group->code}}
                                - {{$spec_group->name}}
                            </div>
                            <div class="livewire-tooltip-in-title">
                                <livewire:tooltip
                                    :title='"Výsledky státních maturit za skupinu oborů $spec_group->code - $spec_group->name"'
                                    :content="$textSimiliarObory"/>
                            </div>
                        </div>
                    </div>
                    <div>
                        @foreach($subjects as $subject)
                            @php
                                $shown = true;
                            @endphp
                            <div class="flex justify-content-start">
                                <div class="relative pr-8 py-4 pb-0">
                                    <div class="text-xl">
                                        {{$subject}} - Didaktický test
                                    </div>
                                    <div class="livewire-tooltip-in-title">
                                        <livewire:tooltip title="Didaktický test" :content="$textDidaktak"/>
                                    </div>
                                </div>
                            </div>
                            <p class="pb-6 display-none text-gray-500 max-w-3xl">Tučně uvedené hodnoty ukazují kolik %
                                škol v ČR v dané skupině oborů dosáhlo horšího výsledku (nebo stejného) než daná škola.
                                Výsledek v závorce je absolutní hodnota školy v daném kritériu.</p>
                            <div class="overflow-x-auto p-1 mb-6">
                                <table class="w-100 mb-4 overflow-x-auto">
                                    <tr>
                                        <th class="cell empty"></th>
                                        <th class="cell th-background text-center relative px-6 fw" colspan="2">
                                            Medián
                                            <div class="livewire-tooltip">
                                                <livewire:tooltip title="Medián" :content="$textMedian"/>
                                            </div>
                                        </th>
                                        <th class="cell th-background text-center relative px-6 fw" colspan="2">
                                            Průměrný percentil
                                            <div class="livewire-tooltip">
                                                <livewire:tooltip title="Průměrný percentil" :content="$textPercentil"/>
                                            </div>
                                        </th>
                                        <th class="cell th-background text-center relative px-6 fw" colspan="2">
                                            Celková úspěšnost
                                            <div class="livewire-tooltip">
                                                <livewire:tooltip title="Celková úspěšnost"
                                                                  :content="$textUspesnost"/>
                                            </div>
                                        </th>
                                        <th class="cell th-background text-center relative px-6 fw" colspan="2">
                                            Nekonalo 1. termín
                                            <div class="livewire-tooltip">
                                                <livewire:tooltip title="Nekonalo 1. termín"
                                                                  :content="$textNeuspesnost"/>
                                            </div>
                                        </th>
                                    </tr>
                                    @foreach($years_to_display as $year)
                                        @php
                                            $exam = $exam_results->first(fn($exam)=>$exam->subject === $subject && $exam->year == $year);
                                        @endphp
                                        @if($exam != null)
                                            <tr>
                                                <td class="cell">{{$year}}</td>
                                                <td class="cell" colspan="2">
                                                    <b>{{$fmt($exam->cze_median)}}%</b>
                                                    ({{$fmt($exam->median)}})
                                                </td>
                                                <td class="cell" colspan="2">
                                                    <b>{{$fmt($exam->cze_percentil)}}%</b>
                                                    ({{$fmt($exam->percentil)}})
                                                </td>
                                                <td class="cell" colspan="2">
                                                    <b>{{$fmt($exam->cze_uspesnost)}}%</b>
                                                    ({{$fmtPrc($exam->uspelo / $exam->prihlaseno)}}%)
                                                </td>
                                                <td class="cell" colspan="2">
                                                    <b>{{$fmt($exam->cze_nepripusteno)}}%</b>
                                                    ({{$fmtPrc($exam->omluveno / $exam->prihlaseno)}}%)
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td class="cell">{{$year}}</td>
                                                <td class="cell" colspan="2">-</td>
                                                <td class="cell" colspan="2">-</td>
                                                <td class="cell" colspan="2">-</td>
                                                <td class="cell" colspan="2">-</td>
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
