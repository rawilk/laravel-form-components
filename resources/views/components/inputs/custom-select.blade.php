<div x-data="customSelect({
        open: false,
        @if ($attributes->whereStartsWith('wire:model')->first())
            value: @entangle($attributes->wire('model')),
        @else
            value: {{ $selectedKeyToJS() }},
        @endif
        selected: '',
        optional: {{ $optional ? 'true' : 'false' }},
        multiple: {{ $multiple ? 'true' : 'false' }},
        filterable: {{ $filterable ? 'true' : 'false' }},
        @if ($hasWireFilter = $attributes->whereStartsWith('wire:filter')->first())
            wireFilter: @entangle($attributes->wire('filter')),
        @endif
        placeholder: '{{ $placeholder }}',
        selectId: '{{ \Illuminate\Support\Str::random(8) }}',
     })"
     x-init="init($watch)"
     wire:ignore.self
     class="custom-select-container form-text-container {{ $maxWidth }}"
>
    @include('form-components::partials.leading-addons')

    <div class="relative flex-1" {{ $attributes->except(['labelledby'])->whereDoesntStartWith('wire:') }}>
        {{-- trigger --}}
        <span class="inline-block w-full rounded-md shadow-sm z-1">
            <button x-on:click="toggle()"
                    x-on:keydown.arrow-up.stop.prevent="toggle()"
                    x-on:keydown.arrow-down.stop.prevent="toggle()"
                    x-on:keydown.tab.prevent="toggle()"
                    x-bind:aria-expanded="JSON.stringify(open)"
                    x-ref="button"
                    x-cloak
                    type="button"
                    aria-haspopup="listbox"
                    class="{{ $buttonClass() }}"
                    @if (isset($attributes['labelledby']))
                        aria-labelledby="{{ $attributes->get('labelledby') }}"
                    @endif
                    @if ($disabled)
                        disabled
                    @endif
            >
                <span class="custom-select--display space-x-2" x-html="display"></span>
                @if ($optional && $clearIcon)
                    <button x-on:click="clear()"
                            x-show.transition.opacity.150ms="hasValue"
                            type="button"
                            class="absolute top-2 right-8 flex justify-center items-center h-6 w-6 rounded-full text-cool-gray-500 transition duration-150 ease-in-out hover:bg-cool-gray-300 focus:outline-black"
                    >
                        <span class="sr-only">{{ __('Clear selected') }}</span>
                        <x-dynamic-component :component="$clearIcon" class="h-4 w-4" />
                    </button>
                @endif
                <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                        <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </button>
        </span>

        {{-- options --}}
        <div x-show="open"
             x-cloak
             x-ref="container"
             x-on:click.away="open = false"
             x-on:keydown.escape.window="open = false"
             x-on:keydown.arrow-up.prevent="onArrowUp()"
             x-on:keydown.arrow-down.prevent="onArrowDown()"
             x-on:keydown.enter.stop.prevent="onOptionSelect()"
             x-on:keydown.home.stop.prevent="onHome()"
             x-on:keydown.end.stop.prevent="onEnd()"
             x-transition:enter="transition ease-in duration-100"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="custom-select--menu-container focus-within:shadow-outline-blue"
        >
            {{-- filter --}}
            @if ($filterable)
                <div class="custom-select--filter">
                    <input x-on:keydown.tab.prevent="focusMenu()"
                           x-on:keydown.shift.tab.prevent="closeMenu()"
                           x-ref="filter"
                           @unless ($hasWireFilter)
                               x-model.debounce.300ms="query"
                           @else
                                wire:model{{ $attributes->wire('filter')->modifiers()->count() ? '.' : '' }}{{ $attributes->wire('filter')->modifiers()->implode('.') }}="{{ $attributes->wire('filter')->value() }}"
                           @endunless
                           type="search"
                           class="form-input form-text"
                           wire:loading.class="busy"
                           placeholder="{{ __('Search...') }}"
                    />

                    @if ($hasWireFilter)
                        <span class="absolute top-5 -mt-0.5 right-6 animate-spin hidden" wire:loading.class.remove="hidden">
                            <x-heroicon-o-refresh class="h-5 w-5 text-cool-gray-400" />
                        </span>
                    @endif
                </div>
            @endif

            <ul x-ref="menu"
                x-on:keydown.space.stop.prevent="onOptionSelect()"
                x-on:keydown.tab.prevent="closeMenu()"
                x-on:keydown.shift.tab.prevent="onShiftTab()"
                x-bind:aria-activedescendant="activeDescendant"
                role="listbox"
                tabindex="-1"
                class="custom-select--menu"
                @if ($multiple)
                    aria-multiselectable="true"
                @endif
            >
                {{ $slot }}

                @foreach ($options as $option)
                    <x-custom-select-option :option="$option" :value-key="$valueKey" :text-key="$textKey" />
                @endforeach

                {{ $append ?? '' }}
            </ul>
        </div>
    </div>
