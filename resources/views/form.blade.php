<form method="{{ $spoofMethod ? 'POST' : $method }}" @if (! $spellcheck)spellcheck="false"@endif {!! $attributes !!}>
@unless(in_array($method, ['HEAD', 'GET', 'OPTIONS'], true))
    @csrf
@endunless

@if ($spoofMethod)
    @method($method)
@endif

    {!! $slot !!}
</form>
