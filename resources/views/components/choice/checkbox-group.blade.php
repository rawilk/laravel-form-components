<div {{ $attributes->class($classes()) }}
     @unless ($stacked) style="--fc-checkbox-grid-cols: {{ $gridCols }};" @endunless
>
    {{ $slot }}
</div>
