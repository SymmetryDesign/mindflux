class Errors {
    /**
     * Create a new errors instnace.
     *
     * @param errors
     */
    constructor(errors = {}) {
        this.record(errors);
    }

    /**
     * Get all errors.
     *
     * @returns {*}
     */
    all() {
        return this.errors;
    }

    /**
     * Determine if given field has an error.
     *
     * @param field
     * @returns {boolean}
     */
    has(field) {
        let hasError = this.errors.hasOwnProperty(field);

        if (!hasError) {
            const errors = Object.keys(this.errors).filter(
                e => e.startsWith(`${field}.`) || e.startsWith(`${field}[`)
            );

            hasError = errors.length > 0;
        }

        return hasError;
    }

    /**
     * Get first error of the given field.
     *
     * @param field
     * @returns {*}
     */
    first(field = null) {
        if (field !== null) {
            return this.get(field)[0];
        }

        return this.errors[0][0];
    }

    /**
     * Get all errors of given field.
     *
     * @param field
     * @returns {*|Array}
     */
    get(field) {
        return this.errors[field] || [];
    }

    /**
     * Determine if there is any error.
     *
     * @returns {boolean}
     */
    any() {
        return Object.keys(this.errors).length > 0;
    }

    /**
     * Determine if there is no error.
     *
     * @returns {boolean}
     */
    none() {
        return !this.any();
    }

    /**
     * Record the new errors.
     *
     * @param {object} errors
     */
    record(errors = {}) {
        this.errors = errors;
    }
}

export default Errors;