</div>

@once
<script>
    function customSelect(state) {
        const findLastIndex = (array, predicate) => {
            let l = array.length;
            while (l--) {
                if (predicate(array[l], l, array)) {
                    return l;
                }
            }

            return -1;
        };

        return {
            ...state,

            display: '',
            options: [],
            currentIndex: -1,
            query: '',

            get activeDescendant() {
                return this.currentIndex > -1
                    ? `listbox-${this.selectId}-item-${this.currentIndex}`
                    : null;
            },

            get hasValue() {
                return this.multiple
                    ? this.value.length > 0
                    : Boolean(this.value);
            },

            get enabledLength() {
                return this.options.filter(o => ! o.disabled && ! o.hidden).length;
            },

            get placeholderMarkup() {
                return `<span class="custom-select--placeholder">${this.placeholder}</span>`;
            },

            init($watch) {
                this.options = this.parseOptions();

                if (this.value && this.multiple && ! Array.isArray(this.value)) {
                    this.value = [this.value];
                }

                this.updateDisplay(this.value);

                $watch('value', value => this.updateDisplay(value));
                $watch('query', value => this.filter(value));
                $watch('wireFilter', () => {
                    this.$nextTick(() => {
                        this.options = this.parseOptions();
                    });
                });

                $watch('selected', value => this.onSelectedChanged(value));
            },

            filter(value) {
                const optionsToHide = this.options
                    .filter(o => {
                        o.hidden = false;

                        return ! String(o.value).toLowerCase().includes(value) && ! String(o.text).toLowerCase().includes(value);
                    })
                    .map(o => {
                        o.hidden = true;

                        return this.optionIndex(o.value);
                    });

                if (! optionsToHide.length) {
                    Array.from(this.$refs.menu.children).forEach(child => child.classList.remove('hidden'));

                    return;
                }

                Array.from(this.$refs.menu.children)
                    .forEach(child => {
                        const index = Number(child.dataset.index);

                        if (optionsToHide.includes(index)) {
                            child.classList.add('hidden');
                        } else {
                            child.classList.remove('hidden');
                        }
                    });
            },

            parseOptions() {
                return Array.from(this.$refs.menu.children)
                    .filter(child => child.classList.contains('custom-select--option'))
                    .map((child, index) => {
                        child.setAttribute('data-index', index);
                        child.setAttribute('id', `listbox-${this.selectId}-item-${index}`);

                        return JSON.parse(child.dataset.option)
                    });
            },

            isChosen(value) {
                if (this.multiple) {
                    if (! Array.isArray(this.value)) {
                        this.value = [this.value];
                    }

                    return this.value.includes(value);
                }

                return value === this.value;
            },

            chooseForMultiple(value) {
                if (! this.isChosen(value)) {
                    this.value.push(value);
                } else if (this.optional || this.value.length > 1) {
                    this.value.splice(this.value.indexOf(value), 1);
                    this.updateDisplay(this.value);
                }

                if (this.value.length === 0) {
                    this.closeMenu();
                }
            },

            clear() {
                this.value = this.multiple ? [] : null;
            },

            choose(value) {
                if (this.multiple) {
                    return this.chooseForMultiple(value);
                }

                this.value = (this.optional && this.value === value)
                    ? null
                    : value;

                this.closeMenu();
            },

            closeMenu() {
                this.open = false;
                this.focusButton();
            },

            onOptionSelect() {
                if (this.currentIndex < 0) {
                    return;
                }

                const option = this.options[this.currentIndex];

                if (option && ! option.disabled) {
                    this.choose(option.value);
                }
            },

            // Excludes any "optgroup" elements
            optionChildren() {
                return Array.from(this.$refs.menu.children)
                    .filter(child => child.classList.contains('custom-select--option'));
            },

            updateDisplay(value) {
                if (! value) {
                    return this.display = this.placeholderMarkup;
                }

                if (this.multiple) {
                    return this.updateDisplayForMultiple(value);
                }

                const $li = this.optionChildren()[this.optionIndex(value)];
                this.display = $li
                    ? $li.children[0].innerHTML
                    : this.placeholderMarkup;
            },

            updateDisplayForMultiple(value) {
                const length = value.length;
                if (length === 0) {
                    return this.display = this.placeholderMarkup;
                }

                const $li = this.optionChildren()[this.optionIndex(value[0])];

                if (! $li) {
                    return this.display = `${length} Selected`;
                }

                let display = $li.children[0].innerHTML;
                if ((length - 1) > 0) {
                    display += `<span class="text-xs text-cool-gray-500">+ ${length - 1}</span>`;
                }

                this.display = display;
            },

            optionIndex(value) {
                return this.options.findIndex(o => o.value === value);
            },

            onMouseEnter(value) {
                this.selected = value;
                this.currentIndex = this.optionIndex(value);
            },

            onSelectedChanged(value) {
                if (! this.open) {
                    return;
                }

                const index = this.optionIndex(value);

                if (index < 0) {
                    return;
                }

                this.$nextTick(() => {
                    const $li = this.optionChildren()[index];

                    if (! $li) {
                        return;
                    }

                    const filterHasFocus = this.filterable
                        && document.activeElement === this.$refs.filter;

                    $li.focus();

                    if (filterHasFocus) {
                        this.focusFilter();
                    }
                });
            },

            onArrowUp() {
                // If no enabled options, just return...
                if (this.enabledLength === 0) {
                    this.currentIndex = -1;
                    this.selected = null;

                    return;
                }

                let prevIndex = findLastIndex(this.options, (o, index) => ! o.disabled && ! o.hidden && index < this.currentIndex);
                if (prevIndex < 0) {
                    prevIndex = findLastIndex(this.options, o => ! o.disabled && ! o.hidden);
                }

                this.currentIndex = prevIndex;
                this.selected = this.options[this.currentIndex].value;
            },

            onArrowDown() {
                // If no enabled options, just return...
                if (this.enabledLength === 0) {
                    this.currentIndex = -1;
                    this.selected = null;

                    return;
                }

                let nextIndex = this.options.findIndex((o, index) => index > this.currentIndex && ! o.disabled && ! o.hidden);
                if (nextIndex === -1 || (nextIndex + 1) > this.options.length) {
                    nextIndex = this.options.findIndex(o => ! o.disabled && ! o.hidden);
                }

                this.currentIndex = nextIndex;
                this.selected = this.options[this.currentIndex].value;
            },

            onHome() {
                // If no enabled options, just return...
                if (this.enabledLength === 0) {
                    this.currentIndex = -1;
                    this.selected = null;

                    return;
                }

                this.currentIndex = this.options.findIndex(o => ! o.disabled && ! o.hidden);
                this.selected = this.options[this.currentIndex].value;
            },

            onEnd() {
                // If no enabled options, just return...
                if (this.enabledLength === 0) {
                    this.currentIndex = -1;
                    this.selected = null;

                    return;
                }

                this.currentIndex = findLastIndex(this.options, o => ! o.disabled && ! o.hidden);
                this.selected = this.options[this.currentIndex].value;
            },

            focusButton() {
                this.$nextTick(() => this.$refs.button.focus());
            },

            focusFilter() {
                this.$nextTick(() => this.$refs.filter.focus());
            },

            focusMenu() {
                this.$nextTick(() => this.$refs.menu.focus());
            },

            onShiftTab() {
                if (this.filterable) {
                    this.focusFilter();
                } else {
                    this.closeMenu();
                }
            },

            highlightSelectedOption() {
                if (this.multiple) {
                    this.currentIndex = this.optionIndex(this.value[0]);
                } else {
                    this.currentIndex = this.value
                        ? this.optionIndex(this.value)
                        : 0;
                }

                // Let's focus the first option if none of them are selected.
                if (this.currentIndex < 0 && this.enabledLength > 0) {
                    this.currentIndex = 0;
                }

                this.selected = this.currentIndex > -1
                    ? this.options[this.currentIndex].value
                    : null;
            },

            toggle() {
                this.open = ! this.open;

                if (this.open) {
                    this.$nextTick(() => this.positionMenu());
                    this.highlightSelectedOption();
                    this[this.filterable ? 'focusFilter' : 'focusMenu']();
                }
            },

            positionMenu() {
                this.$refs.container.classList.remove('custom-menu-top');

                // give a little bit of breathing room at the bottom of the screen.
                const tolerance = 10;
                const menuHeight = this.$refs.menu.offsetHeight;
                const largestHeight = window.innerHeight - menuHeight - tolerance;

                const { top } = this.$refs.menu.getBoundingClientRect();

                if (top > largestHeight) {
                    this.$refs.container.classList.add('custom-menu-top');
                }
            },
        };
    }
</script>
@endonce
