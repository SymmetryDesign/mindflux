<template>
    <v-app-default-layout>
        <template v-slot:header>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $trans('headings.my-tasks') }}</h1>
        </template>

        <template>
            <div class="container mx-auto w-full flex flex-col flex-1 px-4 sm:px-6 md:px-8 py-4">
                <v-alert v-if="$page.errors.has('plan.limit')" variant="warning" dismissible>
                    {{ $page.errors.first('plan.limit') }}
                </v-alert>

                <div class="flex flex-col flex-col-reverse md:flex-row mx-0 sm:-mx-6">
                    <div class="flex flex-col flex-1 px-0 sm:px-6" v-if="emptyStatusVisible">
                        <v-empty-view
                            :message="$trans('messages.no-data-to-show-here')"
                        />
                    </div>

                    <div class="flex flex-col flex-1 px-0 sm:px-6" v-else>
                        <v-tasks-list
                            :title="$trans('headings.today')"
                            :tasks="todayTasks"
                            :users="users"
                            :show="$request.params() == '' || $request.query('filter') == 'today' || $request.has('project')"
                        />

                        <v-tasks-list
                            :title="$trans('headings.upcoming')"
                            :tasks="upcomingTasks"
                            :users="users"
                            :show="$request.params() == '' || $request.query('filter') == 'upcoming' || $request.has('project')"
                        />

                        <v-tasks-list
                            :title="$trans('headings.overdue')"
                            :tasks="overdueTasks"
                            :users="users"
                            :show="$request.params() == '' || $request.query('filter') == 'overdue' || $request.has('project')"
                        />

                        <v-tasks-list
                            :title="$trans('headings.no-overdue')"
                            :tasks="noOverdueTasks"
                            :users="users"
                            :show="$request.params() == '' || $request.query('filter') == 'no_overdue' || $request.has('project')"
                        />

                        <v-tasks-list
                            :title="$trans('headings.completed')"
                            :tasks="completedTasks"
                            :users="users"
                            :show="$request.query('filter') == 'completed' || $request.has('project')"
                        />
                    </div>

                    <div class="flex flex-col flex-shrink-0 w-full px-0 sm:w-64 sm:px-6 mb-6">
                        <div class="mb-6">
                            <nav>
                                <inertia-link
                                    :href="route('app:tasks.index')"
                                    :class="{ 'bg-white font-semibold' : $request.params() == '' }"
                                    class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white"
                                >
                                    <svg class="w-4 h-4 overflow-hidden mr-3" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M0 2C0 .9.9 0 2 0h16a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm14 12h4V2H2v12h4c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2z"></path>
                                    </svg>

                                    <span>{{ $trans('labels.inbox') }}</span>
                                </inertia-link>

                                <inertia-link
                                    :class="{ 'bg-white font-medium' : $request.query('filter') == 'today' }"
                                    :href="route('app:tasks.index', {filter: 'today'})"
                                    class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white"
                                >
                                    <div class="w-4 h-4 overflow-hidden mr-3">
                                        <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-full h-full fill-current">
                                            <path d="M1 4c0-1.1.9-2 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4zm2 2v12h14V6H3zm2-6h2v2H5V0zm8 0h2v2h-2V0zM5 9h2v2H5V9zm0 4h2v2H5v-2zm4-4h2v2H9V9zm0 4h2v2H9v-2zm4-4h2v2h-2V9zm0 4h2v2h-2v-2z"></path>
                                        </svg>
                                    </div>

                                    {{ $trans('labels.today') }}
                                </inertia-link>

                                <inertia-link
                                    :class="{ 'bg-white font-medium' : $request.query('filter') == 'upcoming' }"
                                    :href="route('app:tasks.index', {filter: 'upcoming'})"
                                    class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white transition duration-150"
                                >
                                    <div class="w-4 h-4 overflow-hidden mr-3">
                                        <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-full h-full fill-current">
                                            <path d="M13 8V0L8.11 5.87 3 12h4v8L17 8h-4z"></path>
                                        </svg>
                                    </div>

                                    {{ $trans('labels.upcoming') }}
                                </inertia-link>

                                <inertia-link
                                    :class="{ 'bg-white font-medium' : $request.query('filter') == 'overdue' }"
                                    :href="route('app:tasks.index', {filter: 'overdue'})"
                                    class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white transition duration-150"
                                >
                                    <div class="w-4 h-4 overflow-hidden mr-3">
                                        <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-full h-full fill-current">
                                            <path d="M13 8V0L8.11 5.87 3 12h4v8L17 8h-4z"></path>
                                        </svg>
                                    </div>

                                    {{ $trans('labels.overdue') }}
                                </inertia-link>

                                <inertia-link
                                    :class="{ 'bg-white font-medium' : $request.query('filter') == 'no_overdue' }"
                                    :href="route('app:tasks.index', {filter: 'no_overdue'})"
                                    class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white transition duration-150"
                                >
                                    <div class="w-4 h-4 overflow-hidden mr-3">
                                        <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-full h-full fill-current">
                                            <path d="M13 8V0L8.11 5.87 3 12h4v8L17 8h-4z"></path>
                                        </svg>
                                    </div>

                                    {{ $trans('labels.no-overdue') }}
                                </inertia-link>

                                <inertia-link
                                    :class="{ 'bg-white font-medium' : $request.query('filter') == 'completed' }"
                                    :href="route('app:tasks.index', {filter: 'completed'})"
                                    class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white transition duration-150"
                                >
                                    <div class="w-4 h-4 overflow-hidden mr-3">
                                        <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-full h-full fill-current">
                                            <path d="M13 8V0L8.11 5.87 3 12h4v8L17 8h-4z"></path>
                                        </svg>
                                    </div>

                                    {{ $trans('labels.completed') }}
                                </inertia-link>
                            </nav>
                        </div>

                        <div class="mb-4">
                            <h3 class="px-3 text-xs leading-4 font-semibold text-gray-500 uppercase tracking-wider">
                                {{ $trans('labels.projects') }}
                            </h3>

                            <nav class="mt-2">
                                <inertia-link
                                    :key="project.uuid"
                                    :href="route('app:tasks.index', {project: project.uuid})"
                                    :class="{ 'bg-white' : $request.query('project') == project.uuid }"
                                    class="flex items-center px-4 py-2 text-sm rounded-lg mb-1 hover:bg-white transition duration-150"
                                    v-for="project in $page.projects"
                                >
                                    <div class="w-3 h-3 overflow-hidden rounded-full mr-3">
                                        <div class="w-full h-full" :class="['bg-' + project.color + '-400']"></div>
                                    </div>

                                    {{ project.name }}
                                </inertia-link>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </v-app-default-layout>
