<div class="choice-container relative flex items-start">
    <div class="choice-input flex items-center h-5">
        <input {!! $attributes->merge(['class' => $type === 'checkbox' ? 'form-checkbox h-4 w-4 text-blue-600 border-blue-gray-300 rounded focus:ring-blue-500' : 'form-radio h-4 w-4 text-blue-600 border-blue-gray-300 focus:ring-blue-500'])->filter(fn ($value, $key) => $key !== 'type') !!}
               @if ($name) name="{{ $name }}" @endif
               @if ($id) id="{{ $id }}" @endif
               type="{{ $type }}"
               @if ($value) value="{{ $value }}" @endif
               @if ($checked && ! $attributes->whereStartsWith('wire:model')->first()) checked @endif
               {{ $extraAttributes }}
        />
    </div>

    @if (! $slot->isEmpty() || $label || $description)
        <div class="choice-label ml-3 text-sm leading-5">
            @if (! $slot->isEmpty() || $label)
                <label for="{{ $id }}" class="font-medium text-blue-gray-700">
                    @if ($label)
                        {{ $label }}
                    @else
                        {{ $slot }}
                    @endif
                </label>
            @endif

            @if ($description)
                <p class="choice-description text-blue-gray-500">{{ $description }}</p>
            @endif
        </div>
    @endif
</div>
