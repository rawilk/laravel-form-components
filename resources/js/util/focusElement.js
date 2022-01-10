export const focusElementInParent = (el, parent, options = {}) => {
    try {
        const offsetTop = el.offsetTop;
        parent.scrollTop = offsetTop || 0;

        if (! isInParentViewport(el, parent, options)) {
            el.scrollIntoView({ block: options.block || 'end', inline: 'nearest', behavior: 'smooth' });
        }
    } catch (e) {}
};

const isInParentViewport = (el, parent, options = {}) => {
    const position = positionRelativeToParent(el, parent);
    const threshold = options.threshold || el.offsetHeight;

    return (
        position.top >= 0 &&
        position.left >= 0 &&
        position.bottom <= parent.offsetHeight &&
        position.right <= parent.offsetWidth &&
        position.top <= (parent.offsetHeight - threshold)
    );
};

const positionRelativeToParent = (el, parent) => {
    const parentPosition = parent.getBoundingClientRect();
    const childPosition = el.getBoundingClientRect();

    return {
        top: childPosition.top - parentPosition.top,
        right: childPosition.right - parentPosition.right,
        bottom: childPosition.bottom - parentPosition.bottom,
        left: childPosition.left - parentPosition.left,
    };
};
