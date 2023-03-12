{{ $before ?? '' }}
@if ($leadingAddon ?? false)
    <span {{ $componentSlot($leadingAddon)->attributes->class('leading-addon') }}>
        {!! $leadingAddon !!}
    </span>
@elseif ($inlineAddon ?? false)
    <div {{ $componentSlot($inlineAddon)->attributes->class('inline-addon') }}>
        {!! $inlineAddon !!}
    </div>
@elseif ($leadingIcon ?? false)
    <div {{ $componentSlot($leadingIcon)->attributes->class('leading-icon') }}>
        <span class="leading-icon-container">
            @if (is_string($leadingIcon))
                <x-dynamic-component :component="$leadingIcon" />
            @else
                {!! $leadingIcon !!}
            @endif
        </span>
    </div>
@endif
