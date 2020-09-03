<form method="{{ $spoofMethod ? 'POST' : $method }}"
      @if ($action)
          action="{{ $action }}"
      @endif

     @if ($hasFiles)
         enctype="multipart/form-data"
     @endif

    @if (! $spellcheck)
        spellcheck="false"
    @endif

     {{ $attributes }}
>
    @unless (in_array($method, ['HEAD', 'GET', 'OPTIONS'], true))
        @csrf
    @endunless

    @if ($spoofMethod)
        @method($method)
    @endif

    {{ $slot }}
</form>
