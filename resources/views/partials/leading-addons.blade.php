@if ($leadingAddon)
    <span class="leading-addon">{!! $leadingAddon !!}</span>
@elseif ($inlineAddon)
    <div class="inline-addon">
        <span>{!! $inlineAddon !!}</span>
    </div>
@elseif ($leadingIcon)
    <div class="leading-icon">{!! $leadingIcon !!}</div>
@endif
