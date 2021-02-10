<template>
    <v-modal ref="modal">
        <div class="bg-white rounded-lg shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="p-6">
                <h3 class="font-medium text-lg">{{ $trans('headings.add-feature') }}</h3>
            </div>

            <div class="p-6">
                <div class="form-group mb-6">
                    <label class="form-label">{{ $trans('labels.title') }}</label>
                    <input class="form-input" v-model="form.title">
                    <span class="invalid-feedback" v-if="$page.errors.has('title')">{{ $page.errors.first('title') }}</span>
                </div>

                <div class="form-group mb-6">
                    <label class="form-label">{{ $trans('labels.description') }}</label>
                    <textarea class="form-textarea" v-model="form.description" rows="4"></textarea>
                    <span class="invalid-feedback" v-if="$page.errors.has('description')">{{ $page.errors.first('description') }}</span>
                </div>
            </div>

            <div class="bg-gray-50 p-4 sm:px-6 sm:py-4 sm:flex sm:flex-row-reverse rounded-b-lg">
                <button @click="submit()" type="button" class="btn btn-indigo" :disabled="form.processing">
                    {{ $trans('labels.add-feature') }}
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
            VModal
        },

        data() {
            return {
                form: new Form({
                    title: '',
                    description: ''
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

                this.$inertia.post(route('admin:landing-page-features.store'), this.form.data())
                    .then(() => {
                        this.form.processing = false;

                        if (this.$page.errors.none()) {
                            this.hide();
                            this.form.reset();
                        }
                    });
            }
        }
    }
</script>
