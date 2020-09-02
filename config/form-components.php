<?php

use Rawilk\FormComponents\Components;

return [
    /*
     * You can specify a prefix for the form components.
     *
     * Example: 'tailwind' => 'x-tailwind-form'
     */
    'prefix' => '',

    'components' => [
        'form' => [
            'view' => 'form-components::form',
            'class' => Components\Form::class,
        ],

        'form-checkbox' => [
            'view' => 'form-components::form-checkbox',
            'class' => Components\FormCheckbox::class,
        ],

        'form-checkbox-group' => [
            'view' => 'form-components::form-checkbox-group',
            'class' => Components\FormCheckboxGroup::class,
        ],

        'form-errors' => [
            'view' => 'form-components::form-errors',
            'class' => Components\FormErrors::class,
        ],

        'form-group' => [
            'view' => 'form-components::form-group',
            'class' => Components\FormGroup::class,
        ],

        'form-input' => [
            'view' => 'form-components::form-input',
            'class' => Components\FormInput::class,
        ],

        'form-label' => [
            'view' => 'form-components::form-label',
            'class' => Components\FormLabel::class,
        ],

        'form-radio' => [
            'view' => 'form-components::form-radio',
            'class' => Components\FormRadio::class,
        ],

        'form-select' => [
            'view' => 'form-components::form-select',
            'class' => Components\FormSelect::class,
        ],

        'form-submit' => [
            'view' => 'form-components::form-submit',
            'class' => Components\FormSubmit::class,
        ],

        'form-textarea' => [
            'view' => 'form-components::form-textarea',
            'class' => Components\FormTextarea::class,
        ],

    ],
];
