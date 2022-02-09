@if ($hasLabel($slot))
<label @if ($for) for="{{ $for }}" @endif {{ $attributes->class('form-label block text-sm font-medium leading-5 text-slate-700') }}
       @if ($customSelectLabel)
           x-data
           x-on:click="document.querySelector('[data-name={{ \Illuminate\Support\Str::slug($for) }}]').focus()"
       @endif
>
    @if ($slot->isEmpty())
        {{ $fallback }}
    @else
        {{ $slot }}
    @endif
</label>
@endif
