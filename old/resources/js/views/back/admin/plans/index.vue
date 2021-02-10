<template>
    <v-app-default-layout>
        <template v-slot:header>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $trans('headings.plans') }}</h1>
        </template>

        <template>
            <div class="container mx-auto px-4 sm:px-6 md:px-8 py-4">
                <v-alert v-if="$page.flash" show dismissible>{{ $page.flash }}</v-alert>

                <div class="flex justify-end mb-6">
                    <inertia-link :href="route('admin:plans.create')" class="btn btn-indigo">
                        {{ $trans('labels.create-plan') }}
                    </inertia-link>
                </div>

                <div class="flex flex-col">
                    <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                        <div class="align-middle inline-block min-w-full shadow overflow-hidden rounded-lg border-gray-200">
                            <table class="min-w-full">
                                <thead>
                                <tr>
                                    <th class="pl-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>

                                    <th class="pr-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        {{ $trans('labels.name') }}
                                    </th>

                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        {{ $trans('labels.monthly-price') }}
                                    </th>

                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        {{ $trans('labels.status') }}
                                    </th>

                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        {{ $trans('labels.active-subscribers') }}
                                    </th>

                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="bg-white hover:bg-gray-100 transition duration-150 ease-in-out" v-for="plan in $page.plans">
                                    <td class="pl-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                        <svg v-if="plan.is_featured" class="w-3 h-3 text-indigo-500" aria-hidden="true" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                            <path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path>
                                        </svg>
                                    </td>

                                    <td class="pr-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                        {{ plan.name }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                        ${{ plan.price }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                        <span v-if="plan.status === 1">{{ $trans('labels.active') }}</span>
                                        <span v-else>{{ $trans('labels.inactive') }}</span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                        {{ plan.subscriptions }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                        <inertia-link
                                            :href="route('admin:plans.edit', {plan: plan.id})"
                                            class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline"
                                        >
                                            {{ $trans('labels.edit') }}
                                        </inertia-link>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </v-app-default-layout>
</template>

<script>
    import VAppDefaultLayout from '@/views/back/admin/layouts/default'
    import VAlert from '@/components/alert'

    export default {
        metaInfo() {
            return {
                title: this.$trans('headings.plans')
            }
        },

        components: {
            VAppDefaultLayout,
            VAlert
        }
    }
</script>
