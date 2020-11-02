<header class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 w-100 pt-8 @if(isset($class)){{$class}}@endif">
    <div class="top text-gray-600">@if(isset($top)){{$top}}@endif</div>
    <h1 class="font-light text-gray-800 text-2xl md:text-3xl">@if(isset($slot)){{$slot}}@endif</h1>
    <div class="bottom">@if(isset($bottom)){{$bottom}}@endif</div>
</header>
