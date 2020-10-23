export default (array, predicate) => {
    let l = array.length;
    while (l--) {
        if (predicate(array[l], l, array)) {
            return l;
        }
    }

    return -1;
};
