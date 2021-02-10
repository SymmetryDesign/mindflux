<template>
    <div class="flex flex-col bg-white rounded-lg shadow mb-6">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ $trans('headings.hero-section') }}
            </h3>
        </div>

        <div class="px-4 py-5 sm:p-6">
            <div class="form-group mb-6">
                <label class="form-label">{{ $trans('labels.hero-heading') }}</label>
                <input class="form-input" v-model="form.hero_heading">
                <span class="invalid-feedback" v-if="$page.errors.has('hero_heading')">{{ $page.errors.first('hero_heading') }}</span>
            </div>

            <div class="form-group mb-6">
                <label class="form-label">{{ $trans('labels.hero-sub-heading') }}</label>
                <input class="form-input" v-model="form.hero_subheading">
                <span class="invalid-feedback" v-if="$page.errors.has('hero_subheading')">{{ $page.errors.first('hero_subheading') }}</span>
            </div>

            <div class="form-group mb-6">
                <label class="form-label">{{ $trans('labels.hero-image') }}</label>
                <v-input-file
                    accept="image/*"
                    v-model="form.hero_image"
                />
                <span class="invalid-feedback" v-if="$page.errors.has('hero_image')">{{ $page.errors.first('hero_image') }}</span>
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
    import VInputFile from '@/components/input-file'
    import Form from '@/utils/form'

    export default {
        components: {
            VInputFile
        },

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
                    hero_heading: this.heading,
                    hero_subheading: this.subheading,
                    hero_image: null
                })
            }
        },

        methods: {
            submit() {
                this.form.processing = true;

                let data = new FormData();
                data.append('hero_heading', this.form.hero_heading);
                data.append('hero_subheading', this.form.hero_subheading);
                data.append('hero_image', this.form.hero_image);
                data.append('_method', 'PUT');

                this.$inertia.post(route('admin:landing-page-hero-settings.update'), data, {preserveState: false})
                    .then(() => this.form.processing = false);
            }
        }
    }
</script>
