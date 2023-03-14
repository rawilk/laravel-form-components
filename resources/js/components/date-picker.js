export default function (Alpine) {
    Alpine.data('datePicker', config => ({
        __ready: false,
        __value: config.value,
        __rawValue: null,
        __mode: config.mode ?? config.options.mode ?? 'single',
        __isDisabled: false,
        __flatpickr: undefined,

        init() {
            if (typeof window.flatpickr !== 'function') {
                throw new Error(`date-picker requires Flatpickr. See https://flatpickr.js.org`);
            }

            let value = this.__value;
            if (value?.hasOwnProperty('initialValue')) {
                value = value.initialValue;
            }

            this.__rawValue = value;


            // We have to wait for the rest of the HTML to initialize in Alpine before
            // we can mark this component as "ready".
            queueMicrotask(() => {
                this.__ready = true;

                this.__flatpickr = window.flatpickr(this.$refs.__input, this.__config());
            });

            this.$watch('__value', newValue => {
                this.__rawValue = newValue;
                this.__flatpickr.setDate(newValue);
                this.$dispatch('input', newValue);
            });

            this.$watch('__isDisabled', newValue => {
                if (newValue) {
                    this.__flatpickr.set('clickOpens', false);
                } else {
                    this.__flatpickr.set('clickOpens', config.options.clickOpens);
                }
            });
        },

        __open() {
            ! this.__isDisabled && this.__flatpickr.open();
        },

        __clear() {
            if (this.__isDisabled) {
                return;
            }

            this.__value = this.__mode === 'single'
                ? null
                : [];
        },

        __config() {
            let onOpen = [
                function (selectedDates, dateStr, instance) {
                    instance.setDate(this.__rawValue);
                }.bind(this),
            ];

            let customConfig = config.config ?? {};
            if (customConfig.hasOwnProperty('onOpen')) {
                let customOnOpen = Array.isArray(customConfig.onOpen) ? customConfig.onOpen : [customConfig.onOpen];

                onOpen = onOpen.concat(customOnOpen);

                delete customConfig.onOpen;
            }

            return {
                defaultDate: this.__rawValue,
                ...config.options,
                onOpen,
                onChange: function(date, dateString) {
                    let newValue = dateString;
                    if (this.__mode === 'multiple') {
                        newValue = dateString.split(', ');
                    } else if (this.__mode === 'range') {
                        newValue = dateString.split(' to ');
                    }

                    this.__value = newValue;
                }.bind(this),
                ...customConfig,
            };
        },
    }));

    Alpine.directive('date-picker', (el, directive, { cleanup }) => {
        switch (directive.value) {
            case 'clear':
                handleClear(el, Alpine);
                break;
            case 'container':
                handleContainer(el, Alpine);
                break;
            case 'input':
                handleInput(el, Alpine);

                cleanup(() => {
                    const parent = el.closest('[x-data]');

                    parent && Alpine.$data(parent).__flatpickr.destroy();
                });

                break;
            case 'toggle':
                handleToggle(el, Alpine);
                break;
            default:
                throw new Error(`Unknown date-picker directive value: ${directive.value}`);
        }
    });

    Alpine.magic('datePicker', el => {
        let data = Alpine.$data(el);

        if (! data.__ready) {
            return {
                isDisabled: false,
                flatpickr: undefined,
                hasValue: false,
                open() {},
            };
        }

        return {
            get isDisabled() {
                return data.__isDisabled;
            },
            get flatpickr() {
                return data.__flatpickr;
            },
            get hasValue() {
                if (data.__mode === 'single') {
                    return data.__value !== null && data.__value !== '';
                }

                return Array.isArray(data.__value) && data.__value.length > 0;
            },
            open() {
                data.__open();
            },
        };
    });
}

function handleInput(el, Alpine) {
    Alpine.bind(el, {
        'x-ref': '__input',
        'type': 'text',
        'x-init'() {
            this.$data.__isDisabled = this.$el.disabled || this.$el.readOnly;

            queueMicrotask(() => {
                const observer = new MutationObserver(mutations => {
                    mutations.forEach(mutation => {
                       if (mutation.attributeName === 'disabled' || mutation.attributeName === 'readonly') {
                           this.$data.__isDisabled = this.$el.disabled || this.$el.readOnly;
                       }
                    });
                });

                observer.observe(this.$el, { attributes: true });
            });
        },
    });
}

// Since we're using wire:ignore on the input, we are going to show error attributes (i.e. aria-invalid) on the container.
// We'll watch for these changes with a mutation observer and then apply them to the input.
function handleContainer(el, Alpine) {
    Alpine.bind(el, {
        'x-ref': '__container',
        'role': 'none',
        'x-init'() {
            const observer = new MutationObserver(mutations => {
                mutations.forEach(mutation => {
                    if (mutation.attributeName === 'aria-invalid') {
                        const invalid = mutation.target.getAttribute('aria-invalid') === 'true';

                        if (invalid) {
                            this.$refs.__input.setAttribute('aria-invalid', 'true');
                            this.$refs.__input.classList.add('input-error');
                        } else {
                            this.$refs.__input.removeAttribute('aria-invalid');
                            this.$refs.__input.classList.remove('input-error');
                        }
                    } else if (mutation.attributeName === 'aria-describedby') {
                        const describedBy = mutation.target.getAttribute('aria-describedby');

                        if (describedBy) {
                            this.$refs.__input.setAttribute('aria-describedby', describedBy);
                        } else {
                            this.$refs.__input.removeAttribute('aria-describedby');
                        }
                    }
                });
            });

            observer.observe(this.$el, { attributes: true });
        },
    });
}

function handleToggle(el, Alpine) {
    Alpine.bind(el, {
        'x-ref': '__toggle',
        ':role'() {
            if (this.$datePicker.isDisabled) {
                return false;
            }

            if (this.$el.tagName.toLowerCase() === 'button') {
                return false;
            }

            return 'button';
        },
        '@click'() {
            this.$datePicker.open();
        },
    });
}

function handleClear(el, Alpine) {
    Alpine.bind(el, {
        'x-ref': '__clear',
        'x-init'() {
            if (this.$el.tagName.toLowerCase() === 'button' && ! this.$el.hasAttribute('type')) {
                this.$el.setAttribute('type', 'button');
            }
        },
        '@click'() {
            this.$data.__clear();
        },
        'x-show'() { return this.$datePicker.hasValue && ! this.$datePicker.isDisabled },
    });
}
