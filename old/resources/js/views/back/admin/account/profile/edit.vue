<template>
    <v-app-default-layout>
        <template v-slot:header>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $trans('headings.edit-profile') }}</h1>
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

                        <div class="flex flex-col w-full bg-white rounded-lg shadow mb-6">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    {{ $trans('headings.edit-profile') }}
                                </h3>
                            </div>

                            <div class="px-4 py-5 sm:p-6">
                                <div class="form-group mb-6">
                                    <label class="form-label">{{ $trans('labels.name') }}</label>
                                    <input class="form-input" v-model="form.name">
                                    <span class="invalid-feedback" v-if="$page.errors.has('name')">{{ $page.errors.first('name') }}</span>
                                </div>

                                <div class="form-group mb-6">
                                    <label class="form-label">{{ $trans('labels.email') }}</label>
                                    <input type="email" class="form-input" v-model="form.email">
                                    <span class="invalid-feedback" v-if="$page.errors.has('email')">{{ $page.errors.first('email') }}</span>
                                </div>

                                <div class="form-group mb-6">
                                    <label class="form-label">{{ $trans('labels.profile-picture') }}</label>
                                    <v-input-file
                                        accept="image/*"
                                        v-model="form.profile_picture"
                                    />
                                    <span class="invalid-feedback" v-if="$page.errors.has('profile_picture')">{{ $page.errors.first('profile_picture') }}</span>
                                </div>
                            </div>

                            <div class="bg-gray-50 text-right rounded-b-lg px-4 py-5 sm:p-6">
                                <button @click="submit()" type="button" class="btn btn-indigo" :disabled="form.processing">
                                    {{ $trans('labels.save-changes') }}
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
    import VNavMenu from '@/views/back/admin/account/nav-menu'
    import VAlert from '@/components/alert'
    import VInputFile from '@/components/input-file'
    import Form from '@/utils/form'

    export default {
        metaInfo() {
            return {
                title: this.$trans('headings.edit-profile')
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
                    name: this.$page.user.name,
                    email: this.$page.user.email,
                    profile_picture: null
                })
            }
        },

        methods: {
            submit() {
                this.form.processing = true;

                let data = new FormData();
                data.append('name', this.form.name);
                data.append('email', this.form.email);
                data.append('profile_picture', this.form.profile_picture);
                data.append('_method', 'PUT');

                this.$inertia.post(route('admin:profile.update'), data)
                    .then(() => this.form.processing = false);
            }
        }
    }
</script>
