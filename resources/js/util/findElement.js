export const findClosest = (el, callback) => {
    if (! el) {
        return;
    }

    if (callback(el)) {
        return el;
    }

    if (! el.parentElement) {
        return;
    }

    return findClosest(el.parentElement, callback);
};