</template>

<script>
    import VAppDefaultLayout from '@/views/back/app/layouts/default'
    import VTasksList from '@/views/back/app/tasks/tasks-list'
    import VEmptyView from '@/views/common/empty'
    import VAlert from '@/components/alert'
    import moment from 'moment'

    export default {
        metaInfo() {
            return {
                title: this.$trans('headings.my-tasks')
            }
        },

        components: {
            VAppDefaultLayout,
            VEmptyView,
            VAlert,
            VTasksList
        },

        props: {
            tasks: {
                type: Array,
                required: true
            },
            users: {
                type: Array,
                required: true
            }
        },

        computed: {
            emptyStatusVisible() {
                return (this.$request.params() == '' || this.$request.query('project') !== '')
                    && this.todayTasks.length === 0 && this.upcomingTasks.length === 0 && this.overdueTasks.length === 0 && this.noOverdueTasks.length === 0 && this.completedTasks.length === 0
                    || this.$request.query('filter') == 'today' && this.todayTasks.length === 0
                    || this.$request.query('filter') == 'upcoming' && this.upcomingTasks.length === 0
                    || this.$request.query('filter') == 'overdue' && this.overdueTasks.length === 0
                    || this.$request.query('filter') == 'no_overdue' && this.noOverdueTasks.length === 0
                    || this.$request.query('filter') == 'completed' && this.completedTasks.length === 0;
            },
            overdueTasks() {
                return this.tasks.filter(task => {
                    if (task.due_date !== null && moment().isAfter(moment(task.due_date), 'day') && !task.is_completed) {
                        return task;
                    }
                });
            },
            todayTasks() {
                return this.tasks.filter(task => {
                    if (moment().isSame(moment(task.due_date), 'day') && !task.is_completed) {
                        return task;
                    }
                });
            },
            upcomingTasks() {
                return this.tasks.filter(task => {
                    if (moment(task.due_date).isAfter(moment(), 'day') && !task.is_completed) {
                        return task;
                    }
                });
            },
            completedTasks() {
                return this.tasks.filter(task => {
                    if (task.is_completed) {
                        return task;
                    }
                });
            },
            noOverdueTasks() {
                return this.tasks.filter(task => {
                    if (!task.is_completed && task.due_date === null) {
                        return task;
                    }
                });
            }
        }
    }
</script>
