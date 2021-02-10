<template>
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <img class="mx-auto h-12 w-auto select-none" :src="$page.logo_light" alt="logo"/>
            <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">{{ $trans('headings.signin-to-your-account') }}</h2>

            <p class="mt-2 text-center text-sm leading-5 text-gray-600 max-w">
                {{ $trans('labels.or') }}
                <inertia-link :href="route('register')" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                    {{ $trans('labels.create-new-account') }}
                </inertia-link>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow rounded-lg sm:px-10">
                <form action="#" method="POST" @submit.prevent="submit()">
                    <div class="form-group mb-6">
                        <span class="form-label">{{ $trans('labels.email') }}</span>
                        <input type="email" class="form-input" v-model="form.email">
                        <p class="invalid-feedback" v-if="$page.errors.has('email')">{{ $page.errors.first('email') }}</p>
                    </div>

                    <div class="form-group mb-6">
                        <span class="form-label">{{ $trans('labels.password') }}</span>
                        <input type="password" class="form-input" v-model="form.password">
                        <p class="invalid-feedback" v-if="$page.errors.has('password')">{{ $page.errors.first('password') }}</p>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" v-model="form.remember"/>
                            <label for="remember" class="ml-2 block text-sm leading-5 text-gray-900">
                                {{ $trans('labels.remember-me') }}
                            </label>
                        </div>

                        <div class="text-sm leading-5">
                            <inertia-link
                                :href="route('password.reminder')"
                                class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150"
                            >
                                {{ $trans('labels.forgot-your-password') }}
                            </inertia-link>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="btn btn-block btn-indigo" :disabled="form.processing">
                            {{ $trans('labels.sign-in') }}
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
                title: this.$trans('headings.sign-in')
            }
        },

        data() {
            return {
                form: new Form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form.processing = true;

                this.$inertia.post(route('login'), this.form.data())
                    .then(() => this.form.processing = false);
            }
        }
    }
</script>
