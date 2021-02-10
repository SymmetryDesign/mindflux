<template>
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <img class="mx-auto h-12 w-auto select-none" :src="$page.logo_light" alt="logo"/>
            <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">{{ $trans('headings.change-password') }}</h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow rounded-lg sm:px-10">
                <form action="#" method="POST" @submit.prevent="submit()">
                    <input :value="form.token" name="token" type="hidden">

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

                    <div class="form-group mb-6">
                        <span class="form-label">{{ $trans('labels.password-confirmation') }}</span>
                        <input type="password" class="form-input" v-model="form.password_confirmation">
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="btn btn-block btn-indigo" :disabled="form.processing">
                            {{ $trans('labels.change-password') }}
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
                title: this.$trans('headings.change-password')
            }
        },

        data() {
            return {
                form: new Form({
                    token: this.$page.token,
                    email: this.$page.email,
                    password: '',
                    password_confirmation: ''
                })
            }
        },

        methods: {
            submit() {
                this.form.processing = true;

                this.$inertia
                    .post(route('password.reset.post'), this.form.data())
                    .then(() => this.form.processing = false);
            }
        }
    }
</script>
