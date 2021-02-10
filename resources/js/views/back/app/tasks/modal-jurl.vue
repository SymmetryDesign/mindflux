<template>
    <v-modal ref="modal">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="p-6">
                <h3 class="font-medium text-lg">{{ $trans('headings.edit-column') }}</h3>
            </div>

            <div class="p-6">
                <div class="form-group">
                    <label class="form-label">{{ $trans('labels.name') }}</label>
                    <input class="form-input" v-model="form.name" @keydown.enter="submit()">
                    <span class="invalid-feedback" v-if="$page.errors.has('name')">{{ $page.errors.first('name') }}</span>
                </div>
            </div>

            <div class="bg-gray-50 p-4 sm:px-6 sm:py-4 sm:flex sm:flex-row-reverse">
                <button type="button" class="btn btn-indigo" @click="submit()" :disabled="form.processing || form.name === ''">
                    {{ $trans('labels.save-column') }}
                </button>

                <button type="button" class="btn btn-flat mr-3" @click="hide()">
                    {{ $trans('labels.cancel') }}
                </button>
            </div>
        </div>
    </v-modal>
</template>

<script>
    import VModal from '@/components/modal'
    import Form from '@/utils/form'

    export default {
        components: {
            VModal,
        },

        props: {
            uuid: {
                type: String,
                required: true
            },
            name: {
                type: String,
                required: true
            }
        },

        data() {
            return {
                form: new Form({
                    uuid: this.uuid,
                    name: this.name
                })
            }
        },

        methods: {
            show() {
                this.$refs.modal.show();
            },

            hide() {
                this.$refs.modal.hide();
            },

            submit() {
                this.form.processing = true;

                this.$inertia.put(route('app:project.columns.update', {
                    project: this.$page.project.uuid,
                    column: this.form.uuid
                }), {
                    name: this.form.name
                }).then(() => {
                    this.form.processing = false;
                    if (this.$page.errors.none()) {
                        this.hide();
                        this.form.reset();
                    }
                })
            }
        }
    }
</script>
