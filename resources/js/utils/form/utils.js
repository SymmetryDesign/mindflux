/**
 * Check if the given param is an array.
 *
 * @param object
 * @returns {boolean}
 */
export function isArray(object) {
    return Object.prototype.toString.call(object) === '[object Array]';
}

/**
 * Check if the given param is file.
 *
 * @param object
 * @returns {boolean}
 */
export function isFile(object) {
    return object instanceof File || object instanceof FileList;
}

/**
 * Merge two objects.
 *
 * @param a
 * @param b
 */
export function merge(a, b) {
    for (const key in b) {
        a[key] = cloneDeep(b[key]);
    }
}

/**
 * Deeply clone an object.
 *
 * @param object
 * @returns {null|[]|*}
 */
export function cloneDeep(object) {
    if (object === null) {
        return null;
    }

    if (isFile(object)) {
        return object;
    }

    if (Array.isArray(object)) {
        const clone = [];

        for (const key in object) {
            if (object.hasOwnProperty(key)) {
                clone[key] = cloneDeep(object[key]);
            }
        }

        return clone;
    }

    if (typeof object === 'object') {
        const clone = {};

        for (const key in object) {
            if (object.hasOwnProperty(key)) {
                clone[key] = cloneDeep(object[key]);
            }
        }

        return clone;
    }

    return object;
}
