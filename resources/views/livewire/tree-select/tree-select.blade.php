<div class="relative">
    <div x-data="treeSelect({ _wire: $wire, value: @entangle('value'), search: @entangle('search').defer, ...{{ $this->configToJs() }} })"
         x-on:keydown.escape.window.prevent="closeMenu"
         x-on:click.outside="closeMenu({ focusRoot: false })"
         x-on:tree-select-{{ Str::slug($name) }}-value-changed.window="onValueChanged"
         x-on:keydown.arrow-down.prevent="focusNextOption"
         x-on:keydown.arrow-up.prevent="focusPreviousOption"
         x-on:keydown.home.prevent="focusFirstOption"
         x-on:keydown.end.prevent="focusLastOption"
         x-on:keydown.arrow-right="onArrowRight"
         x-on:keydown.arrow-left="onArrowLeft"
         x-on:keydown.enter.stop="onEnter"
         x-on:keydown.tab="onTab"
         class="relative rounded-md focus:outline-none"
         x-bind:class="{ 'focus:border-blue-300 focus:ring-opacity-50 focus:ring-4 focus:ring-blue-400': ! open }"
         tabindex="0"
         wire:ignore.self
         data-name="{{ $name }}"
    >
        {{-- menu --}}
        <div x-ref="menu"
             x-cloak
             tabindex="-1"
             x-bind:aria-hidden="JSON.stringify(! open)"
             x-bind:class="{ 'invisible': ! open }"
             class="tree-select-menu z-top"
             wire:ignore.self
        >
            <div class="tree-select-menu__container | max-h-[260px] overflow-auto rounded-md">
                <ul x-ref="listbox"
                    role="listbox"
                    tabindex="-1"
                    @if ($multiple)
                        aria-multiselectable="true"
                    @endif
                    x-bind:aria-activedescendant="focusedOptionIndex > -1 ? `treeSelectOption-${ariaActiveDescendant}` : null"
                    wire:loading.delay.class="hidden"
                    wire:target="handleSearch"
                >
                    @forelse ($options as $option)
                        @include('form-components::livewire.tree-select.tree-select-option', ['level' => 0])
                        @php($this->incrementCurrentOptionIndex())
                    @empty
                        @include('form-components::partials.select.no-options')
                    @endforelse
                </ul>

                @include('form-components::livewire.tree-select.tree-select-loader')
            </div>
        </div>

        @include('form-components::livewire.tree-select.tree-select-trigger')
    </div>

    @if ($multiple)
        @foreach ($value as $singleValue)
            <input type="hidden" name="{{ $name }}[]" value="{{ $singleValue }}">
        @endforeach
    @else
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
    @endif
</div>
