<div>
    <x-own-header>
        {{$article->title}}
    </x-own-header>
    <div class="py-12">
        <x-dashboard-card>
            <div class="default-css">
                {!! $article->content !!}
            </div>
        </x-dashboard-card>
    </div>
</div>
