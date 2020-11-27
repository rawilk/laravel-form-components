import { isArray, isNull, isPlainObject, isUndefined } from './inspect';
import get from './get';

export const normalizeOption = (option, fields = {}, key = null) => {
    // When the option is an object, normalize it.
    if (isPlainObject(option)) {
        const value = get(option, fields.valueField || 'value');
        const text = get(option, fields.textField || 'text');
        const options = get(option, fields.optionField || 'options');

        // When it has options, create an `<optgroup>` object.
        if (! isNull(options)) {
            return {
                label: String(get(option, fields.labelField || 'label') || text),
                options: normalizeOptions(options),
            };
        }

        // Otherwise create an `<option>` object.
        return {
            ...option,

            value: isUndefined(value) ? key || text : value,
            text: String(isUndefined(text) ? key : text),
            disabled: Boolean(get(option, fields.disabledField || 'disabled')),
        };
    }

    // Otherwise create an `<option>` object from the given value.
    return {
        value: key || option,
        text: String(option),
        disabled: false,
    };
};

export const normalizeOptions = (options, fields = {}) => {
    // Normalize the given options array
    if (isArray(options)) {
        return flattenOptions(options.map(option => normalizeOption(option, fields)));
    }

    // If not an array or object, return an empty array.
    return [];
};

const flattenOptions = options => {
    let mapped = [];

    options.forEach(option => {
        // If the option has a "label" property, it is an `<optgroup>`, and
        // its options need to be pushed onto the base option array.
        if (option.hasOwnProperty('label')) {
            mapped.push({ label: option.label });
            mapped = mapped.concat(option.options);
        } else {
            mapped.push(option);
        }
    });

    return mapped;
};
