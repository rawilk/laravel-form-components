const resize = el => {
    el.style.height = 'auto';
    el.style.height = `${el.scrollHeight}px`;
};

export default Alpine => {
    Alpine.directive('textarea-resize', (el, {}, { cleanup }) => {
        el.style.minHeight = `${el.scrollHeight}px`;
        resize(el);

        const inputHandler = () => resize(el);

        el.addEventListener('input', inputHandler);

        cleanup(() => {
            el.removeEventListener('input', inputHandler);
        });
    });
};
