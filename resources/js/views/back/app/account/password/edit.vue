<template>
    <v-app-default-layout>
        <template v-slot:header>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $trans('headings.change-password') }}</h1>
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

                        <div class="flex flex-col bg-white rounded-lg shadow mb-6">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    {{ $trans('headings.change-password') }}
                                </h3>
                            </div>

                            <div class="px-4 py-5 sm:p-6">
                                <div class="form-group mb-6">
                                    <label class="form-label">{{ $trans('labels.password') }}</label>
                                    <input type="password" class="form-input" v-model="form.password">
                                    <span class="invalid-feedback" v-if="$page.errors.has('password')">{{ $page.errors.first('password') }}</span>
                                </div>

                                <div class="form-group mb-6">
                                    <label class="form-label">{{ $trans('labels.password-confirmation') }}</label>
                                    <input type="password" class="form-input" v-model="form.password_confirmation">
                                    <span class="invalid-feedback" v-if="$page.errors.has('password_confirmation')">{{ $page.errors.first('password_confirmation') }}</span>
                                </div>
                            </div>

                            <div class="bg-gray-50 text-right rounded-b-lg px-4 py-5 sm:p-6">
                                <button @click="submit()" type="button" class="btn btn-indigo" :disabled="form.processing">
                                    {{ $trans('labels.change-password') }}
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
    import VAppDefaultLayout from '@/views/back/app/layouts/default'
    import VNavMenu from '@/views/back/app/account/nav-menu'
    import VAlert from '@/components/alert'
    import Form from '@/utils/form'

    export default {
        metaInfo() {
            return {
                title: this.$trans('headings.change-password')
            }
        },

        components: {
            VAppDefaultLayout,
            VNavMenu,
            VAlert,
        },

        data() {
            return {
                form: new Form({
                    password: this.$page.user.password,
                    password_confirmation: this.$page.user.password_confirmation
                })
            }
        },

        methods: {
            submit() {
                this.form.processing = true;

                this.$inertia.put(route('app:password.update'), this.form.data())
                    .then(() => {
                        this.form.processing = false;
                        this.form.reset();
                    });
            }
        }
    }
</script>
