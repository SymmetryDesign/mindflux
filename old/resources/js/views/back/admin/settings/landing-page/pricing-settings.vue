<template>
    <div class="flex flex-col bg-white rounded-lg shadow mb-6">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ $trans('headings.pricing-section') }}
            </h3>
        </div>

        <div class="px-4 py-5 sm:p-6">
            <div class="form-group mb-6">
                <label class="form-label">{{ $trans('labels.pricing-heading') }}</label>
                <input class="form-input" v-model="form.pricing_heading">
                <span class="invalid-feedback" v-if="$page.errors.has('pricing_heading')">{{ $page.errors.first('pricing_heading') }}</span>
            </div>

            <div class="form-group mb-6">
                <label class="form-label">{{ $trans('labels.pricing-sub-heading') }}</label>
                <input class="form-input" v-model="form.pricing_subheading">
                <span class="invalid-feedback" v-if="$page.errors.has('pricing_subheading')">{{ $page.errors.first('pricing_subheading') }}</span>
            </div>
        </div>

        <div class="bg-gray-50 text-right rounded-b-lg px-4 py-5 sm:p-6">
            <button @click="submit()" type="button" class="btn btn-indigo" :disabled="form.processing">
                {{ $trans('labels.save-settings') }}
            </button>
        </div>
    </div>
</template>

<script>
    import Form from '@/utils/form'

    export default {
        props: {
            heading: {
                type: String,
                default: null
            },
            subheading: {
                type: String,
                default: null
            }
        },

        data() {
            return {
                form: new Form({
                    pricing_heading: this.heading,
                    pricing_subheading: this.subheading
                })
            }
        },

        methods: {
            submit() {
                this.form.processing = true;

                this.$inertia.put(route('admin:landing-page-pricing-settings.update'), this.form.data(), {preserveState: false})
                    .then(() => this.form.processing = false);
            }
        }
    }
</script>
