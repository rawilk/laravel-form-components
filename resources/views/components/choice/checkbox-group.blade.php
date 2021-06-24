<div {{ $attributes->class($stacked ? 'space-y-4' : 'form-checkbox-group grid gap-4 items-start') }}
     @unless ($stacked) style="--fc-checkbox-grid-cols: {{ $gridCols }};" @endunless
>
    {{ $slot }}
</div>
