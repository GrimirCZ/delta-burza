<div>
    @if(count($articles) > 0)
        <div class="max-w-7xl mx-auto pt-5 pb-10 sm:px-6 lg:px-8 w-100">
            <div class="bg-white shadow-sm text-center p-5 mx-5 mb-4">
                <div class="px-4 py-5 border-b border-gray-200 mb-4 sm:px-6 flex justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Novinky
                    </h3>
                </div>
                <div class="grid md:grid-cols-2 gap-6">
                    @foreach($articles as $article)
                        <div>
                            <a href="/clanek/{{$article->id}}">
                                @if(isset($article->cover_image))
                                    <img src="{{$article->cover_image}}" alt="{{$article->title}}">
                                @endif
                                <div class="exhibitions-card p-5 bg-white shadow-md box-border text-gray-900 text-left">
                                    <h3 class="text-2xl font-light text-left">{{$article->title}}</h3>
                                    <span
                                        class="text-gray-600 text-black text-sm">{{format_date($article->date)}}</span>
                                    <p>{!! html_cut($article->content, 50)."..." !!}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if(count($upcoming_exhibitions) > 0)
        <div class="max-w-7xl mx-auto pt-5 pb-10 sm:px-6 lg:px-8 w-100">
            <div class="bg-white shadow-sm text-center p-5 mx-5">
                <div class="px-4 py-5 border-b border-gray-200 mb-4 sm:px-6 flex justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Nadcházející výstavy
                    </h3>
                </div>
                <div>
                    <div class="grid md:grid-cols-2 gap-3">
                        @foreach($upcoming_exhibitions as $ue)
                            <a href="/vystava/{{$ue->id}}">
                                <div class="exhibitions-card p-5 bg-white shadow-md box-border text-gray-900">
                                    <div
                                        class="date">{{$ue->district->region->name}} {{format_date($ue->date)}}</div>
                                    <h3 class="text-2xl font-light"><span
                                            class="font-black">{{$ue->city}}</span> {{$ue->name}}</h3>
                                    @if($ue->organizer_id != 1)
                                        <span class="italic">Pořadatel: {{$exhibition->organizer->short_name}}</span>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="text-center pt-12 pb-3">
                        <a href="{{url("/vystavy")}}" class="link text-lg">Všechny výstavy</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto pt-5 pb-10 sm:px-6 lg:px-8 w-100">
        <div class="bg-white shadow-sm text-center p-5 mx-5">
            <div class="md:divide-x divide-gray-200">
                <div class="inline-block py-5 px-10">
                    <div class="font-black text-3xl text-header">{{$schoolsCount}}</div>
                    <div>zapojených škol</div>
                </div>
                <div class="inline-block py-5 px-10">
                    <div class="font-black text-3xl text-header">{{$companiesCount}}</div>
                    <div>zapojených firem</div>
                </div>
                <div class="inline-block py-5 px-10">
                    <div class="font-black text-3xl text-header">{{$exibitionsCount}}</div>
                    <div>výstav</div>
                </div>
            </div>
        </div>
    </div>
</div>
