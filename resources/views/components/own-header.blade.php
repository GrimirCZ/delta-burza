<header class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 w-100 pt-8">
    <div class="top text-gray-600">@if(isset($top)){{$top}}@endif</div>
    <h1 class="font-light text-3xl text-gray-800">@if(isset($slot)){{$slot}}@endif</h1>
    <div class="bottom">@if(isset($bottom)){{$bottom}}@endif</div>
</header>