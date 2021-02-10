<template>
    <div>
        <div class="mt-1 flex rounded-md shadow-sm">
            <input :accept="accept" @change="change" class="hidden" ref="file" type="file">

            <div class="relative flex-grow focus-within:z-10">
                <input @click="browse()" class="form-input rounded-l-md rounded-r-none cursor-pointer" :value="filename" readonly/>
            </div>

            <button @click="browse()" class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-r-md text-gray-700 bg-gray-50 hover:text-gray-500 hover:bg-white focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M8 256C8 119 119 8 256 8s248 111 248 248-111 248-248 248S8 393 8 256zm143.6 28.9l72.4-75.5V392c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V209.4l72.4 75.5c9.3 9.7 24.8 9.9 34.3.4l10.9-11c9.4-9.4 9.4-24.6 0-33.9L273 107.7c-9.4-9.4-24.6-9.4-33.9 0L106.3 240.4c-9.4 9.4-9.4 24.6 0 33.9l10.9 11c9.6 9.5 25.1 9.3 34.4-.4z"></path>
                </svg>

                <span class="ml-2">{{ $trans('labels.browse') }}</span>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            value: {
                type: File,
                default: null
            },
            accept: {
                type: String,
                default: null
            }
        },

        data() {
            return {
                file: null
            }
        },

        computed: {
            filename() {
                if (this.file) {
                    return this.file.name;
                }
            }
        },

        methods: {
            browse() {
                this.$refs.file.click();
            },

            change(e) {
                this.file = e.target.files[0];

                this.$emit('input', this.file);
            }
        }
    }
</script>
