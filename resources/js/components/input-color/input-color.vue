<template>
    <div>
        <label class="block text-sm font-medium leading-5 text-gray-700" v-if="label" v-text="label"></label>
        <div class="flex flex-wrap items-center mt-1 -mx-1">
            <div class="px-1" v-for="bg in colors">
                <a @click.prevent="select(bg)"
                   class="bg-gray-600 flex items-center text-white text-xs justify-center w-6 h-6 overflow-hidden rounded-md focus:outline-none focus:shadow-outline-blue"
                   :class="['bg-' + bg + '-400']" href="#">
                    <svg class="w-4 h-4 fill-current inline-block" v-if="bg === color" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            value: {
                type: String,
                default: null
            },
            label: {
                type: String,
                default: null
            }
        },

        data() {
            return {
                color: this.value,
                colors: [
                    'blue', 'red', 'green', 'indigo', 'orange', 'purple', 'teal', 'pink'
                ]
            }
        },

        methods: {
            select(color) {
                this.color = color;
                this.$emit('input', this.color);
            }
        }
    }
</script>
