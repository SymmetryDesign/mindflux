<template>
    <v-app-default-layout>
        <template v-slot:header>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $trans('headings.dashboard') }}</h1>
        </template>

        <template>
            <div class="container mx-auto px-4 sm:px-6 md:px-8 py-4">
                <div class="mt-5 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-6">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-500 rounded-md text-white p-3">
                                    <svg class="h-6 w-6 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 1l10 6-10 6L0 7l10-6zm6.67 10L20 13l-10 6-10-6 3.33-2L10 15l6.67-4z"></path>
                                    </svg>
                                </div>

                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                            {{ $trans('headings.total-projects') }}
                                        </dt>

                                        <dd class="flex items-baseline">
                                            <div class="text-2xl leading-8 font-semibold text-gray-900">
                                                {{ $page.stats.projects }}
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-4 sm:px-6">
                            <div class="text-sm leading-5">
                                <inertia-link :href="route('app:projects.index')" class="font-medium text-indigo-600 hover:text-indigo-500 transition ease-in-out duration-150">
                                    {{ $trans('labels.view-all') }}
                                </inertia-link>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-500 text-white rounded-md p-3">
                                    <svg class="h-6 w-6 fill-current" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor" d="M48 48a48 48 0 1 0 48 48 48 48 0 0 0-48-48zm0 160a48 48 0 1 0 48 48 48 48 0 0 0-48-48zm0 160a48 48 0 1 0 48 48 48 48 0 0 0-48-48zm448 16H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-320H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16zm0 160H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z"></path>
                                    </svg>
                                </div>

                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                            {{ $trans('headings.total-tasks') }}
                                        </dt>

                                        <dd class="flex items-baseline">
                                            <div class="text-2xl leading-8 font-semibold text-gray-900">
                                                {{ $page.stats.total_tasks }}
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-4 sm:px-6">
                            <div class="text-sm leading-5">
                                <inertia-link :href="route('app:tasks.index')" class="font-medium text-indigo-600 hover:text-indigo-500 transition ease-in-out duration-150">
                                    {{ $trans('labels.view-all') }}
                                </inertia-link>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-500 text-white rounded-md p-3">
                                    <svg class="h-6 w-6 fill-current" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm61.8-104.4l-84.9-61.7c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v141.7l66.8 48.6c5.4 3.9 6.5 11.4 2.6 16.8L334.6 349c-3.9 5.3-11.4 6.5-16.8 2.6z"></path>
                                    </svg>
                                </div>

                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                            {{ $trans('headings.open-tasks') }}
                                        </dt>

                                        <dd class="flex items-baseline">
                                            <div class="text-2xl leading-8 font-semibold text-gray-900">
                                                {{ $page.stats.open_tasks }}
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-4 sm:px-6">
                            <div class="text-sm leading-5">
                                <inertia-link :href="route('app:tasks.index')" class="font-medium text-indigo-600 hover:text-indigo-500 transition ease-in-out duration-150">
                                    {{ $trans('labels.view-all') }}
                                </inertia-link>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-500 text-white rounded-md p-3">
                                    <svg class="h-6 w-6 text-white" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor" d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 48c110.532 0 200 89.451 200 200 0 110.532-89.451 200-200 200-110.532 0-200-89.451-200-200 0-110.532 89.451-200 200-200m140.204 130.267l-22.536-22.718c-4.667-4.705-12.265-4.736-16.97-.068L215.346 303.697l-59.792-60.277c-4.667-4.705-12.265-4.736-16.97-.069l-22.719 22.536c-4.705 4.667-4.736 12.265-.068 16.971l90.781 91.516c4.667 4.705 12.265 4.736 16.97.068l172.589-171.204c4.704-4.668 4.734-12.266.067-16.971z"></path>
                                    </svg>
                                </div>

                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                            {{ $trans('headings.completed-tasks') }}
                                        </dt>

                                        <dd class="flex items-baseline">
                                            <div class="text-2xl leading-8 font-semibold text-gray-900">
                                                {{ $page.stats.completed_tasks }}
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-4 sm:px-6">
                            <div class="text-sm leading-5">
                                <inertia-link :href="route('app:tasks.index', {filter: 'completed'})" class="font-medium text-indigo-600 hover:text-indigo-500 transition ease-in-out duration-150">
                                    {{ $trans('labels.view-all') }}
                                </inertia-link>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="flex flex-col bg-white rounded-lg shadow">
                        <div class="p-4">
                            <div class="font-semibold">
                                {{ $trans('headings.most-productive-month-was') }}
                                <span class="border-b-2 border-indigo-300" v-if="$page.tasks_by_month_count > 0">{{ $page.most_productive_month }}</span>
                                <span v-else>-</span>
                            </div>
                        </div>

                        <div class="p-4">
                            <v-chart-line
                                :data="productiveMonthChart.data"
                                :height="400"
                                :options="productiveMonthChart.options"
                            />
                        </div>
                    </div>

                    <div class="flex flex-col bg-white rounded-lg shadow">
                        <div class="p-4">
                            <span class="font-semibold">
                                {{ $trans('headings.you-accomplished-the-most-on') }}
                                <span class="border-b-2 border-indigo-300" v-if="$page.tasks_by_day_count > 0">{{ $page.most_productive_day }}</span>
                                <span v-else>-</span>
                            </span>
                        </div>

                        <div class="p-4">
                            <v-chart-line
                                :data="productiveDayChart.data"
                                :height="400"
                                :options="productiveDayChart.options"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </v-app-default-layout>
</template>

<script>
    import VAppDefaultLayout from '@/views/back/app/layouts/default'
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

        mounted() {

        },

        data() {
            return {
                productiveMonthChart: {
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
                                data: this.$page.tasks_by_month
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
                },
                productiveDayChart: {
                    data: {
                        labels: [
                            this.$trans('labels.sun'), this.$trans('labels.mon'), this.$trans('labels.tue'),
                            this.$trans('labels.wed'), this.$trans('labels.thu'), this.$trans('labels.fri'),
                            this.$trans('labels.sat'),
                        ],
                        datasets: [
                            {
                                backgroundColor: '#b4c6fc',
                                borderColor: '#b4c6fc',
                                pointBackgroundColor: '#fff',
                                data: this.$page.tasks_by_day
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
