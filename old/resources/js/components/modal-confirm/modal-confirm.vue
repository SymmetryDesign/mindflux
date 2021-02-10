<template>
    <v-modal ref="modal">
        <div class="mx-auto max-w-lg">
            <div class="flex flex-col rounded-lg bg-white shadow">
                <div class="p-6">
                    <h3 class="font-semibold text-lg">{{ $trans('headings.confirmation') }}</h3>
                </div>

                <div class="p-6">
                    {{ message }}
                </div>

                <div class="p-6 flex justify-end">
                    <button @click="cancel()" class="btn btn-flat mr-3" type="button">{{ $trans('labels.cancel') }}</button>
                    <button :class="['btn-' + confirmButtonColor]" :disabled="processing" @click="confirm()" class="btn" type="button">
                        <span v-if="confirmButtonText">{{ confirmButtonText }}</span>
                        <span v-else>{{ $trans('labels.confirm') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </v-modal>
</template>

<script>
    import VModal from '@/components/modal/modal'

    export default {
        components: {
            VModal
        },
        props: {
            message: {
                type: String,
                required: true
            },
            confirmButtonText: {
                type: String
            },
            confirmButtonColor: {
                type: String,
                default: 'red'
            }
        },
        data() {
            return {
                processing: false,
                resolve: null,
            }
        },
        methods: {
            show() {
                this.$refs.modal.show();
                return new Promise(resolve => {
                    this.resolve = resolve;
                });
            },
            cancel() {
                this.$refs.modal.hide();
            },
            confirm() {
                this.processing = true;
                this.resolve(this.$refs.modal);
            }
        }
    }
</script>
