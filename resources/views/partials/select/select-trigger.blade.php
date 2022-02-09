<div @class([
    'custom-select__button',
    'tree-select__button' => $type === 'tree',
    'form-input',
    'input-error' => $hasErrorsAndShow($name),
    'disabled' => $disabled,
])
     x-on:keydown.backspace="onBackspace"
     x-on:click="openMenu"
     role="combobox"
     aria-owns="{{ \Illuminate\Support\Str::slug($name) }}_listbox"
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
            @include('form-components::partials.select.select-value')

            @if (! $multiple)
                <template x-if="! hasValue">
                    <span class="inline-block max-w-full truncate align-middle text-slate-400" x-show="! open" wire:key="customSelect{{ $name }}SinglePlaceholder">{{ $placeholder }}</span>
                </template>
            @endif

            {{-- search --}}
            <div @class([
                    'inline-block align-middle max-w-full outline-none pt-2',
                ])
                {{-- we need to capture the input event and stop it from bubbling up to prevent our value getting set to the search value --}}
                x-on:input.prevent.stop="() => {}"
            >
                @if ($searchable)
                    <input
                        @if ($hasLivewire()) wire:ignore.self @endif
                        x-model.debounce="search"
                        x-on:keydown.enter.prevent.stop="onEnter"
                        x-ref="search"
                        x-bind:placeholder="searchPlaceholder"
                        x-show="showSearchInput"
                        tabindex="-1"
                        class="focus:ring-0 focus:outline-none placeholder-slate-400 h-full max-w-full w-auto align-top m-0 p-0 border-0 bg-transparent"
                        @if ($disabled) disabled @endif
                    />
                @endif
            </div>
        </div>
    </div>

    {{-- clear --}}
    @if ($clearIcon)
        <template x-if="hasValueAndCanClear">
            <div class="table-cell align-middle text-center w-[22px]">
                <button
                    x-on:click.stop="clearValue"
                    type="button"
                    tabindex="-1"
                    class="custom-select-clear | flex items-center justify-center h-6 w-6 rounded-full text-slate-400 transition-colors hover:bg-slate-300 hover:text-slate-500 focus:outline-slate"
                >
                    <span class="sr-only">{{ __('form-components::messages.custom_select_clear_button') }}</span>
                    <x-dynamic-component :component="$clearIcon" class="h-4 w-4" />
                </button>
            </div>
        </template>
    @endif

    {{-- arrows --}}
    <div @class([
        'table-cell align-middle text-center w-[20px]',
        'cursor-pointer' => ! $disabled,
    ])>
        @include('form-components::partials.select.arrows')
    </div>
</div>
