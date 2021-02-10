<template>
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <img class="mx-auto h-12 w-auto select-none" :src="$page.logo_light" alt="logo"/>
            <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">{{ $trans('headings.signup-to-get-started') }}</h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow rounded-lg sm:px-10">
                <form action="#" method="POST" @submit.prevent="submit()">
                    <div class="form-group mb-6">
                        <div class="form-group mb-6">
                            <span class="form-label">{{ $trans('labels.business-name') }}</span>
                            <input class="form-input" v-model="form.business_name">
                            <p class="invalid-feedback" v-if="$page.errors.has('business_name')">{{ $page.errors.first('business_name') }}</p>
                        </div>

                        <div class="form-group mb-6">
                            <span class="form-label">{{ $trans('labels.full-name') }}</span>
                            <input class="form-input" v-model="form.name">
                            <p class="invalid-feedback" v-if="$page.errors.has('name')">{{ $page.errors.first('name') }}</p>
                        </div>

                        <span class="form-label">{{ $trans('labels.email') }}</span>
                        <input type="email" class="form-input" v-model="form.email">
                        <p class="invalid-feedback" v-if="$page.errors.has('email')">{{ $page.errors.first('email') }}</p>
                    </div>

                    <div class="form-group mb-6">
                        <span class="form-label">{{ $trans('labels.password') }}</span>
                        <input type="password" class="form-input" v-model="form.password">
                        <p class="invalid-feedback" v-if="$page.errors.has('password')">{{ $page.errors.first('password') }}</p>
                    </div>

                    <div class="form-group mb-6">
                        <span class="form-label">{{ $trans('labels.password-confirmation') }}</span>
                        <input type="password" class="form-input" v-model="form.password_confirmation">
                    </div>

                    <div v-if="$page.terms_and_conditions_published">
                        <div class="flex items-center">
                            <input id="accept_terms" type="checkbox" class="form-checkbox" v-model="form.accepted">
                            <label for="accept_terms" class="form-check-label">
                                {{ $trans('labels.i-accept') }}
                                <a :href="route('terms-and-conditions')" target="_blank" class="inline-flex items-center text-indigo-500 hover:underline">
                                    {{ $trans('labels.terms-and-conditions') }}
                                    <svg class="h-3 w-3 fill-current ml-1 mb-2" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor" d="M432,320H400a16,16,0,0,0-16,16V448H64V128H208a16,16,0,0,0,16-16V80a16,16,0,0,0-16-16H48A48,48,0,0,0,0,112V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48V336A16,16,0,0,0,432,320ZM488,0h-128c-21.37,0-32.05,25.91-17,41l35.73,35.73L135,320.37a24,24,0,0,0,0,34L157.67,377a24,24,0,0,0,34,0L435.28,133.32,471,169c15,15,41,4.5,41-17V24A24,24,0,0,0,488,0Z"></path>
                                    </svg>
                                </a>
                            </label>
                        </div>

                        <p class="invalid-feedback" v-if="$page.errors.has('accepted')">{{ $page.errors.first('accepted') }}</p>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="btn btn-block btn-indigo" :disabled="form.processing">
                            {{ $trans('labels.sign-up') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from '@/utils/form'

    export default {
        metaInfo() {
            return {
                title: this.$trans('headings.sign-up')
            }
        },

        data() {
            return {
                form: new Form({
                    business_name: '',
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    accepted: false
                })
            }
        },

        methods: {
            submit() {
                this.form.processing = true;

                this.$inertia.post(route('register'), this.form.data())
                    .then(() => this.form.processing = false);
            }
        }
    }
</script>
