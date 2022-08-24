<?php

use Rawilk\FormComponents\Components;

return [
    /*
    |--------------------------------------------------------------------------
    | Components
    |--------------------------------------------------------------------------
    |
    | Below is a reference of all the blade components that should be loaded
    | into your app by this package. The components shown here are just to
    | add shortcuts for accessing them instead of using <x-form-components::component-name>
    | syntax. You can disable or overwrite any component class or alias you want.
    |
    | Note: Any components listed here that have an array for the config value
    | shouldn't be renamed or removed from the config if you use them since
    | the underlying component will reference the config values in the
    | component's array. Also, if you rely on `fcStyles` and/or `fcScripts`
    | for using component assets via cdn, you shouldn't remove the component's
    | from here either.
    |
    */
    'components' => [

        // Base
        'form' => Components\Form::class,
        'form-error' => Components\FormError::class,
        'form-group' => Components\FormGroup::class,
        'label' => Components\Label::class,

        // Choice
        'checkbox' => Components\Choice\Checkbox::class,
        'checkbox-group' => Components\Choice\CheckboxGroup::class,
        'radio' => Components\Choice\Radio::class,
        'switch-toggle' => Components\Choice\SwitchToggle::class,

        // Files
        'file-pond' => Components\Files\FilePond::class,
        'file-upload' => Components\Files\FileUpload::class,

        // Inputs
        'custom-select' => [
            'class' => Components\Inputs\CustomSelect::class,

            /*
             * This icon will be shown when an option is selected
             * and the "optional" attribute is set to true.
             */
            'clear_icon' => 'heroicon-o-x-mark',
        ],
        'custom-select-option' => Components\Inputs\CustomSelectOption::class,
        'date-picker' => [
            'class' => Components\Inputs\DatePicker::class,

            /*
             * This icon will be shown as a "toggle button" for the date picker.
             */
            'icon' => 'heroicon-s-calendar',

            /*
             * This icon will be shown when there is a value, and will allow you
             * to clear the input.
             */
            'clear_icon' => 'heroicon-s-x-mark',
        ],
        'input' => Components\Inputs\Input::class,
        'email' => Components\Inputs\Email::class,
        'password' => [
            'class' => Components\Inputs\Password::class,

            /*
             * This icon will show when the password is masked and show toggle is enabled.
             * Can be overridden individually as well.
             */
            'show_password_icon' => 'heroicon-s-eye',

            /*
             * This icon will show when the password is un-masked and show toggle is enabled.
             * Can be overridden individually as well.
             */
            'hide_password_icon' => 'heroicon-o-eye-slash',
        ],
        'select' => Components\Inputs\Select::class,
        'textarea' => Components\Inputs\Textarea::class,
        'timezone-select' => Components\Inputs\TimezoneSelect::class,
        // Tree select config is same as custom-select config
        'tree-select' => Components\Inputs\TreeSelect::class,
        'tree-select-option' => Components\Inputs\TreeSelectOption::class,

        // Rich Text
        'quill' => Components\RichText\Quill::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Prefix
    |--------------------------------------------------------------------------
    |
    | This value will set a prefix for all laravel-form-components blade
    | components. By default it's empty. This is useful if you want to avoid
    | collision with components from other libraries.
    |
    | If set with "tw", for example, you can reference components like:
    |
    | <x-tw-form />
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
    | Example: [\Rawilk\FormComponents\Support\TimezoneRegion::AMERICA]
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
    | Third Party Asset Libraries
    |--------------------------------------------------------------------------
    |
    | These settings hold reference to all third party libraries and their
    | asset files served through a CDN. Individual components can require
    | these asset files through their static `$assets` property.
    |
    */
    'assets' => [
        'alpine' => 'https://unpkg.com/alpinejs@3.9.3/dist/cdn.min.js',

        'flatpickr' => [
            'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css',
            'https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.11/flatpickr.min.js',
        ],

        'filepond' => [
            'https://unpkg.com/filepond/dist/filepond.css',
            'https://unpkg.com/filepond/dist/filepond.js',
        ],

        'popper' => 'https://unpkg.com/@popperjs/core@2',

        'quill' => [
            'https://cdn.quilljs.com/1.3.7/quill.snow.css',
            'https://cdn.quilljs.com/1.3.7/quill.min.js',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Enable Third Party Assets
    |--------------------------------------------------------------------------
    |
    | Set this to false to disable linking to third-party CDNs from
    | the 'assets' key in this config. This is ignored if you pass `true`
    | to either `@fcScripts` or `@fcStyles` directives.
    |
    */
    'link_vendor_cdn_assets' => env('FC_LINK_VENDOR_CDN_ASSETS', null),

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
