<div @class([
    'tree-select__button',
    'form-input',
    'disabled' => $disabled,
])
     x-on:keydown.backspace="onBackspace"
     x-on:click="openMenu"
     role="button"
     aria-haspopup="listbox"
     x-bind:aria-expanded="JSON.stringify(open)"
     @if ($labelledby) aria-labelledby="{{ $labelledby }}" @endif
>
    {{-- value/search --}}
    <div @class([
        'cursor-text' => ! $disabled,
        'w-full table-cell align-middle relative',
    ])>
        <div @class(['inline-block w-full align-middle', 'mb-1' => $multiple])>
            {{-- value --}}
            @includeWhen($this->hasValue, 'form-components::livewire.tree-select.tree-select-value')

            @if (! $multiple && ! $this->hasValue)
                <span class="inline-block max-w-full truncate align-middle text-blue-gray-400" x-show="! open" wire:key="treeSelect{{ $name }}SinglePlaceholder">{{ $placeholder }}</span>
            @endif

            {{-- search --}}
            <div @class([
                'inline-block align-middle max-w-full outline-none pt-2',
                'px-1' => ! $this->hasValue,
            ])>
                @if ($searchable)
                    <input
                        x-model.debounce="search"
                        x-bind:placeholder="searchPlaceholder"
                        x-show="showSearchInput"
                        x-on:keydown.enter.stop="onEnter"
                        x-ref="search"
                        tabindex="-1"
                        class="focus:ring-0 focus:outline-none placeholder-blue-gray-400 h-full max-w-full w-auto align-top m-0 p-0 border-0 bg-transparent"
                        @if ($disabled) disabled @endif
                    />
                @endif
            </div>
        </div>
    </div>

    {{-- clear --}}
    @if ($this->hasValueAndCanClear)
        <div class="table-cell align-middle text-center w-[22px]">
            <button
                wire:click.stop="clearValue"
                type="button"
                tabindex="-1"
                class="custom-select-clear | flex items-center justify-center h-6 w-6 rounded-full text-blue-gray-400 transition-colors hover:bg-blue-gray-300 hover:text-blue-gray-500 focus:outline-blue-gray"
            >
                <span class="sr-only">{{ __('form-components::messages.custom_select_clear_button') }}</span>
                <x-dynamic-component :component="$clearIcon" class="h-4 w-4" />
            </button>
        </div>
    @endif

    {{-- arrows --}}
    <div @class([
        'table-cell align-middle text-center w-[20px]',
        'cursor-pointer' => ! $disabled,
    ])>
        @include('form-components::partials.select.arrows')
    </div>
</div>
