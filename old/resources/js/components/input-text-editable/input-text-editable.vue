<template>
    <div class="block w-full">
        <div v-if="!editable" class="cursor-pointer" @click="enableEditMode()">
            {{ valueAfterEdit }}
        </div>

        <div v-else class="mt-1 flex rounded-md shadow-sm" v-click-outside="handleClickOutside">
            <div class="relative flex-grow focus-within:z-10">
                <input @keyup.enter="commitChanges()" class="form-input block w-full rounded-none rounded-l-md transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-model="valueAfterEdit" ref="input"/>
            </div>

            <span class="btn-group">
                <button @click="discardChanges()" type="button" class="btn btn-white rounded-l-none border-l-0">
                    <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/>
                    </svg>
                </button>

                <button @click="commitChanges()" type="button" class="btn btn-white">
                    <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/>
                    </svg>
                </button>
            </span>
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

            allowEmpty: {
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                editable: false,
                valueBeforeEdit: this.value,
                valueAfterEdit: this.value
            }
        },

        watch: {
            value(val) {
                this.valueBeforeEdit = val;
            }
        },

        methods: {
            handleClickOutside() {
                this.disableEditMode();
                this.commitChanges();
            },

            enableEditMode() {
                this.editable = true;
                this.$emit('edit-enabled');

                this.$nextTick(() => {
                    this.$refs.input.focus();
                });
            },

            disableEditMode() {
                this.editable = false;
                this.$emit('edit-disabled');
            },

            commitChanges() {
                if (!this.allowEmpty && this.valueAfterEdit !== '') {
                    this.$emit('input', this.valueAfterEdit);
                    this.disableEditMode();
                }
            },

            discardChanges() {
                this.valueAfterEdit = this.valueBeforeEdit;
                this.disableEditMode();
            }
        }
    }
</script>
