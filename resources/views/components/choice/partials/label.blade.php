@if ($label || $description || ! $slot->isEmpty())
    <div @class([
        'choice-label',
        'choice-label--left' => $labelLeft,
    ])>
        @if ($label || ! $slot->isEmpty())
            <label
                @if ($id) for="{{ $id }}" @endif
                @if ($isDisabled()) data-disabled="true" @endif
            >
                {{ $label ?? $slot }}
            </label>
        @endif

        @if ($description)
            @if ($inlineDescription)
                <span class="choice-description">
                    @if ($label || ! $slot->isEmpty())
                        <span class="sr-only">{{ $label ?? $slot }}</span>
                    @endif
                    {{ $description }}
                </span>
            @else
                <p class="choice-description" @if ($id) id="{{ $id }}-description" @endif>{{ $description }}</p>
            @endif
        @endif
    </div>
@endif
