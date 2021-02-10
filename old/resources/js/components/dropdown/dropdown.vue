<template>
    <div @keyup.esc="open = false" class="relative inline-block text-left">
        <div @click="toggle()">
            <slot name="button"></slot>
        </div>

        <div v-show="open" class="origin-top-right absolute mt-2 w-auto rounded-md shadow-lg z-40" :class="[placement]">
            <slot name="content"></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            placement: {
                type: String,
                default: 'right-0'
            }
        },

        data() {
            return {
                open: false,
            };
        },

        methods: {
            toggle() {
                this.open = !this.open;
            }
        },

        mounted() {
            document.addEventListener('click', evt => {
                evt.stopPropagation();
                if (!this.$el.contains(evt.target)) {
                    this.open = false;
                }
            });
        }
    }
</script>
