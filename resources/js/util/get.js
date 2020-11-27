import { isArray, isNull, isObject, isUndefinedOrNull } from './inspect';
import { RX_ARRAY_NOTATION } from './regex';
import identity from './identity';

/**
 * Get property defined by dot/array notation in string, returns undefined if not found.
 *
 * @param {Object} obj
 * @param {String|Array} path
 * @param {*} defaultValue
 * @return {*}
 */
export const getRaw = (obj, path, defaultValue = undefined) => {
    // Handle array of path values.
    path = isArray(path) ? path.join('.') : path;
    
    // If no path or object passed.
    if (! path || ! isObject(obj)) {
        return defaultValue;
    }
    
    // Handle edge case where user has dot(s) in top-level item field key.
    // Using `in` operator vs `hasOwnProperty` to handle obj.prototype getters.
    if (path in obj) {
        return obj[path];
    }
    
    // Handle string array notation (numeric indices only).
    path = String(path).replace(RX_ARRAY_NOTATION, '.$1');
    
    const steps = path.split('.').filter(identity);
    
    // Handle case where someone passes a string of only dots
    if (steps.length === 0) {
        return defaultValue;
    }
    
    // Traverse path in object to find result.
    // Using `in` operator vs `hasOwnProperty` to handle obj.prototype getters.
    return steps.every(step => isObject(obj) && step in obj && ! isUndefinedOrNull((obj = obj[step])))
        ? obj
        : isNull(obj)
            ? null
            : defaultValue;
};

/**
 * Get property by dot/array notation in string.
 * 
 * @param {Object} obj
 * @param {String|Array} path
 * @param {*} defaultValue (optional)
 * @return {*}
 */
export const get = (obj, path, defaultValue = null) => {
    const val = getRaw(obj, path);
    
    return isUndefinedOrNull(val) ? defaultValue : val;
};

export default get;
