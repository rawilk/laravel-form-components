<div class="relative flex items-start">
    <div class="flex items-center h-5">
        <input {!! $attributes->merge(['class' => 'form-radio']) !!}
               type="radio"
               value="{{ $value }}"
               @if ($checked)
                   checked
               @endif
        />
    </div>

    <div class="ml-3 text-sm leading-5">
        <label for="{{ $attributes->get('id', $name) }}" class="font-medium text-gray-700">
            @if ($label)
                {{ $label }}
            @else
                {{ $slot }}
            @endif
        </label>

        @if ($description)
            <p class="text-gray-500">{{ $description }}</p>
        @endif
    </div>
</div>
