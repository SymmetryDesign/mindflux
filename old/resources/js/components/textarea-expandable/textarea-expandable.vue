<template>
    <textarea class="form-textarea w-full block resize-none" v-model="content" @input="[autosize(), $emit('input', content)]"></textarea>
</template>

<script>
    export default {
        props: {
            value: {
                type: String,
                default: null
            }
        },

        data() {
            return {
                content: this.value
            }
        },

        mounted() {
            this.autosize();
        },

        watch: {
            value(val) {
                this.content = val;
            }
        },

        methods: {
            autosize() {
                this.$el.style.height = 'inherit';

                let computed = window.getComputedStyle(this.$el);

                let height = parseInt(computed.getPropertyValue('border-top-width'), 10)
                    + parseInt(computed.getPropertyValue('padding-top'), 10)
                    + this.$el.scrollHeight
                    + parseInt(computed.getPropertyValue('padding-bottom'), 10)
                    + parseInt(computed.getPropertyValue('border-bottom-width'), 10);

                this.$el.style.height = height + 'px';
            }
        }
    }
</script>
