const darkModeSelector = require('./util/darkModeSelector');
const addDarkVariant = require('./util/addDarkVariant');
const plugin = require('tailwindcss/plugin');

module.exports = plugin.withOptions(function (options = {}) {
    return function ({ addUtilities, config }) {
        const darkSelector = darkModeSelector(config('darkMode', 'class'));
        const styles = {};

        const styleFilepond = options.filepond ?? true;
        const styleQuill = options.quill ?? true;

        // choice (checkbox, radio)
        addDarkVariant(styles, '.form-choice', darkSelector, {
            color: 'var(--choice-dark-ring-color)',
            borderColor: 'var(--input-dark-border-color)',
            backgroundColor: 'var(--input-dark-background-color)',
            '--tw-ring-offset-color': 'var(--choice-dark-ring-offset-color)',
            '&:focus': {
                '--tw-ring-color': 'var(--choice-dark-ring-color)',
            },
            '&:checked, &:checked:hover': {
                borderColor: 'transparent',
                backgroundColor: 'currentColor',
            },
        });

        addDarkVariant(styles, '.choice-label label', darkSelector, {
            '--choice-label-color': 'var(--choice-dark-label-color)',
        });

        // input
        addDarkVariant(styles, '.form-text', darkSelector, {
            '--input-background-color': 'var(--input-dark-background-color)',
            '--input-border-color': 'var(--input-dark-border-color)',
            color: 'var(--input-dark-color)',
            '&::placeholder': {
                color: 'var(--input-dark-placeholder-color)',
            },
            '&[disabled], &[readonly]': {
                '--input-disabled-bg-color': 'var(--input-dark-disabled-bg-color)',
                '--input-disabled-border-color': 'var(--input-dark-disabled-border-color)',
                color: 'var(--input-dark-disabled-color)',
                opacity: '.4',
            },
        });

        // custom select
        addDarkVariant(styles, '.custom-select', darkSelector, {
            '--input-background-color': 'var(--input-dark-background-color)',
            '--input-border-color': 'var(--input-dark-border-color)',
            '--input-color': 'var(--input-dark-color)',
            '--custom-select-menu-bg': 'var(--custom-select-dark-menu-bg)',
            '--custom-select-menu-color': 'var(--custom-select-dark-menu-color)',
            '--custom-select-menu-border-color': 'var(--custom-select-dark-menu-border-color)',
            '--custom-select-opt-group-bg': 'var(--custom-select-dark-opt-group-bg)',
            '--custom-select-opt-group-border-color': 'var(--custom-select-dark-opt-group-border-color)',
            '--custom-select-search-border-color': 'var(--custom-select-dark-search-border-color)',
            '--custom-select-opt-group-color': 'var(--custom-select-dark-opt-group-color)',
            '--custom-select-option-selected-bg': 'var(--custom-select-dark-option-selected-bg)',
            '--custom-select-option-selected-color': 'var(--custom-select-dark-option-selected-color)',
            '--custom-select-option-active-bg': 'var(--custom-select-dark-option-active-bg)',
            '--custom-select-option-active-color': 'var(--custom-select-dark-option-active-color)',
            '--custom-select-selected-icon-hover-color': 'var(--custom-select-dark-selected-icon-hover-color)',
            '--tree-select-child-border-color': 'var(--tree-select-dark-child-border-color)',
            '--tree-select-child-hover-border-color': 'var(--tree-select-dark-child-hover-border-color)',

            '&[disabled], &[readonly]': {
                '--input-disabled-bg-color': 'var(--input-dark-disabled-bg-color)',
                '--input-disabled-border-color': 'var(--input-dark-disabled-border-color)',
            },
        });

        // file upload
        addDarkVariant(styles, '.file-upload__input', darkSelector, {
            '--input-background-color': 'var(--input-dark-background-color)',
            '--input-border-color': 'var(--input-dark-border-color)',
            '--input-color': 'var(--input-dark-color)',

            '&::file-selector-button': {
                '--file-upload-button-color': 'var(--file-upload-button-dark-color)',
                '--file-upload-button-bg': 'var(--file-upload-button-dark-bg)',
            },

            '&[disabled], &[readonly]': {
                backgroundColor: 'var(--input-dark-disabled-bg-color)',
                borderColor: 'var(--input-dark-disabled-border-color)',
                color: 'var(--input-dark-disabled-color)',
                opacity: '.4',

                '&::file-selector-button': {
                    '@apply opacity-75': {},
                    backgroundColor: 'var(--file-upload-button-dark-disabled-bg)',
                },
            },
        });

        // addons
        addDarkVariant(styles, ':is(.leading-addon, .trailing-addon)', darkSelector, {
            '--leading-addon-background-color': 'var(--leading-addon-dark-background-color)',
            '--leading-addon-color': 'var(--leading-addon-dark-color)',
            borderColor: 'var(--input-dark-border-color)',
        });

        addDarkVariant(styles, ':is(.inline-addon, .trailing-inline-addon)', darkSelector, {
            color: 'var(--input-dark-color)',
        });

        addDarkVariant(styles, '.inline-addon:has(+ .input-error), .input-error + .trailing-inline-addon', darkSelector, {
            color: 'var(--input-error-dark-color)',
        });

        addDarkVariant(styles, '.clear-button:hover', darkSelector, {
            '--clear-button-hover-bg': 'var(--clear-button-dark-hover-bg)',
            '--clear-button-hover-color': 'var(--clear-button-dark-hover-color)',
        });

        // label
        addDarkVariant(styles, '.form-label', darkSelector, {
            '--label-color': 'var(--label-dark-color)',
        });

        // form group
        addDarkVariant(styles, '.form-group--border', darkSelector, {
            '--form-group-border-color': 'var(--form-group-dark-border-color)',
        });

        // switch toggle
        addDarkVariant(styles, '.switch-toggle__label', darkSelector, {
            '--switch-toggle-label-color': 'var(--switch-toggle-dark-label-color)',
        });

        addDarkVariant(styles, '.switch-toggle', darkSelector, {
            backgroundColor: 'var(--switch-toggle-dark-bg)',
            borderColor: 'var(--switch-toggle-dark-border-color)',
        });

        addDarkVariant(styles, '.peer:focus ~ .switch-toggle', darkSelector, {
            '--tw-ring-color': 'var(--switch-toggle-dark-ring-color)',
        });

        addDarkVariant(styles, '.peer:disabled ~ .switch-toggle__label', darkSelector, {
            color: 'var(--switch-toggle-dark-disabled-label-color)',
        });

        addDarkVariant(styles, '.peer:focus ~ .switch-toggle--short', darkSelector, {
            '--tw-ring-offset-color': 'var(--switch-toggle-dark-ring-offset-color)',
        });

        // filepond
        if (styleFilepond) {
            addDarkVariant(styles, '.filepond--panel-root', darkSelector, {
                borderColor: 'var(--input-dark-border-color)',
                backgroundColor: 'var(--input-dark-background-color)',
            });

            addDarkVariant(styles, '.filepond--root:hover .filepond--panel-root', darkSelector, {
                backgroundColor: 'var(--filepond-dark-hover-bg)',
            });
        }

        // quill
        if (styleQuill) {
            addDarkVariant(styles, ':is(.ql-container .ql-toolbar).ql-snow', darkSelector, {
                borderColor: 'var(--input-dark-border-color)',
            });

            addDarkVariant(styles, '.ql-editor', darkSelector, {
                backgroundColor: 'var(--input-dark-background-color)',
                color: 'var(--input-dark-color)',
            });

            addDarkVariant(styles, '.ql-toolbar.ql-snow', darkSelector, {
                backgroundColor: 'var(--quill-dark-toolbar-bg)',

                '.ql-picker-label': {
                    color: 'var(--quill-dark-toolbar-color)',
                },

                '.ql-picker.ql-expanded .ql-picker-options': {
                    backgroundColor: 'var(--quill-dark-toolbar-dropdown-bg)',
                    borderColor: 'var(--quill-dark-toolbar-dropdown-border-color)',
                },

                '.ql-picker.ql-expanded .ql-picker-label': {
                    borderColor: 'var(--quill-dark-button-focus-border-color)',
                },
            });

            addDarkVariant(styles, '.ql-snow', darkSelector, {
                '.ql-stroke': {
                    stroke: 'var(--quill-dark-toolbar-color)',
                },

                '.ql-fill, .ql-stroke.ql-fill': {
                    fill: 'var(--quill-dark-toolbar-color)',
                },

                '&.ql-toolbar button:is(:focus, :hover)': {
                    color: 'var(--quill-dark-toolbar-hover-color)',
                },

                '.ql-picker-options .ql-picker-item': {
                    color: 'var(--quill-dark-toolbar-color)',
                },
            });

            let toolbarSelectors = [
                '.ql-snow .ql-toolbar .ql-picker-item.ql-selected',
                '.ql-snow .ql-toolbar .ql-picker-item:hover',
                '.ql-snow .ql-toolbar .ql-picker-label.ql-active',
                '.ql-snow .ql-toolbar .ql-picker-label:hover',
                '.ql-snow .ql-toolbar button.ql-active',
                '.ql-snow .ql-toolbar button:focus',
                '.ql-snow .ql-toolbar button:hover',
                '.ql-snow.ql-toolbar .ql-picker-item.ql-selected',
                '.ql-snow.ql-toolbar .ql-picker-item:hover',
                '.ql-snow.ql-toolbar .ql-picker-label.ql-active',
                '.ql-snow.ql-toolbar .ql-picker-label:hover',
                '.ql-snow.ql-toolbar button.ql-active',
                '.ql-snow.ql-toolbar button:focus',
                '.ql-snow.ql-toolbar button:hover',
            ].join(', ');
            addDarkVariant(styles, toolbarSelectors, darkSelector, {
                color: 'var(--quill-dark-toolbar-selected-color)',
            });

            let fillSelectors = [
                '.ql-snow.ql-toolbar button:is(:focus, :hover) .ql-fill',
                '.ql-snow.ql-toolbar button:is(:focus, :hover) .ql-stroke.ql-fill',
                '.ql-snow .ql-toolbar .ql-picker-item.ql-selected .ql-fill',
                '.ql-snow .ql-toolbar .ql-picker-item.ql-selected .ql-stroke.ql-fill',
                '.ql-snow .ql-toolbar .ql-picker-item:hover .ql-fill',
                '.ql-snow .ql-toolbar .ql-picker-item:hover .ql-stroke.ql-fill',
                '.ql-snow .ql-toolbar .ql-picker-label.ql-active .ql-fill',
                '.ql-snow .ql-toolbar .ql-picker-label.ql-active .ql-stroke.ql-fill',
                '.ql-snow .ql-toolbar .ql-picker-label:hover .ql-fill',
                '.ql-snow .ql-toolbar .ql-picker-label:hover .ql-stroke.ql-fill',
                '.ql-snow .ql-toolbar button.ql-active .ql-fill',
                '.ql-snow .ql-toolbar button.ql-active .ql-stroke.ql-fill',
                '.ql-snow .ql-toolbar button:focus .ql-fill',
                '.ql-snow .ql-toolbar button:focus .ql-stroke.ql-fill',
                '.ql-snow .ql-toolbar button:hover .ql-fill',
                '.ql-snow .ql-toolbar button:hover .ql-stroke.ql-fill',
                '.ql-snow.ql-toolbar .ql-picker-item.ql-selected .ql-fill',
                '.ql-snow.ql-toolbar .ql-picker-item.ql-selected .ql-stroke.ql-fill',
                '.ql-snow.ql-toolbar .ql-picker-item:hover .ql-fill',
                '.ql-snow.ql-toolbar .ql-picker-item:hover .ql-stroke.ql-fill',
                '.ql-snow.ql-toolbar .ql-picker-label.ql-active .ql-fill',
                '.ql-snow.ql-toolbar .ql-picker-label.ql-active .ql-stroke.ql-fill',
                '.ql-snow.ql-toolbar .ql-picker-label:hover .ql-fill',
                '.ql-snow.ql-toolbar .ql-picker-label:hover .ql-stroke.ql-fill',
                '.ql-snow.ql-toolbar button.ql-active .ql-fill',
                '.ql-snow.ql-toolbar button.ql-active .ql-stroke.ql-fill',
                '.ql-snow.ql-toolbar button:focus .ql-fill',
                '.ql-snow.ql-toolbar button:focus .ql-stroke.ql-fill',
                '.ql-snow.ql-toolbar button:hover .ql-fill',
                '.ql-snow.ql-toolbar button:hover .ql-stroke.ql-fill',
            ].join(', ');
            addDarkVariant(styles, fillSelectors, darkSelector, {
                fill: 'var(--quill-dark-toolbar-hover-color)',
            });

            let strokeSelectors = [
                '.ql-snow .ql-toolbar .ql-picker-item.ql-selected .ql-stroke',
                '.ql-snow .ql-toolbar .ql-picker-item.ql-selected .ql-stroke-miter',
                '.ql-snow .ql-toolbar .ql-picker-item:hover .ql-stroke',
                '.ql-snow .ql-toolbar .ql-picker-item:hover .ql-stroke-miter',
                '.ql-snow .ql-toolbar .ql-picker-label.ql-active .ql-stroke',
                '.ql-snow .ql-toolbar .ql-picker-label.ql-active .ql-stroke-miter',
                '.ql-snow .ql-toolbar .ql-picker-label:hover .ql-stroke',
                '.ql-snow .ql-toolbar .ql-picker-label:hover .ql-stroke-miter',
                '.ql-snow .ql-toolbar button.ql-active .ql-stroke',
                '.ql-snow .ql-toolbar button.ql-active .ql-stroke-miter',
                '.ql-snow .ql-toolbar button:focus .ql-stroke',
                '.ql-snow .ql-toolbar button:focus .ql-stroke-miter',
                '.ql-snow .ql-toolbar button:hover .ql-stroke',
                '.ql-snow .ql-toolbar button:hover .ql-stroke-miter',
                '.ql-snow.ql-toolbar .ql-picker-item.ql-selected .ql-stroke',
                '.ql-snow.ql-toolbar .ql-picker-item.ql-selected .ql-stroke-miter',
                '.ql-snow.ql-toolbar .ql-picker-item:hover .ql-stroke',
                '.ql-snow.ql-toolbar .ql-picker-item:hover .ql-stroke-miter',
                '.ql-snow.ql-toolbar .ql-picker-label.ql-active .ql-stroke',
                '.ql-snow.ql-toolbar .ql-picker-label.ql-active .ql-stroke-miter',
                '.ql-snow.ql-toolbar .ql-picker-label:hover .ql-stroke',
                '.ql-snow.ql-toolbar .ql-picker-label:hover .ql-stroke-miter',
                '.ql-snow.ql-toolbar button.ql-active .ql-stroke',
                '.ql-snow.ql-toolbar button.ql-active .ql-stroke-miter',
                '.ql-snow.ql-toolbar button:focus .ql-stroke',
                '.ql-snow.ql-toolbar button:focus .ql-stroke-miter',
                '.ql-snow.ql-toolbar button:hover .ql-stroke',
                '.ql-snow.ql-toolbar button:hover .ql-stroke-miter',
            ].join(', ');
            addDarkVariant(styles, strokeSelectors, darkSelector, {
                stroke: 'var(--quill-dark-toolbar-hover-color)',
            });
        }

        // errors
        addDarkVariant(styles, '.has-error label', darkSelector, {
            color: 'var(--input-error-dark-label-color)',
        });

        addDarkVariant(styles, '.input-error, .has-error :is(.form-text, .form-select, .custom-select__button, .file-upload__input)', darkSelector, {
            '--input-dark-color': 'var(--input-error-dark-color)',
            '--input-dark-placeholder-color': 'var(--input-error-dark-placeholder-color)',
            '--input-dark-border-color': 'var(--input-error-dark-border-color)',
        });

        addDarkVariant(styles, '.has-error .file-upload__input::file-selector-button', darkSelector, {
            '--file-upload-button-color': 'var(--file-upload-button-error-dark-color)',
        });

        addDarkVariant(styles, '.has-error :is(.ql-container, .ql-toolbar).ql-snow', darkSelector, {
            borderColor: 'var(--input-error-dark-border-color)',
        });

        // We use addUtilities instead of addComponents because we want these styles to come after
        // all other styles in the stylesheet, so that they can override any other styles.
        addUtilities(styles);
    };
});
