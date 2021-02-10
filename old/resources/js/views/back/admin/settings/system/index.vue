<template>
    <v-app-default-layout>
        <template v-slot:header>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $trans('headings.system-settings') }}</h1>
        </template>

        <template>
            <div class="container mx-auto px-4 sm:px-6 md:px-8 py-4">
                <div class="md:grid md:gap-6 md:grid-cols-8">
                    <div class="mb-6 sm:col-span-2">
                        <v-nav-menu/>
                    </div>

                    <div class="md:col-span-6">
                        <v-alert v-if="$page.flash" dismissible>
                            {{ $page.flash }}
                        </v-alert>

                        <v-alert variant="failure" v-if="$page.errors.has('demo.restrict')" dismissible>
                            {{ $page.errors.first('demo.restrict') }}
                        </v-alert>

                        <div class="flex flex-col bg-white rounded-lg shadow">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    {{ $trans('headings.system-settings') }}
                                </h3>
                            </div>

                            <div class="px-4 py-5 sm:p-6">
                                <div class="form-group mb-6">
                                    <label class="form-label">{{ $trans('labels.logo-light') }}</label>
                                    <v-input-file
                                        accept="image/*"
                                        v-model="form.logo_light"
                                    />
                                    <span class="invalid-feedback" v-if="$page.errors.has('logo_light')">
                                        {{ $page.errors.first('logo_light') }}
                                    </span>
                                </div>

                                <div class="form-group mb-6">
                                    <label class="form-label">{{ $trans('labels.logo-dark') }}</label>
                                    <v-input-file
                                        accept="image/*"
                                        v-model="form.logo_dark"
                                    />
                                    <span class="invalid-feedback" v-if="$page.errors.has('logo_dark')">
                                        {{ $page.errors.first('logo_dark') }}
                                    </span>
                                </div>

                                <div class="form-group mb-6">
                                    <label class="form-label">{{ $trans('labels.favicon') }}</label>
                                    <v-input-file
                                        accept="image/*"
                                        v-model="form.favicon"
                                    />
                                    <span class="invalid-feedback" v-if="$page.errors.has('favicon')">
                                        {{ $page.errors.first('favicon') }}
                                    </span>
                                </div>

                                <div class="form-group mb-6">
                                    <label class="form-label">{{ $trans('labels.default-language') }}</label>
                                    <select class="form-select" v-model="form.locale">
                                        <option :value="language.code" v-for="language in $page.languages">
                                            {{ language.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="bg-gray-50 text-right rounded-b-lg px-4 py-5 sm:p-6">
                                <button @click="submit" type="button" class="btn btn-indigo" :disabled="form.processing">
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
    import VInputFile from '@/components/input-file'
    import VAlert from '@/components/alert'
    import Form from '@/utils/form'

    export default {
        metaInfo() {
            return {
                title: this.$trans('headings.system-settings')
            }
        },

        components: {
            VAppDefaultLayout,
            VNavMenu,
            VAlert,
            VInputFile
        },

        data() {
            return {
                form: new Form({
                    logo_light: null,
                    logo_dark: null,
                    favicon: null,
                    locale: this.$page.locale,
                })
            }
        },

        methods: {
            submit() {
                this.form.processing = true;

                let data = new FormData();

                data.append('logo_light', this.form.logo_light);
                data.append('logo_dark', this.form.logo_dark);
                data.append('favicon', this.form.favicon);
                data.append('locale', this.form.locale);
                data.append('_method', 'put');

                this.$inertia.post(route('admin:system-setings.update'), data)
                    .then(() => {
                        this.form.processing = false;
                    });
            }
        }
    }
</script>
