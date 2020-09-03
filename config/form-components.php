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
     * You can specify a prefix for the form components.
     *
     * Example: 'tailwind' => 'x-tailwind-form'
     */
    // 'prefix' => '',
    //
    // 'components' => [
    //     'form' => [
    //         'view' => 'form-components::form',
    //         'class' => Components\Form::class,
    //     ],
    //
    //     'form-checkbox' => [
    //         'view' => 'form-components::form-checkbox',
    //         'class' => Components\FormCheckbox::class,
    //     ],
    //
    //     'form-checkbox-group' => [
    //         'view' => 'form-components::form-checkbox-group',
    //         'class' => Components\FormCheckboxGroup::class,
    //     ],
    //
    //     'form-errors' => [
    //         'view' => 'form-components::form-errors',
    //         'class' => Components\FormErrors::class,
    //     ],
    //
    //     'form-group' => [
    //         'view' => 'form-components::form-group',
    //         'class' => Components\FormGroup::class,
    //     ],
    //
    //     'form-input' => [
    //         'view' => 'form-components::form-input',
    //         'class' => Components\FormInput::class,
    //     ],
    //
    //     'form-label' => [
    //         'view' => 'form-components::form-label',
    //         'class' => Components\FormLabel::class,
    //     ],
    //
    //     'form-radio' => [
    //         'view' => 'form-components::form-radio',
    //         'class' => Components\FormRadio::class,
    //     ],
    //
    //     'form-select' => [
    //         'view' => 'form-components::form-select',
    //         'class' => Components\FormSelect::class,
    //     ],
    //
    //     'form-submit' => [
    //         'view' => 'form-components::form-submit',
    //         'class' => Components\FormSubmit::class,
    //     ],
    //
    //     'form-textarea' => [
    //         'view' => 'form-components::form-textarea',
    //         'class' => Components\FormTextarea::class,
    //     ],
    //
    // ],
];
