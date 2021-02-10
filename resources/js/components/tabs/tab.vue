<template>
    <section v-show="isVisible">
        <slot></slot>
    </section>
</template>

<script>
    export default {
        props: {
            name: {
                type: String,
                default: null,
                required: true
            },
            active: {
                type: Boolean,
                default: false
            },
            disabled: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                isVisible: this.active,
            }
        },
        computed: {
            id() {
                return this.name.toLowerCase().replace(/ /g, '-');
            }
        }
    }
</script>
