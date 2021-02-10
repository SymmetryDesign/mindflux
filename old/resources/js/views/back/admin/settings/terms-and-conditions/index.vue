<template>
    <v-app-default-layout>
        <template v-slot:header>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $trans('headings.terms-and-conditions') }}</h1>
        </template>

        <template>
            <div class="container mx-auto px-4 sm:px-6 md:px-8 py-4">
                <div class="md:grid md:gap-6 md:grid-cols-8">
                    <div class="mb-6 sm:col-span-2">
                        <v-nav-menu/>
                    </div>

                    <div class="md:col-span-6">
                        <v-alert variant="failure" v-if="$page.errors.has('demo.restrict')" dismissible>
                            {{ $page.errors.first('demo.restrict') }}
                        </v-alert>

                        <v-alert v-if="$page.flash" dismissible>{{ $page.flash }}</v-alert>

                        <div class="bg-white shadow rounded-lg">
                            <div class="px-4 py-5 sm:px-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    {{ $trans('headings.terms-and-conditions') }}
                                </h3>

                                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                                    {{ $trans('headings.subtexts.terms-and-conditions-description') }}
                                </p>
                            </div>

                            <div class="px-4 py-5 sm:px-6">
                                <div class="form-group mb-6">
                                    <div class="flex items-start">
                                        <div class="absolute flex items-center h-5">
                                            <input id="published" type="checkbox" class="form-checkbox" v-model="form.published">
                                        </div>

                                        <div class="pl-7 text-sm leading-5">
                                            <label for="published" class="font-medium text-gray-700">{{ $trans('labels.publish-terms-and-conditions') }}</label>
                                            <p class="text-gray-500">{{ $trans('labels.subtexts.publish-terms-and-conditions-warning') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <v-wysiwyg-editor v-model="form.content"/>
                            </div>

                            <div class="bg-gray-50 text-right rounded-b-lg px-4 py-5 sm:p-6">
                                <button @click="submit()" type="button" class="btn btn-indigo" :disabled="form.processing">
                                    {{ $trans('labels.save-settings') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </v-app-default-layout>
</template>

<script>
    import VAppDefaultLayout from '@/views/back/admin/layouts/default'
    import VNavMenu from '@/views/back/admin/settings/nav-menu'
    import VAlert from '@/components/alert'
    import VWysiwygEditor from '@/components/wysiwyg-editor'
    import Form from '@/utils/form'

    export default {
        metaInfo() {
            return {
                title: this.$trans('terms-and-conditions')
            }
        },

        components: {
            VAppDefaultLayout,
            VNavMenu,
            VAlert,
            VWysiwygEditor
        },

        data() {
            return {
                form: new Form({
                    content: this.$page.terms_and_conditions,
                    published: this.$page.published,
                })
            }
        },

        methods: {
            submit() {
                this.form.processing = true;

                this.$inertia.put(route('admin:terms-and-conditions.update'), this.form.data())
                    .then(() => this.form.processing = false);
            }
        }
    }
</script>
