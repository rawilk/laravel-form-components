@if ($trailingAddon ?? false)
    <span {{ $componentSlot($trailingAddon)->attributes->class('trailing-addon') }}>
        {!! $trailingAddon !!}
    </span>
@elseif ($trailingInlineAddon ?? false)
    <div {{ $componentSlot($trailingInlineAddon)->attributes->class('trailing-inline-addon') }}>
        {!! $trailingInlineAddon !!}
    </div>
@elseif ($trailingIcon ?? false)
    <div {{ $componentSlot($trailingIcon)->attributes->class('trailing-icon') }}>
        <span class="trailing-icon-container">
            @if (is_string($trailingIcon))
                <x-dynamic-component :component="$trailingIcon" />
            @else
                {!! $trailingIcon !!}
            @endif
        </span>
    </div>
@endif
{{ $after ?? '' }}
