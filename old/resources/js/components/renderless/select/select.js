export default {
    props: {
        value: {
            type: [Array, String, Number],
            default: null
        },
        items: {
            type: Array,
            default: []
        },
        mode: {
            type: String,
            default: 'single',
            validator: (mode) => ['single', 'multiple'].includes(mode)
        },
        itemText: {
            type: String,
            default: 'text'
        },
        itemValue: {
            type: String,
            default: 'id'
        },
        toggleSelect: {
            type: Boolean,
            default: false
        },
        filter: {
            type: Function,
            default: function () {
                return this.items.filter(item => {
                    return this.getItemText(item).toString().toLowerCase().match(this.searchQuery.toLowerCase());
                });
            }
        }
    },

    data() {
        return {
            selected: [],
            searchQuery: ''
        }
    },

    computed: {
        filteredItems() {
            return this.filter();
        }
    },

    watch: {
        value(val) {
            this.selected = [];
            this.setInternalValue(val);
        }
    },

    mounted() {
        this.setInternalValue(this.value);
    },

    render() {
        return this.$scopedSlots.default({
            items: this.filteredItems,
            select: this.select,
            selected: this.mode === 'single' ? this.selected[0] : this.selected,
            search: this.search,
            isSelected: this.isSelected,
            getItemText: this.getItemText,
            getItemValue: this.getItemValue
        });
    },

    methods: {
        getItemText(item) {
            if (typeof item === 'object') {
                if (!item.hasOwnProperty(this.itemText)) {
                    console.warn('Unable to retrieve item text. The specified item-text does not exists.')
                }

                return item[this.itemText];
            }

            return item;
        },

        getItemValue(item) {
            if (typeof item === 'object') {
                if (!item.hasOwnProperty(this.itemValue)) {
                    console.warn('Unable to retrieve item text. The specified item-value does not exists.')
                }

                return item[this.itemValue];
            }

            return item;
        },

        select(item, emit = true) {
            if (this.mode === 'single') {
                if (this.toggleSelect && this.isSelected(item)) {
                    this.selected = [];
                } else {
                    this.selected = [item];
                }
            }

            if (this.mode === 'multiple') {
                if (this.toggleSelect && this.isSelected(item)) {
                    this.selected = this.selected.filter(i => this.getItemValue(i) !== this.getItemValue(item));
                } else {
                    this.selected.push(item);
                }
            }

            if (!emit) {
                return;
            }

            if (this.mode === 'single' && this.selected.length > 0) {
                this.$emit('input', this.getItemValue(this.selected[0]));
            } else {
                this.$emit('input', null);
            }

            if (this.mode === 'multiple' && this.selected.length > 0) {
                this.$emit('input', this.selected.map(i => this.getItemValue(i)));
            }
        },

        isSelected(item) {
            if (this.mode === 'single') {
                return this.getItemValue(this.selected[0]) === this.getItemValue(item);
            }

            if (this.mode === 'multiple') {
                return this.selected.some(i => this.getItemValue(i) === this.getItemValue(item))
            }
        },

        search(query) {
            this.searchQuery = query;
        },

        setInternalValue(vals) {
            if (!_.isArray(vals)) {
                vals = [vals];
            }

            this.items.forEach(item => {
                if (vals.includes(this.getItemValue(item))) {
                    this.select(item, false);
                }
            });
        }
    }
}
