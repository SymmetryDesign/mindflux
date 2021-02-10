<template>
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <img class="mx-auto h-12 w-auto select-none" :src="$page.logo_light" alt="logo"/>
            <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">{{ $trans('headings.send-password-reset-link') }}</h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow rounded-lg sm:px-10">
                <v-alert variant="success" show v-if="$page.flash">
                    {{ $page.flash }}
                </v-alert>

                <form action="#" method="POST" @submit.prevent="submit()">
                    <div class="form-group mb-6">
                        <span class="form-label">{{ $trans('labels.email') }}</span>
                        <input type="email" class="form-input" v-model="form.email">
                        <p class="invalid-feedback" v-if="$page.errors.has('email')">{{ $page.errors.first('email') }}</p>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="btn btn-block btn-indigo" :disabled="form.processing">
                            {{ $trans('labels.send-reset-link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from '@/utils/form'
    import VAlert from '@/components/alert'

    export default {
        metaInfo() {
            return {
                title: this.$trans('headings.reset-password')
            }
        },

        components: {
            VAlert
        },

        data() {
            return {
                form: new Form({
                    email: '',
                })
            }
        },

        methods: {
            submit() {
                this.form.processing = true;

                this.$inertia.post(route('password.reminder.send'), this.form.data())
                    .then(() => this.form.processing = false);
            }
        }
    }
</script>
