<div class="h-full">
    <x-own-header>
        Registrované školy
    </x-own-header>
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
            <div class="mt-10">
                <a href="/register" class="btn btn-primary">Přidejte se k vystavetelům</a>
            </div>
        </div>

        <div id="macyJS" class="mt-5">
            @foreach ($schools as $school)
                <a href="/skola/{{$school->id}}">
                <div class="p-5 bg-white shadow-sm box-border text-gray-900 text-center">
                    @if($school->logo())
                        <img src="{{$school->logo()}}" alt="{{$school->name . ' logo'}}" class="inline-block mb-5 list-schools-logo">
                    @endif

                    <div class="text-1xl font-black">
                        {{$school->name}}
                    </div>

                    <div class="leading-3 text-gray-400">
                        {!! $school->pipe_text() !!}
                    </div>
                </div>
                </a>
            @endforeach
        </div>
        <script>
            let macyInstance = Macy({
                container: '#macyJS',
                columns: 1,
                margin: {
                    x: 10,
                    y: 10
                },
                mobileFirst: true,
                breakAt: {
                    870: {
                        columns: 2
                    }
                }
            });
        </script>
    </div>
</div>
