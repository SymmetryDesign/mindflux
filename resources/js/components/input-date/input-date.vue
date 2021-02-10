<template>
    <input class="form-input" :class="{ 'hidden': inline }" ref="input" v-model="date">
</template>

<script>
    export default {
        props: {
            value: {
                type: String,
                default: null
            },
            mode: {
                type: String,
                default: 'single',
                validator: (mode) => ['single', 'multiple', 'range'].includes(mode)
            },
            inline: {
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                date: '',
            }
        },

        mounted() {
            this.date = this.value;

            let $flatpickr = flatpickr(this.$refs.input, {
                defaultDate: this.value,
                dateFormat: 'Y-m-d',
                mode: this.mode,
                inline: this.inline,
                onChange: (dates, dateStr) => {
                    if (dateStr === this.date) {
                        $flatpickr.clear();
                    } else {
                        this.date = dateStr;
                        this.$emit('input', this.date);
                    }
                }
            });
        }
    }
</script>
