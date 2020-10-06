<?php

use Rawilk\FormComponents\Components;

return [
    /*
    |--------------------------------------------------------------------------
    | Components
    |--------------------------------------------------------------------------
    |
    | Below you reference all form components that should be loaded for your
    | app. By default all components from laravel-form-components are loaded
    | in. You can disable or overwrite any component class or alias that
    | you want.
    |
    */
    'components' => [

        'form' => [
            'class' => Components\Form::class,
            'view' => 'form-components::components.form',
        ],

        'input' => [
            'class' => Components\Inputs\Input::class,
            'view' => 'form-components::components.inputs.input',
        ],

        'email' => [
            'class' => Components\Inputs\Email::class,
            'view' => 'form-components::components.inputs.input',
        ],

        'password' => [
            'class' => Components\Inputs\Password::class,
            'view' => 'form-components::components.inputs.password',

            /*
             * This icon will show when the password is masked and show toggle is enabled.
             * Can be overridden individually as well.
             */
            'show_password_icon' => 'heroicon-s-eye',

            /*
             * This icon will show when the password is un-masked and show toggle is enabled.
             * Can be overridden individually as well.
             */
            'hide_password_icon' => 'heroicon-o-eye-off',
        ],

        'textarea' => [
            'class' => Components\Inputs\Textarea::class,
            'view' => 'form-components::components.inputs.textarea',
        ],

        'checkbox' => [
            'class' => Components\Choice\Checkbox::class,
            'view' => 'form-components::components.choice.checkbox-or-radio',
        ],

        'radio' => [
            'class' => Components\Choice\Radio::class,
            'view' => 'form-components::components.choice.checkbox-or-radio',
        ],

        'select' => [
            'class' => Components\Inputs\Select::class,
            'view' => 'form-components::components.inputs.select',
        ],

        'label' => [
            'class' => Components\Label::class,
            'view' => 'form-components::components.label',
        ],

        'checkbox-group' => [
            'class' => Components\Choice\CheckboxGroup::class,
            'view' => 'form-components::components.choice.checkbox-group',
        ],

        'form-group' => [
            'class' => Components\FormGroup::class,
            'view' => 'form-components::components.form-group',
        ],

        'form-error' => [
            'class' => Components\FormError::class,
            'view' => 'form-components::components.form-error',
        ],

        'timezone-select' => [
            'class' => Components\Inputs\TimezoneSelect::class,
            'view' => 'form-components::components.inputs.timezone-select',
        ],

        'date-picker' => [
            'class' => Components\Inputs\DatePicker::class,
            'view' => 'form-components::components.inputs.date-picker',
        ],

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

];
