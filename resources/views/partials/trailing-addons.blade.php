@if ($trailingAddon)
    <div class="trailing-addon">
        <span>{!! $trailingAddon !!}</span>
    </div>
@elseif ($trailingIcon)
    <div class="trailing-icon">{!! $trailingIcon !!}</div>
@endif
