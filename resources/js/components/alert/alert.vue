<template>
    <div :class="alertClass" v-if="visible">
        <p>
            <slot></slot>
        </p>

        <button class="flex items-center p-1 focus:outline-none ml-auto" @click="visible = false" v-if="dismissible">
            <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 fill-current">
                <path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"></path>
            </svg>
        </button>
    </div>
</template>

<script>
    export default {
        props: {
            variant: {
                type: String,
                default: 'success',
                validator: (variant) => ['success', 'warning', 'failure'].includes(variant)
            },
            dismissible: {
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                visible: true
            }
        },

        computed: {
            alertClass() {
                return [
                    'alert',
                    'alert-' + this.variant
                ];
            }
        },

        watch: {
            '$page.flash': {
                deep: true,
                handler: function () {
                    this.visible = true;
                }
            }
        }
    }
</script>
