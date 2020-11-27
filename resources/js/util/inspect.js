export const isArray = val => Array.isArray(val);

export const isUndefined = val => val === undefined;

export const isNull = val => val === null;

export const isUndefinedOrNull = val => isUndefined(val) || isNull(val);

// Quick object check.
// This is primarily used to tell Objects from primitive values
// when we know the value is a JSON-compliant type.
// Note: object could be a complex type like array, Date, etc.
export const isObject = obj => obj !== null && typeof obj === 'object';

// Strict object type check.
// Only returns true for plain JavaScript objects.
export const isPlainObject = obj => Object.prototype.toString.call(obj) === '[object Object]';
