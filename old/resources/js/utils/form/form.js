import {isArray, merge} from '@/utils/form/utils'

class Form {
    /**
     * Create a new form instance.
     *
     * @param data
     */
    constructor(data = {}) {
        this.withData(data)
    }

    /**
     * Fill form with given data.
     *
     * @param data
     */
    withData(data) {
        this.processing = false;

        if (isArray(data)) {
            data = data.reduce((carry, element) => {
                carry[element] = '';
                return carry;
            }, {});
        }

        this.setInitialValues(data);

        this.processing = false;

        for (const field in data) {
            this[field] = data[field];
        }
    }

    /**
     * Get all form data.
     *
     * return {object}
     */
    data() {
        const data = {};

        for (const property in this.initial) {
            data[property] = this[property];
        }

        return data;
    }

    /**
     * Get form data of the given fields.
     *
     * @param fields
     * @returns {*}
     */
    only(fields) {
        return fields.reduce((filtered, field) => {
            filtered[field] = this[field];
            return filtered;
        }, {});
    }

    /**
     * Rest form fields.
     */
    reset() {
        merge(this, this.initial);
    }

    /**
     * Set form initial data values.
     *
     * @param values
     */
    setInitialValues(values) {
        this.initial = {};

        merge(this.initial, values);
    }
}

export default Form;
