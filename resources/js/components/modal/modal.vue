<template>
    <transition name="fade">
        <div v-if="open" class="fixed inset-0 max-h-full overflow-y-auto p-6 z-40" style="background-color: rgba(0, 0, 0, 0.40);">
            <div class="mx-auto max-w-xl">
                <slot></slot>
            </div>
        </div>
    </transition>
</template>

<script>
    import {removeElement} from '@/utils/helpers'

    export default {
        props: {
            programmatic: {
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                open: false
            }
        },

        methods: {
            show() {
                this.open = true;
                document.querySelector('main').classList.remove('overflow-y-auto');
                this.$emit('modal:shown');
            },

            hide() {
                this.$emit('modal:hidden');
                document.querySelector('main').classList.add('overflow-y-auto');
                this.open = false;

                if (this.programmatic) {
                    setTimeout(() => {
                        this.$destroy();
                        removeElement(this.$el);
                    }, 150);
                }
            }
        }
    }
</script>
