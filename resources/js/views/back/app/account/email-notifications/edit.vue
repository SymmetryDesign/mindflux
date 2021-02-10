<template>
    <v-app-default-layout>
        <template v-slot:header>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $trans('headings.email-notifications') }}</h1>
        </template>

        <template>
            <div class="container mx-auto px-4 sm:px-6 md:px-8 py-4">
                <div class="md:grid md:gap-6 md:grid-cols-8">
                    <div class="mb-6 sm:col-span-2">
                        <v-nav-menu/>
                    </div>

                    <div class="md:col-span-6">
                        <v-alert v-if="$page.flash" dismissible>
                            {{ $page.flash }}
                        </v-alert>

                        <v-alert variant="failure" v-if="$page.errors.has('demo.restrict')" dismissible>
                            {{ $page.errors.first('demo.restrict') }}
                        </v-alert>

                        <div class="flex flex-col bg-white rounded-lg shadow mb-6">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    {{ $trans('headings.email-notifications') }}
                                </h3>

                                <p class="mt-1 text-sm leading-5 text-gray-500">
                                    {{ $trans('headings.subtexts.email-notifications') }}
                                </p>
                            </div>

                            <div class="md:grid md:grid-cols-3 md:gap-6 px-6 py-5">
                                <div class="md:col-span-1">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $trans('headings.project-notifications') }}</h3>

                                    <p class="mt-1 text-sm leading-5 text-gray-500">
                                        {{ $trans('headings.subtexts.project-notifications') }}
                                    </p>
                                </div>

                                <div class="md:mt-0 md:col-span-2">
                                    <fieldset class="mb-6">
                                        <div>
                                            <div class="flex items-start">
                                                <div class="absolute flex items-center h-5">
                                                    <input id="assigned_to_project" type="checkbox" class="form-checkbox" v-model="form.assigned_to_project">
                                                </div>

                                                <div class="pl-7 text-sm leading-5">
                                                    <label for="assigned_to_project" class="font-medium text-gray-700">{{ $trans('labels.assigned-to-project') }}</label>
                                                    <p class="text-gray-500">{{ $trans('labels.subtexts.assigned-to-project') }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <div class="flex items-start">
                                                <div class="absolute flex items-center h-5">
                                                    <input id="project_status_changed" type="checkbox" class="form-checkbox" v-model="form.project_status_changed">
                                                </div>

                                                <div class="pl-7 text-sm leading-5">
                                                    <label for="project_status_changed" class="font-medium text-gray-700">{{ $trans('labels.project-status-changed') }}</label>
                                                    <p class="text-gray-500">{{ $trans('labels.subtexts.project-status-changed') }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <div class="flex items-start">
                                                <div class="absolute flex items-center h-5">
                                                    <input id="team_member_joined_project" type="checkbox" class="form-checkbox" v-model="form.team_member_joined_project">
                                                </div>

                                                <div class="pl-7 text-sm leading-5">
                                                    <label for="team_member_joined_project" class="font-medium text-gray-700">{{ $trans('labels.team-member-joined') }}</label>
                                                    <p class="text-gray-500">{{ $trans('labels.subtexts.team-member-joined') }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <div class="flex items-start">
                                                <div class="absolute flex items-center h-5">
                                                    <input id="project_timeline_changed" type="checkbox" class="form-checkbox" v-model="form.project_timeline_changed">
                                                </div>

                                                <div class="pl-7 text-sm leading-5">
                                                    <label for="project_timeline_changed" class="font-medium text-gray-700">{{ $trans('labels.project-timeline-changed') }}</label>
                                                    <p class="text-gray-500">{{ $trans('labels.subtexts.project-timeline-changed') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="md:grid md:grid-cols-3 md:gap-6 px-6 pb-6">
                                <div class="md:col-span-1">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $trans('headings.tasks-notifications') }}</h3>

                                    <p class="mt-1 text-sm leading-5 text-gray-500">
                                        {{ $trans('headings.subtexts.tasks-notifications') }}
                                    </p>
                                </div>

                                <div class="md:mt-0 md:col-span-2">
                                    <fieldset>
                                        <div>
                                            <div class="flex items-start">
                                                <div class="absolute flex items-center h-5">
                                                    <input id="task_assigned_to_you" type="checkbox" class="form-checkbox" v-model="form.task_assigned_to_you">
                                                </div>

                                                <div class="pl-7 text-sm leading-5">
                                                    <label for="task_assigned_to_you" class="font-medium text-gray-700">{{ $trans('labels.task-assigned-to-you') }}</label>
                                                    <p class="text-gray-500">{{ $trans('labels.subtexts.task-assigned-to-you') }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <div class="flex items-start">
                                                <div class="absolute flex items-center h-5">
                                                    <input id="task_assigned_to_team_member" type="checkbox" class="form-checkbox" v-model="form.task_assigned_to_team_member">
                                                </div>

                                                <div class="pl-7 text-sm leading-5">
                                                    <label for="task_assigned_to_team_member" class="font-medium text-gray-700">{{ $trans('labels.task-assigned-to-team-member') }}</label>
                                                    <p class="text-gray-500">{{ $trans('labels.subtexts.task-assigned-to-team-member') }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <div class="flex items-start">
                                                <div class="absolute flex items-center h-5">
                                                    <input id="task_phase_changed" type="checkbox" class="form-checkbox" v-model="form.task_phase_changed">
                                                </div>

                                                <div class="pl-7 text-sm leading-5">
                                                    <label for="task_phase_changed" class="font-medium text-gray-700">{{ $trans('labels.task-phase-changed') }}</label>
                                                    <p class="text-gray-500">{{ $trans('labels.subtexts.task-phase-changed') }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <div class="flex items-start">
                                                <div class="absolute flex items-center h-5">
                                                    <input id="task_status_changed" type="checkbox" class="form-checkbox" v-model="form.task_status_changed">
                                                </div>

                                                <div class="pl-7 text-sm leading-5">
                                                    <label for="task_status_changed" class="font-medium text-gray-700">{{ $trans('labels.task-status-changed') }}</label>
                                                    <p class="text-gray-500">{{ $trans('labels.subtexts.task-status-changed') }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <div class="flex items-start">
                                                <div class="absolute flex items-center h-5">
                                                    <input id="task_deadline_changed" type="checkbox" class="form-checkbox" v-model="form.task_deadline_changed">
                                                </div>

                                                <div class="pl-7 text-sm leading-5">
                                                    <label for="task_deadline_changed" class="font-medium text-gray-700">{{ $trans('labels.task-deadline-changed') }}</label>
                                                    <p class="text-gray-500">{{ $trans('labels.subtexts.task-deadline-changed') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="bg-gray-50 text-right rounded-b-lg px-4 py-5 sm:p-6">
                                <button @click="submit()" type="button" class="btn btn-indigo" :disabled="form.processing">
                                    {{ $trans('labels.save-settings') }}
                                </button>
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
    import VNavMenu from '@/views/back/app/account/nav-menu'
    import VAlert from '@/components/alert'
    import Form from '@/utils/form'

    export default {
        metaInfo() {
            return {
                title: this.$trans('headings.email-notifications')
            }
        },

        components: {
            VAppDefaultLayout,
            VNavMenu,
            VAlert,
        },

        data() {
            return {
                form: new Form({
                    assigned_to_project: this.$page.assigned_to_project,
                    project_status_changed: this.$page.project_status_changed,
                    team_member_joined_project: this.$page.team_member_joined_project,
                    project_timeline_changed: this.$page.project_timeline_changed,
                    task_assigned_to_you: this.$page.task_assigned_to_you,
                    task_assigned_to_team_member: this.$page.task_assigned_to_team_member,
                    task_phase_changed: this.$page.task_phase_changed,
                    task_status_changed: this.$page.task_status_changed,
                    task_deadline_changed: this.$page.task_deadline_changed
                })
            }
        },

        methods: {
            submit() {
                this.form.processing = true;

                this.$inertia.put(route('app:email-notifications.update'), this.form.data())
                    .then(() => this.form.processing = false);
            }
        }
    }
</script>
