const resize = el => {
    if (! el.style.minHeight) {
        el.style.minHeight = `${el.scrollHeight}px`;
    }

    el.style.height = 'auto';
    el.style.height = `${el.scrollHeight}px`;
};

const isHidden = el => {
    if (el.style.display === 'none') {
        return true;
    }

    return ! el.offsetParent;
};

export default Alpine => {
    Alpine.directive('textarea-resize', (el, {}, { cleanup }) => {
        // We should not attempt to resize the textarea when it is not visible,
        // otherwise the height will be set to 0.
        if (! isHidden(el)) {
            resize(el);
        }

        const inputHandler = () => resize(el);

        el.addEventListener('input', inputHandler);

        cleanup(() => {
            el.removeEventListener('input', inputHandler);
        });
    });
};
