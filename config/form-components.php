<?php

use Rawilk\FormComponents\Components;

return [
    /*
    |--------------------------------------------------------------------------
    | Component Defaults
    |--------------------------------------------------------------------------
    |
    | We've added some common options you may want to globally edit to avoid
    | having to change them everytime you call a component or having to
    | override a component definition.
    |
    */
    'defaults' => [
        // Global defaults will be applied to all components.
        'global' => [
            // Show error states by default.
            'show_errors' => true,

            // Set the fields to use by default for properties on options in select components.
            'value_field' => 'id',
            'label_field' => 'name',
            // Will default to label field if null - only applies to custom selects
            'selected_label_field' => null,
            'disabled_field' => 'disabled',
            'children_field' => 'children',
        ],

        // Input defaults will be applied to all input types (email, password, etc.).
        'input' => [
            // Supported: 'sm', 'md', 'lg'
            // Applies to all input types except for checkbox/radios.
            'size' => 'md',

            // Classes applied by default to input parent div.
            // Will also apply to select.
            'container_class' => null,

            // Base input classes applied by default.
            'input_class' => null,
        ],

        'password' => [
            // Show the password reveal button by default.
            'show_toggle' => true,

            // Icon shown when password is hidden.
            'show_icon' => 'heroicon-m-eye',

            // Icon shown when password is revealed.
            'hide_icon' => 'heroicon-m-eye-slash',
        ],

        'textarea' => [
            // How many rows should the textarea have by default.
            'rows' => 3,

            // Automatically resize the textarea based on content length.
            'auto_resize' => true,
        ],

        'select' => [
            // Automatically apply a CSS class to each select.
            'input_class' => null,
        ],

        // Defaults for checkbox/radios.
        'choice' => [
            // Automatically apply a CSS class to each checkbox/radio container.
            'container_class' => null,

            // Automatically apply a CSS class to each checkbox/radio input.
            'input_class' => null,

            // Supported: 'sm', 'md', 'lg' (defaults to 'sm')
            'size' => null,

            // Show the description inline with the label by default.
            'inline_description' => false,

            // Render the label on the left side of the checkbox/radio by default.
            'label_left' => false,
        ],

        // Defaults for the switch toggle component.
        'switch_toggle' => [
            // Apply a CSS class to the label that contains the switch toggle globally.
            'container_class' => null,

            // Apply a CSS class to the switch toggle (not the actual input element) globally.
            'input_class' => null,

            // Set the default size of the switch toggle.
            // Supported: 'sm', 'md', 'lg', (default is 'md')
            'size' => null,

            // Set the default color of the switch toggle. (e.g. "blue", "red", "green", etc.)
            'color' => null,

            // Set the default icon to show when the switch is in an "on" state.
            'on_icon' => null,

            // Set the default icon to show when the switch is in an "off" state.
            'off_icon' => null,
        ],

        // Defaults for the date picker component.
        'date_picker' => [
            // Allow date picker to open from clicking on the input by default.
            'click_opens' => false,

            // Allow user to modify the text of the input by default.
            'allow_input' => true,

            // Enable the time picker by default.
            'enable_time' => false,

            // Set the default date format. (defaults to y-m-d)
            'format' => null,

            // Set an icon to show on the date picker for an "open" button by default.
            // Set to null to hide it.
            'toggle_icon' => 'heroicon-m-calendar',

            // Allow date pickers to be cleared by a clear button by default.
            'clearable' => true,

            // Set an icon to show on the date picker's clear button by default.
            'clear_icon' => 'heroicon-m-x-mark',

            // Set the default placeholder text for the date picker.
            // For best results, use a translation key as it will be translated automatically by the component.
            'placeholder' => 'form-components::messages.date_picker_placeholder',
        ],

        // Defaults for custom and tree select.
        'custom_select' => [
            // Apply a CSS class by default to the root element of the custom select.
            // Note: this will also apply to tree-select as well.
            'container_class' => null,

            // Apply a CSS class by default to the custom select button.
            'input_class' => null,

            // Apply a CSS class by default to the custom select menu.
            'menu_class' => null,

            // Make custom selects searchable by default.
            'searchable' => true,

            // Make custom selects clearable by default.
            // Will not show the clear button if the select is not optional.
            'clearable' => true,

            // Make custom selects optional by default. When marked as optional, custom select
            // will allow you to clear out its value, unless it has a minimum amount of options
            // required in a multi-select.
            'optional' => false,

            // Set the default icon to use to show that an option is selected.
            // Set to null to disable it.
            'option_selected_icon' => 'heroicon-m-check',

            // Define the name of the icon to show on the custom select button by default.
            // Set to null to hide it.
            'button_icon' => 'heroicon-m-chevron-down',

            // Define the default clear icon that will show on the custom select button and
            // multi-select selected options. Set to null to hide it.
            'clear_icon' => 'heroicon-m-x-mark',

            // In a multi-select, this is the minimum amount of options that must be selected.
            // Set to null or 0 to disable it.
            'min_selected' => null,

            // In a multi-select, this is the maximum amount of options that can be selected.
            // Set to null to disable it.
            'max_selected' => null,
        ],

        // Defaults for the tree select.
        'tree_select' => [
            // Set the default icon to use to show that an option has children.
            // Icon will be rotated to indicate when the option is expanded.
            'has_child_icon' => 'heroicon-m-chevron-right',
        ],

        // Defaults for the timezone select.
        'timezone_select' => [
            // Use the custom select component by default for the timezone select.
            'use_custom_select' => true,
        ],

        // Defaults for the form groups.
        'form_group' => [
            // Apply a CSS class to the root form group element globally.
            'class' => null,

            // Apply a margin bottom by default to form groups (except for last child).
            'margin_bottom' => true,

            // Render a border on top of each form group by default.
            // Does not render on first of type form groups in a container.
            // This option only applies to inline form groups as well.
            'border' => true,

            // Make all form groups show the label inline with the input by default.
            'inline' => false,

            // Apply a CSS class to the form group label container globally.
            'label_container_class' => null,

            // Apply a CSS class to the form group content globally.
            'content_class' => null,
        ],

        // Defaults for the file upload component.
        'file_upload' => [
            // Display a file upload progress bar by default.
            // Only shows if a "wire:model" is present.
            'display_upload_progress' => true,

            // Use the native HTML5 progress bar by default.
            // Not recommended if you need consistent styling across browsers.
            'use_native_progress_bar' => false,

            // Globally apply a CSS class to each file upload container.
            'container_class' => null,

            // Globally apply a CSS class to each file upload input.
            'input_class' => null,
        ],

        // Defaults for the file pond component.
        'file_pond' => [
            // Allow drag and drop file uploads by default.
            'allow_drop' => true,

            // Limit multiple file uploads to a certain number of files by default.
            // Set to null to allow unlimited files.
            'max_files' => null,

            // Configure FilePond options by default.
            'options' => [],
        ],

        // Defaults for quill.
        'quill' => [
            // Automatically focus the editor on page load by default.
            'auto_focus' => false,
        ],

        // Defaults for form errors.
        'form_error' => [
            // Define which HTML tag to use for the error message by default.
            'tag' => 'p',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Component Aliases
    |--------------------------------------------------------------------------
    |
    | Here you may define aliases for components this package provides.
    | For example, instead of rendering an input with <x-form-components::inputs.input>,
    | you may register an alias of 'input' and render it with <x-input>
    | instead.
    |
    */
    'components' => [

        // Base
        'form' => Components\Form::class,
        'form-error' => Components\FormError::class,
        'form-group' => Components\FormGroup::class,
        'label' => Components\Label::class,

        // Choice
        'checkbox-group' => Components\Choice\CheckboxGroup::class,
        'checkbox' => Components\Choice\Checkbox::class,
        'radio' => Components\Choice\Radio::class,
        'switch-toggle' => Components\Choice\SwitchToggle::class,

        // Inputs
        'input' => Components\Inputs\Input::class,
        'email' => Components\Inputs\Email::class,
        'password' => Components\Inputs\Password::class,
        'select' => Components\Inputs\Select::class,
        'textarea' => Components\Inputs\Textarea::class,
        'date-picker' => Components\Inputs\DatePicker::class,
        'custom-select' => Components\Inputs\CustomSelect::class,
        'custom-select-option' => Components\Inputs\CustomSelectOption::class,
        'timezone-select' => Components\Inputs\TimezoneSelect::class,
        'tree-select' => Components\Inputs\TreeSelect::class,
        'tree-select-option' => Components\Inputs\TreeSelectOption::class,

        // Files
        'file-upload' => Components\Files\FileUpload::class,
        'file-pond' => Components\Files\FilePond::class,

        // Rich Text
        'quill' => Components\RichText\Quill::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Prefix
    |--------------------------------------------------------------------------
    |
    | This value will be a prefix for all component aliases under the
    | `components` key. This is useful if you want to avoid collisions
    | with components from other libraries.
    |
    | If you set it to "tw", for example, you can reference it like this:
    |
    | <x-tw-input />
    |
    */
    'prefix' => '',

    /*
    |--------------------------------------------------------------------------
    | Enable Timezone Select
    |--------------------------------------------------------------------------
    |
    | If you don't plan on using a timezone select in your app, you can disable
    | it here. This will prevent the use of app('fc-timezone'). You should also
    | remove the "timezone-select" from the registered components in the config
    | as well.
    |
    */
    'enable_timezone' => true,

    /*
    |--------------------------------------------------------------------------
    | Default Timezone Subset
    |--------------------------------------------------------------------------
    |
    | You may not always need the full list of timezones to choose from,
    | so you may define a subset of regions to pull from instead. Set
    | the value to `false` to use all regions.
    |
    | Example: [\Rawilk\FormComponents\Support\TimezoneRegionEnum::America->value]
    |
    */
    'timezone_subset' => false,

    /*
    |--------------------------------------------------------------------------
    | Global Optional Hint
    |--------------------------------------------------------------------------
    |
    | You may set a global "optional" hint text for all optional form inputs
    | when you set the `optional` attribute on `<x-form-group>` components
    | to `true`. Set to `null` to disable showing it. The default provided
    | by the package is a translation key which will be translated
    | automatically for you.
    |
    */
    'optional_hint_text' => 'form-components::messages.optional',

    /*
    |--------------------------------------------------------------------------
    | FormComponents Assets URL
    |--------------------------------------------------------------------------
    |
    | This value sets the path to the FormComponents JavaScript assets, for cases
    | where your app's domain root is not the correct path. By default,
    | FormComponents will load its JavaScript assets from the app's
    | "relative root".
    |
    | Examples: "/assets", "myapp.com/app",
    |
    */
    'asset_url' => null,
];
