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
                <h3 class="font-medium text-lg">{{ $trans('headings.complete-payment') }}</h3>
            </div>

            <div class="p-6">
                <v-alert variant="failure" v-if="hasErrors">
                    {{ $trans('messages.processing-payments-failed') }}
                </v-alert>

                <p class="mb-4">
                    {{ $trans('messages.complete-payment-of') }}
                    <span class="font-medium">${{ amount }}</span> {{ $trans('messages.to-activate-the-subscription') }}
                </p>

                <div class="form-input" ref="card"></div>
            </div>

            <div class="bg-gray-50 p-4 sm:px-6 sm:py-4 sm:flex sm:flex-row-reverse">
                <button @click="submit()" type="button" class="btn btn-indigo" :disabled="processing">
                    {{ $trans('labels.pay') }} ${{ amount }}
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
            },
            amount: {
                type: Number,
                required: true
            }
        },

        data() {
            return {
                stripe: null,
                card: null,
                processing: false,
                hasErrors: false
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
                this.processing = true;

                this.stripe
                    .confirmCardPayment(this.token, {
                        payment_method: {
                            type: 'card',
                            card: this.card
                        }
                    })
                    .then(result => {
                        this.processing = false;

                        if (result.error) {
                            this.hasErrors = true;
                        } else {
                            this.$inertia.reload();
                            this.hide();
                        }
                    });
            }
        }
    }
</script>
