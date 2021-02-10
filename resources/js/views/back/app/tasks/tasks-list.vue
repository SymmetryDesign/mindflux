<template>
    <div class="bg-white shadow sm:rounded-md mb-4" v-if="tasks.length > 0 && show">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ title }}
            </h3>
        </div>

        <ul>
            <li class="border-b border-gray-100 last:border-0" v-for="task in tasks" :key="task.uuid">
                <div class="block">
                    <div class="px-4 py-4 flex items-center sm:px-6">
                        <div class="min-w-0 flex-1 md:grid md:grid-cols-8 sm:flex sm:justify-between sm:items-center">
                            <div class="flex items-center md:col-span-4">
                                <div class="pr-2 sm:pr-6">
                                    <input type="checkbox" class="form-checkbox w-6 h-6 rounded-full text-green-400" v-model="task.is_completed" @change="updateTask(task)">
                                </div>

                                <a @click.prevent="showTaskModal(task)" href="#" class="text-sm leading-5 truncate hover:underline">
                                    {{ task.content }}
                                </a>
                            </div>

                            <div class="mt-1 sm:mt-0 md:col-span-2">
                                <div>
                                    <div class="flex items-center text-sm leading-5">
                                        <a :href="route('app:projects.show', {project: task.project.uuid})" class="flex items-center text-sm rounded-lg mb-1 hover:underline">
                                            <div class="w-3 h-3 overflow-hidden rounded-full mr-2.5 hidden sm:inline-block">
                                                <div class="w-full h-full" :class="['bg-' + task.project.color + '-400']"></div>
                                            </div>

                                            {{ task.project.name }}
                                        </a>
                                    </div>

                                    <div class="flex items-center text-sm leading-5 mt-0 sm:mt-2">
                                        <v-dropdown placement="left-0">
                                            <template v-slot:button>
                                                <a @click.prevent="" href="#" class="flex items-center text-xs text-gray-600 hover:underline">
                                                    <svg class="w-4 h-4 mr-1.5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path d="M1 4c0-1.1.9-2 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4zm2 2v12h14V6H3zm2-6h2v2H5V0zm8 0h2v2h-2V0zM5 9h2v2H5V9zm0 4h2v2H5v-2zm4-4h2v2H9V9zm0 4h2v2H9v-2zm4-4h2v2h-2V9zm0 4h2v2h-2v-2z"></path>
                                                    </svg>

                                                    <span v-if="task.due_date">{{ task.due_date }}</span>
                                                    <span v-else>{{ $trans('labels.due-date') }}</span>
                                                </a>
                                            </template>

                                            <template v-slot:content>
                                                <v-input-date
                                                    v-model="task.due_date"
                                                    @input="updateTask(task)"
                                                    inline
                                                />
                                            </template>
                                        </v-dropdown>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2 flex items-center justify-end flex-shrink-0 sm:mt-0 md:col-start-7 md:col-span-2">
                                <v-select-user v-model="task.user_uuid" placement="right-0" :users="users" @input="updateTask(task)">
                                    <template v-slot:button="{ selected: user }">
                                        <a @click.prevent="" v-if="user" href="#" class="ml-1 flex items-center justify-center rounded-full overflow-hidden text-gray-400 border border-transparent w-6 h-6 overflow-hidden hover:text-gray-500 hover:bg-gray-50">
                                            <img class="avatar avatar-xs" :src="user.avatar_url" :alt="user.name">
                                        </a>

                                        <a @click.prevent="" v-else href="#" class="ml-1 flex items-center justify-center rounded-full overflow-hidden text-gray-400 border w-6 h-6 overflow-hidden hover:text-gray-500 hover:bg-gray-50">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                                <path d="M5 5a5 5 0 0 1 10 0v2A5 5 0 0 1 5 7V5zM0 16.68A19.9 19.9 0 0 1 10 14c3.64 0 7.06.97 10 2.68V20H0v-3.32z"/>
                                            </svg>
                                        </a>
                                    </template>
                                </v-select-user>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    import VDropdown from '@/components/dropdown'
    import VInputDate from '@/components/input-date'
    import VSelectUser from '@/components/select-user'
    import VModalTask from '@/views/back/app/tasks/modal-task'

    export default {
        components: {
            VDropdown,
            VInputDate,
            VSelectUser
        },

        props: {
            show: {
                type: Boolean,
                default: true
            },
            users: {
                type: Array,
                required: true
            },
            tasks: {
                type: Array,
                required: true
            },
            title: {
                type: String,
                required: true
            }
        },

        methods: {
            showTaskModal(task) {
                this.$modal(VModalTask, {
                    users: this.users,
                    taskUuid: task.uuid,
                    projectUuid: task.project.uuid,
                    content: task.content,
                    isCompleted: task.is_completed,
                    userUuid: task.user_uuid,
                    priority: task.priority,
                    dueDate: task.due_date
                })
            },

            updateTask(task) {
                this.$inertia.put(route('app:project.tasks.update', {
                    project: task.project.uuid,
                    task: task.uuid
                }), {
                    'content': task.content,
                    'due_date': task.due_date,
                    'is_completed': task.is_completed,
                    'user_uuid': task.user_uuid,
                    'priority': task.priority,
                });
            }
        }
    }
</script>
