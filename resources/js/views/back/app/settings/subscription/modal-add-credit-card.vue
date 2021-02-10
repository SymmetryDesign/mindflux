<template>
    <v-modal ref="modal">
        <form class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="hidden sm:block absolute top-0 right-0 pt-6 pr-6">
                <button @click="hide()" type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="flex justify-between p-6">
                <h3 class="font-medium text-lg">{{ $trans('headings.add-credit-card') }}</h3>
            </div>

            <div class="px-6" v-if="hasError">
                <v-alert variant="failure" dismissible>{{ $trans('messages.unable-to-add-credit-card') }}</v-alert>
            </div>

            <div class="px-6">
                <v-alert variant="warning" dismissible>{{ $trans('messages.credit-card-will-not-be-stored') }}</v-alert>
            </div>

            <div class="p-6">
                <div class="form-input" ref="card"></div>
            </div>

            <div class="bg-gray-50 p-4 sm:px-6 sm:py-4 sm:flex sm:flex-row-reverse">
                <button @click="submit()" type="button" class="btn btn-indigo" :disabled="form.processing">
                    {{ $trans('labels.save-credit-card') }}
                </button>

                <button type="button" class="btn btn-flat mr-3" @click="hide()">
                    {{ $trans('labels.cancel') }}
                </button>
            </div>
        </form>
    </v-modal>
</template>

<script>
    import VModal from '@/components/modal'
    import VAlert from '@/components/alert'
    import Form from '@/utils/form'

    export default {
        components: {
            VModal,
            VAlert
        },

        props: {
            token: {
                type: String,
                required: true
            },
            secret: {
                type: String,
                required: true
            }
        },

        data() {
            return {
                stripe: null,
                card: null,
                hasError: false,
                form: new Form({
                    payment_method: null
                })
            }
        },

        created() {
            this.stripe = new Stripe(this.secret);
        },

        methods: {
            show() {
                this.$refs.modal.show();
                this.$nextTick(() => this.setupStripe());
            },

            hide() {
                this.$refs.modal.hide();
            },

            setupStripe() {
                let elements = this.stripe.elements();

                this.card = elements.create('card', {
                    hidePostalCode: true,
                });

                this.card.mount(this.$refs.card);
            },

            submit() {
                this.form.processing = true;

                this.stripe
                    .confirmCardSetup(this.token, {
                        payment_method: {
                            type: 'card',
                            card: this.card
                        }
                    })
                    .then(result => {
                        if (result.error) {
                            this.form.processing = false;
                            this.hasError = true;
                        } else if (result.setupIntent.status === 'succeeded') {
                            this.form.payment_method = result.setupIntent.payment_method;

                            this.$inertia.post(route('app:payment-methods.store'), this.form.data())
                                .then(() => {
                                    this.form.processing = false;
                                    this.hide();
                                });
                        }
                    });
            }
        }
    }
</script>
