export default function (Alpine) {
    Alpine.directive('form-group', (el, directive) => {
        if (directive.value === 'label') {
            handleLabel(el, Alpine);
        } else {
            handleRoot(el, Alpine);
        }
    });
}

function handleRoot(el, Alpine) {
    Alpine.bind(el, {
        'x-id'() { return ['fc-label'] },
    });
}

function handleLabel(el, Alpine) {
    Alpine.bind(el, {
        '@click'() {
            const group = el.closest('[x-form-group]');
            if (! group) {
                return;
            }

            // Check if there is a custom select in the form group.
            const customSelectButton = group.querySelector('[data-custom-select-button="true"]');
            if (customSelectButton) {
                customSelectButton.focus({ preventScroll: true });

                return;
            }

            // Check if there is a quill editor in the form group.
            const quill = group.querySelector('.quill-wrapper');
            if (quill) {
                Alpine.$data(quill).focus();
            }
        },
    });
}
