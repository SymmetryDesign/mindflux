<template>
    <v-app-default-layout>
        <template v-slot:header>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $trans('headings.customers') }}</h1>
        </template>

        <template>
            <div class="container mx-auto px-4 sm:px-6 md:px-8 py-4">
                <div class="mt-1 flex rounded-md shadow-sm">
                    <div class="relative flex-grow focus-within:z-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 fill-current" viewBox="0 0 20 20">
                                <path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path>
                            </svg>
                        </div>

                        <input class="form-input block w-full rounded-none rounded-l-md pl-10 transition ease-in-out duration-150 sm:text-sm sm:leading-5" :placeholder="$trans('placeholders.search')" v-model="filtersForm.search"/>
                    </div>

                    <v-dropdown>
                        <template v-slot:button>
                            <button class="btn btn-gray leading-6 sm:text-sm sm:leading-5 -ml-px rounded-l-none">
                                <svg class="h-4 w-4 text-gray-400 fill-current" viewBox="0 0 20 20">
                                    <path d="M12 12l8-8V0H0v4l8 8v8l4-4v-4z"></path>
                                </svg>
                                <span class="ml-2">{{ $trans('labels.filters') }}</span>
                            </button>
                        </template>

                        <template v-slot:content>
                            <div class="dropdown-menu p-4">
                                <div class="form-group">
                                    <label class="form-label">{{ $trans('labels.customers') }}</label>
                                    <select class="form-select" v-model="filtersForm.status">
                                        <option :value="null">{{ $trans('labels.all') }}</option>
                                        <option value="active">{{ $trans('labels.active-customers') }}</option>
                                        <option value="previous">{{ $trans('labels.previous-customers') }}</option>
                                    </select>
                                </div>
                            </div>
                        </template>
                    </v-dropdown>
                </div>

                <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 mt-6">
                    <div v-if="$page.tenants.data.length > 0" class="align-middle inline-block min-w-full shadow overflow-hidden rounded-lg border-gray-200">
                        <table class="min-w-full">
                            <thead>
                            <tr>
                                <th class="pr-6 px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ $trans('labels.name') }}
                                </th>

                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ $trans('labels.email') }}
                                </th>

                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ $trans('labels.registered-since') }}
                                </th>

                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ $trans('labels.billing-active') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr
                                @click="showCustomerPage(tenant)"
                                class="bg-white hover:bg-gray-100 transition duration-150 ease-in-out cursor-pointer" v-for="tenant in $page.tenants.data"
                            >
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                    {{ tenant.name }}
                                </td>

                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                    {{ tenant.email }}
                                </td>

                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                    {{ tenant.registered_since }}
                                </td>

                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                    <span class="badge badge-green" v-if="tenant.status === 'active'">{{ $trans('labels.active') }}</span>
                                    <span class="badge badge-indigo" v-else-if="tenant.status === 'previous'">{{ $trans('labels.previous') }}</span>
                                    <span class="badge" v-else>{{ $trans('labels.no-subscription') }}</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <v-pagination :links="$page.tenants.links"></v-pagination>
                    </div>

                    <div v-else class="flex justify-center mt-6">
                        <div class="flex flex-col items-center">
                            <v-empty-view :message="$trans('messages.no-data-to-show-here')"/>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </v-app-default-layout>
</template>

<script>
    import VAppDefaultLayout from '@/views/back/admin/layouts/default'
    import VEmptyView from '@/views/common/empty'
    import VDropdown from '@/components/dropdown'
    import VPagination from '@/components/pagination'

    export default {
        metaInfo() {
            return {
                title: this.$trans('headings.customers')
            }
        },

        props: {
            filters: {
                type: Object
            }
        },

        components: {
            VAppDefaultLayout,
            VEmptyView,
            VDropdown,
            VPagination,
        },

        watch: {
            filtersForm: {
                deep: true,
                handler: _.throttle(function () {
                    let query = _.pickBy(this.filtersForm);
                    this.$inertia.replace(this.route('admin:customers.index', Object.keys(query).length ? query : {remember: 'forget'}))
                }, 150)
            }
        },

        data() {
            return {
                filtersForm: {
                    search: this.filters.search,
                    status: this.filters.status
                }
            }
        },

        methods: {
            showCustomerPage(tenant) {
                window.location.href = route('admin:customers.show', {customer: tenant.id}).url();
            }
        }
    }
</script>
