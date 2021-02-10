<template>
    <v-modal ref="modal">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div @click="hide()" class="hidden sm:block absolute top-0 right-0 pt-6 pr-6">
                <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
                    <svg stroke="currentColor" fill="none" viewBox="0 0 24 24" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-6">
                <h3 class="font-medium text-lg">{{ $trans('headings.subscription-details') }}</h3>
            </div>

            <div class="p-6">
                <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            {{ $trans('labels.id') }}
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900">
                            <span v-if="subscription">{{ subscription.id }}</span>
                            <span v-else>-</span>
                        </dd>
                    </div>

                    <div class="sm:col-span-1">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            {{ $trans('labels.customer') }}
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900">
                            <span v-if="subscription">{{ subscription.customer_name }}</span>
                            <span v-else>-</span>
                        </dd>
                    </div>

                    <div class="sm:col-span-1">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            {{ $trans('labels.plan') }}
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900">
                            <span v-if="subscription">{{ subscription.plan }}</span>
                            <span v-else>-</span>
                        </dd>
                    </div>

                    <div class="sm:col-span-1">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            {{ $trans('labels.status') }}
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900">
                            <span class="badge badge-green" v-if="subscription && subscription.status === 1">{{ $trans('labels.active') }}</span>
                            <span class="badge badge-yellow" v-else-if="subscription && subscription.status === 2">{{ $trans('labels.past-due') }}</span>
                            <span class="badge" v-else-if="subscription && subscription.status === 3">{{ $trans('labels.canceled') }}</span>
                            <span class="badge badge-red" v-else-if=" subscription &&subscription.status === 4">{{ $trans('labels.incomplete') }}</span>
                            <span v-else>-</span>
                        </dd>
                    </div>

                    <div class="sm:col-span-1">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            {{ $trans('labels.next-billing-cycle') }}
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900">
                            <span v-if="subscription">{{ subscription.next_billing_cycle }}</span>
                            <span v-else>-</span>
                        </dd>
                    </div>

                    <div class="sm:col-span-1">
                        <dt class="text-sm leading-5 font-medium text-gray-500">
                            {{ $trans('labels.latest-payment') }}
                        </dt>
                        <dd class="mt-1 text-sm leading-5 text-gray-900">
                            <span v-if="subscription">${{ subscription.latest_payment }}</span>
                            <span v-else>-</span>
                        </dd>
                    </div>
                </dl>

                <div class="mt-10">
                    <a v-if="subscription" :href="subscription.link" class="btn btn-block btn-indigo" target="_blank">
                        {{ $trans('labels.more-details') }}
                    </a>
                </div>
            </div>
        </div>
    </v-modal>
</template>

<script>
    import VModal from '@/components/modal'

    export default {
        components: {
            VModal,
        },

        props: {
            subscriptionId: {
                type: Number,
                required: true
            }
        },

        data() {
            return {
                subscription: null
            }
        },

        methods: {
            show() {
                axios.get(route('admin:subscriptions.show', {subscription: this.subscriptionId}))
                    .then(response => {
                        this.subscription = response.data;
                    });

                this.$refs.modal.show();
            },

            hide() {
                this.$refs.modal.hide();
            }
        }
    }
</script>
