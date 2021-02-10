<template>
    <v-app-default-layout>
        <template v-slot:header>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $trans('headings.projects') }}</h1>
        </template>

        <template>
            <div class="container mx-auto flex flex-col flex-1 px-4 sm:px-6 md:px-8 py-4">
                <v-alert v-if="$page.flash" dismissible>{{ $page.flash }}</v-alert>

                <div class="flex flex-col sm:flex-row flex-col-reverse items-center justify-between mb-6">
                    <div class="w-full sm:w-1/2">
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <div class="relative flex-grow focus-within:z-10">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path>
                                    </svg>
                                </div>

                                <input
                                    class="form-input block w-full rounded-none rounded-l-md pl-10 transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                    :placeholder="$trans('placeholders.search')"
                                    v-model="filtersForm.search"
                                />
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
                                        <div class="form-group mb-6">
                                            <label class="form-label">{{ $trans('labels.status') }}</label>
                                            <select class="form-select" v-model="filtersForm.status">
                                                <option :value="null">{{ $trans('labels.all') }}</option>
                                                <option value="ongoing">{{ $trans('labels.ongoing') }}</option>
                                                <option value="overdue">{{ $trans('labels.overdue') }}</option>
                                                <option value="completed">{{ $trans('labels.completed') }}</option>
                                                <option value="archived">{{ $trans('labels.archived') }}</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">{{ $trans('labels.visibility') }}</label>
                                            <select class="form-select" v-model="filtersForm.visibility">
                                                <option :value="null">{{ $trans('labels.all') }}</option>
                                                <option value="only_me">{{ $trans('labels.only-me') }}</option>
                                                <option value="team_members">{{ $trans('labels.team-members') }}</option>
                                                <option value="organization">{{ $trans('labels.organization') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </template>
                            </v-dropdown>
                        </div>
                    </div>

                    <div class="flex items-center justify-end w-full mb-4 sm:mb-0 sm:w-1/2 -mx-2">
                        <div class="px-0 sm:px-2">
                            <button class="btn btn-indigo" @click="showCreateProjectModal()">
                                {{ $trans('labels.create-project') }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow overflow-hidden rounded-md" v-if="$page.projects.data.length">
                    <ul>
                        <li class="border-b border-gray-100 last:border-0" v-for="project in $page.projects.data">
                            <inertia-link :href="route('app:projects.show', project.uuid)" class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                                <div class="px-6 py-4 flex items-center">
                                    <div class="min-w-0 flex-1 md:grid md:grid-cols-8 md:gap-4">
                                        <div class="md:col-span-4">
                                            <div>
                                                <div class="text-sm leading-5 font-medium text-indigo-600 truncate">
                                                    {{ project.name }}
                                                </div>

                                                <div class="mt-2 flex">
                                                    <div class="flex items-center text-sm leading-5 text-gray-500 truncate">
                                                        <span>{{ project.description }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-2 md:col-span-2 sm:mt-0">
                                            <div>
                                                <div class="flex items-center text-sm leading-5 text-gray-500">
                                                    <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400 fill-current" viewBox="0 0 20 20">
                                                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM6.7 9.29L9 11.6l4.3-4.3 1.4 1.42L9 14.4l-3.7-3.7 1.4-1.42z"></path>
                                                    </svg>

                                                    <span class="font-medium">{{ project.pending_tasks }}</span>&nbsp;{{ $trans('labels.tasks-left') }}
                                                </div>

                                                <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                                                    <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400 fill-current" viewBox="0 0 20 20">
                                                        <path d="M1 4c0-1.1.9-2 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4zm2 2v12h14V6H3zm2-6h2v2H5V0zm8 0h2v2h-2V0zM5 9h2v2H5V9zm0 4h2v2H5v-2zm4-4h2v2H9V9zm0 4h2v2H9v-2zm4-4h2v2h-2V9zm0 4h2v2h-2v-2z"></path>
                                                    </svg>

                                                    <span v-if="project.days_left && project.days_left > 0">
                                                         <span class="font-medium">{{ project.days_left }}</span> {{ $trans('labels.days-left') }}
                                                    </span>

                                                    <span v-else-if="project.days_left === 0" class="text-red-700">
                                                         {{ $trans('labels.overdue-today') }}
                                                    </span>

                                                    <span v-else-if="project.days_left && project.days_left < 0" class="text-red-700">
                                                        <span class="font-medium">{{ project.days_left * -1 }}</span> {{ $trans('labels.days-overdue') }}
                                                    </span>

                                                    <span v-else>
                                                        -
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-2 flex items-center md:col-span-1 sm:mt-0">
                                            <span class="badge badge-indigo" v-if="project.status === 'ongoing'">{{ $trans('labels.ongoing') }}</span>
                                            <span class="badge badge-red" v-else-if="project.status === 'overdue'">{{ $trans('labels.overdue') }}</span>
                                            <span class="badge badge-green" v-else-if="project.status === 'completed'">{{ $trans('labels.completed') }}</span>
                                            <span class="badge" v-else-if="project.status === 'archived'">{{ $trans('labels.organization') }}</span>
                                        </div>

                                        <div class="mt-4 flex-shrink-0 flex items-center sm:mt-0" v-if="project.team_members.length">
                                            <div class="avatar-group">
                                                <img v-for="user in project.team_members" class="avatar avatar-xs" :src="user.avatar_url" :alt="user.name" :title="user.name"/>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="ml-5 flex-shrink-0">
                                        <svg class="h-5 w-5 text-gray-400 fill-current" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </inertia-link>
                        </li>
                    </ul>

                    <v-pagination :links="$page.projects.links"></v-pagination>
                </div>

                <div class="flex justify-center mt-6" v-else>
                    <div class="flex flex-col items-center">
                        <v-empty-view :message="$trans('messages.no-data-to-show-here')"/>
                    </div>
                </div>
            </div>
        </template>
    </v-app-default-layout>
</template>

<script>
    import VAppDefaultLayout from '@/views/back/app/layouts/default'
    import VCreateProjectModal from '@/views/back/app/projects/modal-project-create'
    import VEmptyView from '@/views/common/empty'
    import VDropdown from '@/components/dropdown'
    import VPagination from '@/components/pagination'
    import VAlert from '@/components/alert/alert'

    export default {
        metaInfo() {
            return {
                title: this.$trans("headings.projects"),
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
            VAlert
        },

        data() {
            return {
                filtersForm: {
                    status: this.filters.status,
                    visibility: this.filters.visibility,
                    search: this.filters.search,
                }
            }
        },

        watch: {
            filtersForm: {
                deep: true,
                handler: _.throttle(function () {
                    let query = _.pickBy(this.filtersForm);
                    this.$inertia.replace(this.route('app:projects.index', Object.keys(query).length ? query : {remember: 'forget'}))
                }, 150)
            }
        },

        methods: {
            showCreateProjectModal() {
                this.$modal(VCreateProjectModal, {
                    users: this.$page.users
                });
            }
        }
    }
</script>
