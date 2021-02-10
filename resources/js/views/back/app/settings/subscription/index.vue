<template>
    <v-app-default-layout>
        <template v-slot:header>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $trans('headings.subscription') }}</h1>
        </template>

        <template>
            <div class="container mx-auto px-4 sm:px-6 md:px-8 py-4">
                <div class="sm:grid sm:grid-cols-8 sm:gap-6">
                    <div class="sm:col-span-2 mb-6">
                        <v-nav-menu/>
                    </div>

                    <div class="sm:col-span-6">
                        <v-alert v-if="$page.flash" dismissible>{{ $page.flash }}</v-alert>

                        <v-alert variant="failure" v-if="$page.errors.any()" dismissible>
                            {{ $page.errors.first('demo.restrict') }}
                        </v-alert>

                        <v-alert variant="warning" v-if="$page.subscription.incomplete">
                            {{ $trans('messages.unable-to-activate-subscription') }}. {{ $trans('labels.please') }}
                            <a @click.prevent="showCompletePaymentModal()" class="font-medium underline" href="#">
                                {{ $trans('labels.click-here') }}
                            </a> {{ $trans('labels.continue-processing-payment') }}.
                        </v-alert>

                        <div class="bg-white shadow overflow-hidden rounded-lg mb-6">
                            <div class="px-4 py-5 sm:px-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    {{ $trans('headings.plan-details') }}
                                </h3>

                                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                                    {{ $trans('headings.subtexts.plan-details') }}
                                </p>
                            </div>

                            <div>
                                <dl>
                                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm leading-5 font-medium text-gray-500">
                                            {{ $trans('labels.current-plan') }}
                                        </dt>

                                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                            <span v-if="$page.subscription.plan.name">{{ $page.subscription.plan.name }}</span>
                                            <span v-else>-</span>
                                        </dd>
                                    </div>

                                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm leading-5 font-medium text-gray-500">
                                            {{ $trans('labels.ends-at') }}
                                        </dt>

                                        <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                            <span v-if="$page.subscription.ends_at">{{ $page.subscription.ends_at }}</span>
                                            <span v-else>-</span>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <div class="bg-white shadow rounded-lg mb-6">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    {{ $trans('headings.payment-methods') }}
                                </h3>

                                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                                    {{ $trans('headings.subtexts.payment-methods') }}
                                </p>
                            </div>

                            <div class="px-4 sm:px-6 pb-6">
                                <template v-for="paymentMethod in $page.paymentMethods">
                                    <v-card-payment-method-credit-card
                                        :key="paymentMethod.token"
                                        :token="paymentMethod.token"
                                        :last-four="paymentMethod.last4"
                                        :exp-month="paymentMethod.expMonth"
                                        :exp-year="paymentMethod.expYear"
                                        :is-default="paymentMethod.default"
                                        :brand="paymentMethod.brand"
                                        @delete-payment-method="showDeletePaymentMethodModal"
                                        @set-default="showSetDefaultPaymentMethodModal"
                                        v-if="paymentMethod.type === 'card'"
                                    />
                                </template>

                                <a @click.prevent="showAddPaymentMethodModal()" href="#" class="flex items-center justify-center text-sm rounded-lg border-2 border-dotted py-4 hover:border-gray-400 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M11 9h4v2h-4v4H9v-4H5V9h4V5h2v4zm-1 11a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"/>
                                    </svg>

                                    {{ $trans('labels.add-payment-method') }}
                                </a>
                            </div>
                        </div>

                        <div class="bg-white shadow rounded-lg mb-6">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    {{ $trans('headings.subscription-plans') }}
                                </h3>

                                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                                    {{ $trans('headings.subtexts.subscription-plans') }}
                                </p>
                            </div>

                            <div class="px-4 sm:px-6 pb-6" v-for="plan in $page.plans">
                                <div class="rounded-md bg-gray-50 px-6 py-5 sm:flex sm:items-start sm:justify-between">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mt-3 sm:mt-0">
                                            <div class="text-sm leading-5 font-medium text-gray-900">
                                                {{ plan.name }}
                                            </div>

                                            <div class="mt-1 text-sm leading-5 text-gray-600 sm:flex sm:items-center">
                                                <div>
                                                    ${{ plan.price }}/mo
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 sm:mt-0 sm:ml-6 sm:flex-shrink-0">
                                        <button
                                            @click="$page.paymentMethods.length > 0 ? showSwitchPlanModal(plan) : showAddPaymentMethodModal()"
                                            type="button"
                                            class="btn btn-indigo"
                                            v-if="$page.subscription.plan.id !== plan.id"
                                        >
                                            {{ $trans('labels.switch-plan') }}
                                        </button>

                                        <button @click="showCancelSubscriptionModal(plan)" type="button" class="btn btn-link text-red-600" v-else>
                                            {{ $trans('labels.cancel-subscription') }}
                                        </button>
                                    </div>
                                </div>
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
    import VNavMenu from '@/views/back/app/settings/nav-menu'
    import VAlert from '@/components/alert'
    import VCardPaymentMethodCreditCard from '@/views/back/app/settings/subscription/card-payment-method-creditcard'
    import VAddCreditCardModal from '@/views/back/app/settings/subscription/modal-add-credit-card'
    import VCompletePaymentModal from '@/views/back/app/settings/subscription/modal-complete-payment'

    export default {
        metaInfo() {
            return {
                title: this.$trans('headings.subscription')
            }
        },

        components: {
            VAppDefaultLayout,
            VNavMenu,
            VAlert,
            VCardPaymentMethodCreditCard
        },

        methods: {
            showAddPaymentMethodModal() {
                if (this.$page.gateway === 'stripe') {
                    this.$modal(VAddCreditCardModal, {
                        token: this.$page.token,
                        secret: this.$page.stripe_publishable_key
                    });
                }
            },

            showDeletePaymentMethodModal(token) {
                this.$confirm(this.$trans('messages.delete-this-payment-method'), {
                    confirmButtonText: this.$trans('labels.cancel-and-delete')
                }).then(modal => {
                    this.$inertia.delete(route('app:payment-methods.destroy', {payment_method: token}))
                        .then(() => {
                            modal.hide();
                        });
                })
            },

            showSetDefaultPaymentMethodModal(paymentMethod) {
                this.$confirm(this.$trans('messages.set-default-payment-method'), {
                    confirmButtonColor: 'indigo'
                }).then(modal => {
                    this.$inertia.put(route('app:payment-methods.update', {payment_method: paymentMethod}))
                        .then(() => {
                            modal.hide();
                        });
                })
            },

            showSwitchPlanModal(plan) {
                this.$confirm(this.$trans('messages.switch-to-plan', {plan: plan.name}), {
                    confirmButtonColor: 'indigo'
                }).then(modal => {
                    this.$inertia.post(route('app:subscription.store'), {plan: plan.id}, {
                        replace: true,
                        preserveState: false
                    })
                        .then(() => {
                            modal.hide();
                        });
                })
            },

            showCancelSubscriptionModal() {
                this.$confirm(`Do you want to cancel current subscription?`, {
                    confirmButtonText: 'Cancel Subscription'
                }).then(modal => {
                    this.$inertia.delete(route('app:subscription.destroy'), null, {
                        replace: true,
                        preserveState: false
                    })
                        .then(() => {
                            modal.hide();
                        });
                })
            },

            showCompletePaymentModal() {
                this.$modal(VCompletePaymentModal, {
                    token: this.$page.subscription.latest_payment.client_secret,
                    secret: this.$page.stripe_publishable_key,
                    amount: this.$page.subscription.latest_payment.amount,
                })
            }
        }
    }
</script>
