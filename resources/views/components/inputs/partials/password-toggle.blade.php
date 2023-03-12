<button
    x-on:click="show = ! show"
    x-bind:title="show ? '{{ __('form-components::messages.password_hide_toggle_title') }}' : '{{ __('form-components::messages.password_show_toggle_title') }}'"
    class="trailing-icon"
    x-cloak
    type="button"
>
    <span x-show="! show" class="trailing-icon-container">
        <x-dynamic-component :component="$showPasswordIcon" />
    </span>

    <span x-show="show" class="trailing-icon-container">
        <x-dynamic-component :component="$hidePasswordIcon" />
    </span>
</button>
