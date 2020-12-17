<div class="choice-container">
    <div class="choice-input">
        <input {!! $attributes->merge(['class' => $type === 'checkbox' ? 'form-checkbox' : 'form-radio'])->filter(fn ($value, $key) => $key !== 'type') !!}
               @if ($name) name="{{ $name }}" @endif
               @if ($id) id="{{ $id }}" @endif
               type="{{ $type }}"
               @if ($value) value="{{ $value }}" @endif
               @if ($checked && ! $attributes->whereStartsWith('wire:model')->first()) checked @endif
        />
    </div>

    @if (! $slot->isEmpty() || $label || $description)
        <div class="choice-label">
            @if (! $slot->isEmpty() || $label)
                <label for="{{ $id }}">
                    @if ($label)
                        {{ $label }}
                    @else
                        {{ $slot }}
                    @endif
                </label>
            @endif

            @if ($description)
                <p class="choice-description">{{ $description }}</p>
            @endif
        </div>
    @endif
</div>
