<template>
    <div class="column max-w-xs w-full flex-shrink-0 rounded-lg mr-3">
        <div class="flex flex-col h-full rounded-lg shadow-sm bg-gray-200">
            <div class="flex items-center">
                <span class="font-bold text-sm text-gray-700 truncate px-4 py-4">{{ column.name }}</span>

                <div class="ml-auto flex items-center pr-3">
                    <button @click="showAddTaskForm()" class="flex items-center p-1 text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 9h4v2h-4v4H9v-4H5V9h4V5h2v4zm-1 11a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"></path>
                        </svg>
                    </button>

                    <v-dropdown>
                        <template v-slot:button>
                            <button class="flex items-center p-1 text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 12a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0-6a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 12a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"></path>
                                </svg>
                            </button>
                        </template>

                        <template v-slot:content>
                            <div class="w-48 rounded-md bg-white shadow-xs">
                                <div class="py-1">
                                    <a @click.prevent="$emit('column-edit', column)" href="#"
                                       class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"
                                    >
                                        {{ $trans('labels.edit') }}
                                    </a>

                                    <a @click.prevent="$emit('column-delete', column)" href="#"
                                       class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"
                                    >
                                        {{ $trans('labels.delete') }}
                                    </a>
                                </div>
                            </div>
                        </template>
                    </v-dropdown>
                </div>
            </div>

            <div class="flex flex-col h-full px-4 overflow-y-auto">
                <div class="flex flex-col mb-4 mt-1" v-if="addTaskForm.visible">
                    <input @keyup.enter="storeTask()" class="form-input" placeholder="Write task" ref="input_new_task" v-model="addTaskForm.content">

                    <div class="flex justify-end mt-3">
                        <button @click="hideAddTaskForm()" class="btn btn-link text-xs px-4 py-1 mr-2" type="button">
                            {{ $trans('labels.cancel') }}
                        </button>

                        <button :disabled="addTaskForm.content === null" @click="storeTask()" class="btn btn-blue text-xs px-4 py-1" type="button">
                            {{ $trans('labels.submit') }}
                        </button>
                    </div>
                </div>

                <v-draggable
                    :data-column="column.uuid"
                    class="flex flex-col flex-1"
                    ghost-class="draggable-ghost"
                    group="tasks"
                    v-model="column.tasks"
                    v-bind="{ fallbackTolerance: 5 }"
                    @end="$emit('tasks-sort-change', $event)"
                >
                    <v-card-task
                        :key="task.uuid"
                        :task="task"
                        @click="$emit('task-click', task)"
                        v-for="task in column.tasks"
                    />
                </v-draggable>
            </div>
        </div>
    </div>
</template>

<script>
    import VDraggable from 'vuedraggable'
    import VCardTask from '@/views/back/app/projects/card-task'
    import VDropdown from '@/components/dropdown'
    import Form from '@/utils/form'

    export default {
        components: {
            VDraggable,
            VCardTask,
            VDropdown
        },

        props: {
            column: {
                type: Object,
                required: true
            }
        },

        data() {
            return {
                addTaskForm: new Form({
                    content: null,
                    visible: false
                })
            }
        },

        methods: {
            showAddTaskForm() {
                this.addTaskForm.reset();
                this.addTaskForm.visible = true;
                this.$nextTick(() => {
                    this.$refs.input_new_task.focus();
                });
            },

            hideAddTaskForm() {
                this.addTaskForm.reset();
            },

            storeTask() {
                this.$inertia.post(route('app:project.tasks.store', {
                    project: this.$page.project.uuid,
                    column: this.column.uuid
                }), {
                    content: this.addTaskForm.content
                }).then(() => {
                    if (this.$page.errors.none()) {
                        this.hideAddTaskForm();
                    }
                })
            }
        }
    }
</script>
