<template>
    <v-app-default-layout>
        <template v-slot:header>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $trans('headings.customer-details') }}</h1>
        </template>

        <template>
            <div class="container mx-auto px-4 sm:px-6 md:px-8 py-4">
                <div class="bg-white shadow overflow-hidden  sm:rounded-lg mb-6">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            {{ $trans('headings.general-information') }}
                        </h3>
                    </div>

                    <div class="px-4 py-5 sm:px-6">
                        <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ $trans('labels.name') }}
                                </dt>

                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    {{ tenant.name }}
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ $trans('labels.status') }}
                                </dt>

                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    <span class="badge badge-green" v-if="tenant.status === 'active'">Active</span>
                                    <span class="badge badge-indigo" v-else-if="tenant.status === 'previous'">Previous</span>
                                    <span class="badge" v-else>No Subscription</span>
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ $trans('labels.email') }}
                                </dt>

                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    {{ tenant.email }}
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ $trans('labels.registered-since') }}
                                </dt>

                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    {{ tenant.registered_since }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="bg-white shadow overflow-hidden  sm:rounded-lg mb-6">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            {{ $trans('headings.billing-information') }}
                        </h3>
                    </div>

                    <div class="px-4 py-5 sm:px-6">
                        <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ $trans('labels.name') }}
                                </dt>

                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    {{ tenant.billing.name }}
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ $trans('labels.phone-number') }}
                                </dt>

                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    <span v-if="tenant.billing.phone">{{ tenant.billing.phone }}</span>
                                    <span v-else>-</span>
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ $trans('labels.address-line1') }}
                                </dt>

                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    <span v-if="tenant.billing.address_line1">{{ tenant.billing.address_line1 }}</span>
                                    <span v-else>-</span>
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ $trans('labels.address-line2') }}
                                </dt>

                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    <span v-if="tenant.billing.address_line2">{{ tenant.billing.address_line2 }}</span>
                                    <span v-else>-</span>
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ $trans('labels.city') }}
                                </dt>

                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    <span v-if="tenant.billing.city">{{ tenant.billing.city }}</span>
                                    <span v-else>-</span>
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ $trans('labels.country') }}
                                </dt>

                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    <span v-if="tenant.billing.city">{{ tenant.billing.country }}</span>
                                    <span v-else>-</span>
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ $trans('labels.state') }}
                                </dt>

                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    <span v-if="tenant.billing.state">{{ tenant.billing.state }}</span>
                                    <span v-else>-</span>
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ $trans('labels.postal-code') }}
                                </dt>

                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    <span v-if="tenant.billing.postal_code">{{ tenant.billing.postal_code }}</span>
                                    <span v-else>-</span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            {{ $trans('headings.usage-details') }}
                        </h3>
                    </div>

                    <div class="px-4 py-5 sm:px-6">
                        <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ $trans('labels.projects') }}
                                </dt>

                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    {{ tenant.projects }}
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ $trans('labels.disk-usage') }}
                                </dt>

                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    <span v-if="tenant.disk_space">{{ tenant.disk_space }} MB</span>
                                    <span v-else>-</span>
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm leading-5 font-medium text-gray-500">
                                    {{ $trans('labels.team-members') }}
                                </dt>

                                <dd class="mt-1 text-sm leading-5 text-gray-900">
                                    {{ tenant.team_members }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            {{ $trans('headings.subscriptions') }}
                        </h3>
                    </div>

                    <div>
                        <v-empty
                            class="pb-6"
                            v-if="tenant.subscriptions.length === 0"
                            :message="$trans('messages.no-data-to-show-here')"
                        />

                        <table v-else class="min-w-full pb-2">
                            <thead>
                            <tr>
                                <th class="pr-6 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ $trans('labels.plan') }}
                                </th>

                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ $trans('labels.trial-end') }}
                                </th>

                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ $trans('labels.ends-at') }}
                                </th>

                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ $trans('labels.status') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="bg-white hover:bg-gray-100 transition duration-150 ease-in-out" v-for="subscription in tenant.subscriptions">
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                    {{ subscription.plan }}
                                </td>

                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                    <span v-if="subscription.trial_ends_at">{{ subscription.trial_ends_at }}</span>
                                    <span v-else>-</span>
                                </td>

                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                    <span v-if="subscription.ends_at">{{ subscription.ends_at }}</span>
                                    <span v-else>-</span>
                                </td>

                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                    <span class="badge badge-green" v-if="subscription.status === 1">{{ $trans('labels.active') }}</span>
                                    <span class="badge badge-yellow" v-else-if="subscription.status === 2">{{ $trans('labels.past-due') }}</span>
                                    <span class="badge" v-else-if="subscription.status === 3">{{ $trans('labels.canceled') }}</span>
                                    <span class="badge badge-red" v-else-if="subscription.status === 4">{{ $trans('labels.incomplete') }}</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </template>
    </v-app-default-layout>
</template>

<script>
    import VAppDefaultLayout from '@/views/back/admin/layouts/default'
    import VEmpty from '@/views/common/empty'

    export default {
        metaInfo() {
            return {
                title: this.$trans('headings.customer-details')
            }
        },

        props: {
            tenant: {
                type: Object,
                required: true
            }
        },

        components: {
            VAppDefaultLayout,
            VEmpty
        }
    }
</script>
