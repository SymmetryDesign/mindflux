<template>
    <div class="flex items-center px-4 py-2 mb-1 hover:bg-gray-100 rounded-lg">
        <div>
            <input type="checkbox" class="form-checkbox w-6 h-6 rounded-full text-green-400" v-model="form.is_completed" @change="updateTask()">
        </div>

        <div class="pl-3 w-full">
            <v-input-text-editable
                :class="{ 'line-through text-gray-600' : task.is_completed }"
                class="text-sm"
                v-model="form.content"
                @edit-enabled="editable = true"
                @edit-disabled="editable = false"
                @input="updateTask()"
            />
        </div>

        <div class="ml-auto pl-2 flex items-center" v-if="!editable">
            <div>
                <v-dropdown>
                    <template v-slot:button>
                        <a href="#" :class="{ 'text-indigo-600 hover:text-indigo-700' : form.due_date }" class="ml-1 flex items-center justify-center rounded-full overflow-hidden text-gray-400 border w-6 h-6 overflow-hidden hover:text-gray-500 hover:bg-gray-50">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                <path d="M1 4c0-1.1.9-2 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4zm2 2v12h14V6H3zm2-6h2v2H5V0zm8 0h2v2h-2V0zM5 9h2v2H5V9zm0 4h2v2H5v-2zm4-4h2v2H9V9zm0 4h2v2H9v-2zm4-4h2v2h-2V9zm0 4h2v2h-2v-2z"/>
                            </svg>
                        </a>
                    </template>

                    <template v-slot:content>
                        <v-input-date v-model="form.due_date" @input="updateTask()" inline/>
                    </template>
                </v-dropdown>
            </div>

            <div class="ml-1">
                <v-select-user placement="right-0" :users="users" v-model="form.user_uuid" @input="updateTask()">
                    <template v-slot:button="{ selected: user }">
                        <a v-if="user" href="#" class="ml-1 flex items-center justify-center rounded-full overflow-hidden text-gray-400 border border-transparent w-6 h-6 overflow-hidden hover:text-gray-500 hover:bg-gray-50">
                            <img class="avatar avatar-xs" :src="user.avatar_url" :alt="user.name">
                        </a>

                        <a v-else href="#" class="ml-1 flex items-center justify-center rounded-full overflow-hidden text-gray-400 border w-6 h-6 overflow-hidden hover:text-gray-500 hover:bg-gray-50">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                <path d="M5 5a5 5 0 0 1 10 0v2A5 5 0 0 1 5 7V5zM0 16.68A19.9 19.9 0 0 1 10 14c3.64 0 7.06.97 10 2.68V20H0v-3.32z"/>
                            </svg>
                        </a>
                    </template>
                </v-select-user>
            </div>
        </div>
    </div>
</template>

<script>
    import VDropdown from '@/components/dropdown'
    import VInputTextEditable from '@/components/input-text-editable'
    import VSelectUser from '@/components/select-user'
    import VInputDate from '@/components/input-date'

    export default {
        components: {
            VDropdown,
            VInputTextEditable,
            VSelectUser,
            VInputDate
        },

        props: {
            task: {
                type: Object
            },
            users: {
                type: Array,
                required: true
            },
            projectUuid: {
                type: String,
                required: true
            }
        },

        data() {
            return {
                editable: false,
                form: {
                    uuid: this.task.uuid,
                    content: this.task.content,
                    due_date: this.task.due_date,
                    is_completed: this.task.is_completed,
                    user_uuid: this.task.user.uuid,
                }
            }
        },

        methods: {
            updateTask() {
                this.$inertia.put(route('app:project.tasks.update', {
                    project: this.projectUuid,
                    task: this.task.uuid
                }), {
                    'content': this.form.content,
                    'due_date': this.form.due_date,
                    'is_completed': this.form.is_completed,
                    'user_uuid': this.form.user_uuid,
                    'priority': this.form.priority,
                }).then(() => {
                    this.$emit('updated')
                });
            }
        }
    }
</script>
