<div class="choice-container">
    <div class="choice-input">
        <input {!! $attributes->merge(['class' => $type === 'checkbox' ? 'form-checkbox' : 'form-radio'])->filter(fn ($value, $key) => $key !== 'type') !!}
               name="{{ $name }}"
               id="{{ $id }}"
               type="{{ $type }}"
               @if ($value) value="{{ $value }}" @endif
               @if ($checked && ! $attributes->whereStartsWith('wire:model')->first()) checked @endif
        />
    </div>

    @if (! $slot->isEmpty() || $label || $description)
        <div class="choice-label">
            <label for="{{ $id }}">
                @if ($label)
                    {{ $label }}
                @else
                    {{ $slot }}
                @endif
            </label>

            @if ($description)
                <p class="choice-description">{{ $description }}</p>
            @endif
        </div>
    @endif
</div>
