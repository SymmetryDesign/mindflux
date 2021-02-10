<template>
    <div class="flex flex-col">
        <div class="mb-6">
            <div class="mt-1 flex rounded-md shadow-sm">
                <div class="relative flex-grow focus-within:z-10">
                    <input class="form-input rounded-r-none" :placeholder="$trans('placeholders.enter-new-task')" v-model="newSubTask.content" @keyup.enter="addTask()"/>
                </div>

                <button @click="addTask()" :disabled="!newSubTask.content" class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-r-md text-gray-700 bg-gray-50 hover:text-gray-500 hover:bg-white focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                    <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M11 9V5H9v4H5v2h4v4h2v-4h4V9h-4zm-1 11a10 10 0 1 1 0-20 10 10 0 0 1 0 20z"/>
                    </svg>

                    <span class="ml-2">{{ $trans('labels.add') }}</span>
                </button>
            </div>
        </div>

        <div class="flex flex-col items-center" v-if="subtasks.length === 0">
            <v-empty-view :message="$trans('messages.no-data-to-show-here')"/>
        </div>

        <div class="flex flex-col mb-4" v-if="incompletedTasks.length > 0">
            <div class="pb-2 border-b border-gray-200 mb-1">
                <h4 class="font-medium text-lg">{{ $trans('labels.todo') }} ({{ incompletedTasks.length }})</h4>
            </div>

            <v-sub-task
                :key="task.uuid"
                :users="users"
                :task="task"
                :project-uuid="projectUuid"
                v-for="task in incompletedTasks"
                @updated="getSubtasks()"
            />
        </div>

        <div class="flex flex-col mb-4" v-if="completedTasks.length > 0">
            <div class="pb-2 border-b border-gray-200 mb-1">
                <h4 class="font-medium text-lg">{{ $trans('labels.completed') }} ({{ completedTasks.length }})</h4>
            </div>

            <v-sub-task
                :key="task.uuid"
                :users="users"
                :task="task"
                :project-uuid="projectUuid"
                v-for="task in completedTasks"
                @updated="getSubtasks()"
            />
        </div>
    </div>
</template>

<script>
    import VEmptyView from '@/views/common/empty'
    import VDraggable from 'vuedraggable'
    import VSubTask from '@/components/sub-task'
    import Form from '@/utils/form'

    export default {
        components: {
            VDraggable,
            VSubTask,
            VEmptyView
        },

        props: {
            users: {
                type: Array,
                required: true
            },
            projectUuid: {
                type: String,
                required: true
            },
            taskUuid: {
                type: String,
                required: true
            }
        },

        data() {
            return {
                subtasks: [],
                newSubTask: new Form({
                    content: ''
                })
            }
        },

        mounted() {
            this.getSubtasks();
        },

        computed: {
            incompletedTasks() {
                return this.subtasks.filter(task => task.is_completed !== true);
            },
            completedTasks() {
                return this.subtasks.filter(task => task.is_completed);
            }
        },

        methods: {
            getSubtasks() {
                axios.get(route('app:project.task.sub-tasks.index', {
                    project: this.projectUuid,
                    task: this.taskUuid
                })).then(response => {
                    this.subtasks = response.data;
                });
            },

            addTask() {
                this.$inertia.post(route('app:project.task.sub-tasks.store', {
                    project: this.projectUuid,
                    task: this.taskUuid
                }), {
                    content: this.newSubTask.content
                }).then(() => {
                    this.newSubTask.reset();
                    this.getSubtasks();
                })
            }
        }
    }
</script>
