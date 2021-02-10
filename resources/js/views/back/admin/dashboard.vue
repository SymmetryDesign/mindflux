<template>
    <v-app-default-layout>
        <template v-slot:header>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $trans('headings.dashboard') }}</h1>
        </template>

        <template>
            <div class="container mx-auto px-4 sm:px-6 md:px-8 py-4">
                <div class="grid grid-cols-1 gap-6 mt-5 mb-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-white" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor" d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 48c110.532 0 200 89.451 200 200 0 110.532-89.451 200-200 200-110.532 0-200-89.451-200-200 0-110.532 89.451-200 200-200m140.204 130.267l-22.536-22.718c-4.667-4.705-12.265-4.736-16.97-.068L215.346 303.697l-59.792-60.277c-4.667-4.705-12.265-4.736-16.97-.069l-22.719 22.536c-4.705 4.667-4.736 12.265-.068 16.971l90.781 91.516c4.667 4.705 12.265 4.736 16.97.068l172.589-171.204c4.704-4.668 4.734-12.266.067-16.971z"></path>
                                    </svg>
                                </div>

                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                            {{ $trans('headings.active-subscriptions') }}
                                        </dt>

                                        <dd class="flex items-baseline">
                                            <div class="text-2xl leading-8 font-semibold text-gray-900">
                                                {{ $page.stats.active_subscriptions }}
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-white" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm101.8-262.2L295.6 256l62.2 62.2c4.7 4.7 4.7 12.3 0 17l-22.6 22.6c-4.7 4.7-12.3 4.7-17 0L256 295.6l-62.2 62.2c-4.7 4.7-12.3 4.7-17 0l-22.6-22.6c-4.7-4.7-4.7-12.3 0-17l62.2-62.2-62.2-62.2c-4.7-4.7-4.7-12.3 0-17l22.6-22.6c4.7-4.7 12.3-4.7 17 0l62.2 62.2 62.2-62.2c4.7-4.7 12.3-4.7 17 0l22.6 22.6c4.7 4.7 4.7 12.3 0 17z"></path>
                                    </svg>
                                </div>

                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                            {{ $trans('headings.incomplete-subscriptions') }}
                                        </dt>

                                        <dd class="flex items-baseline">
                                            <div class="text-2xl leading-8 font-semibold text-gray-900">
                                                {{ $page.stats.incomplete_subscriptions }}
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>

                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                            {{ $trans('headings.total-customers') }}
                                        </dt>

                                        <dd class="flex items-baseline">
                                            <div class="text-2xl leading-8 font-semibold text-gray-900">
                                                {{ $page.stats.total_customers }}
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>

                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                            {{ $trans('headings.new-customers') }}
                                        </dt>

                                        <dd class="flex items-baseline">
                                            <div class="text-2xl leading-8 font-semibold text-gray-900">
                                                {{ $page.stats.new_customers }}
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 grid grid-cols-1 mb-6">
                    <div class="flex flex-col bg-white rounded-lg shadow">
                        <div class="p-4">
                            <span class="font-semibold text-gray-500">
                                {{ $trans('headings.monthly-customers') }}
                            </span>
                        </div>

                        <div class="p-4">
                            <v-chart-line
                                :data="customersByMonthChart.data"
                                :options="customersByMonthChart.options"
                                :height="400"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </v-app-default-layout>
</template>

<script>
    import VAppDefaultLayout from '@/views/back/admin/layouts/default'
    import VChartLine from '@/components/chart-line'

    export default {
        metaInfo() {
            return {
                title: this.$trans('headings.dashboard')
            }
        },

        components: {
            VAppDefaultLayout,
            VChartLine
        },

        data() {
            return {
                customersByMonthChart: {
                    data: {
                        labels: [
                            this.$trans('labels.jan'), this.$trans('labels.feb'), this.$trans('labels.mar'), this.$trans('labels.apr'),
                            this.$trans('labels.may'), this.$trans('labels.jun'), this.$trans('labels.jul'), this.$trans('labels.aug'),
                            this.$trans('labels.sep'), this.$trans('labels.oct'), this.$trans('labels.nov'), this.$trans('labels.dec')
                        ],
                        datasets: [
                            {
                                backgroundColor: '#b4c6fc',
                                borderColor: '#b4c6fc',
                                pointBackgroundColor: '#fff',
                                data: this.$page.customers_by_month
                            }
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: {
                            display: false
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                },
                                gridLines: {
                                    display: false,
                                }
                            }]
                        }
                    }
                }
            }
        }
    }
</script>
