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
            // Check if there is a custom select in the form group.
            const group = el.closest('[x-form-group]');
            if (! group) {
                return;
            }

            const customSelectButton = group.querySelector('[data-custom-select-button="true"]');

            customSelectButton && customSelectButton.focus({ preventScroll: true });
        },
    });
}
