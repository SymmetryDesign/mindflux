<template>
    <v-modal ref="modal">
        <div class="bg-white rounded-lg shadow-xl transform transition-all sm:max-w-xl sm:w-full">
            <div class="flex items-center px-6 pt-6 pb-4">
                <div>
                    <input type="checkbox" class="form-checkbox w-6 h-6 rounded-full text-green-400" v-model="task.is_completed" @change="updateTask()">
                </div>

                <div class="pl-3 w-full">
                    <v-input-text-editable
                        v-model="task.content"
                        @input="updateTask()"
                    />
                </div>

                <div class="pl-3 flex items-center">
                    <v-dropdown>
                        <template v-slot:button>
                            <button class="btn btn-sm btn-flat">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 12a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0-6a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 12a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"></path>
                                </svg>
                            </button>
                        </template>

                        <template v-slot:content>
                            <div class="dropdown-menu">
                                
                                <!-- clint - link to add jamboard url - opens jamboard url text field modal for this task -->
                                
                                <a @click.prevent="showTaskAddJUModal()" href="#"
                                       class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"
                                    >
                                        Jamboard URL
                                </a>
                                    
                                    
                                <a @click.prevent="showDeleteTaskModal()" href="#" class="dropdown-item">
                                    {{ $trans('labels.delete') }}
                                </a>
                                
                            </div>
                        </template>
                    </v-dropdown>

                    <button @click="hide()" class="btn btn-sm btn-flat">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="flex items-center px-6 pb-6 pr-6">
                <!-- <button type="button" class="btn btn-sm btn-indigo"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current mr-3">
                    <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a1.964 1.964 0 0 0-.453-.618A5.984 5.984 0 0 1 2 6zm3 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5z"/>
                </svg>
                Jamboard
                </button> -->
                <div class="flex items-center px-3" v-if="task.jamboard_url != null">
                    <a target="_blank" :href="task.jamboard_url"  class="btn btn-indigo">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current">
                            <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a1.964 1.964 0 0 0-.453-.618A5.984 5.984 0 0 1 2 6zm3 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                        Jamboard
                    </a>
                </div>






            </div>




            <div class="flex items-center px-6 pb-6 pr-6">
                <v-select-user
                    :users="users"
                    v-model="task.user_uuid"
                    @input="updateTask()"
                />

                <v-dropdown placement="left-0">
                    <template v-slot:button>
                        <a href="#" class="flex items-center text-xs text-gray-600 pl-6 hover:underline">
                            <svg class="w-4 h-4 mr-1.5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M1 4c0-1.1.9-2 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4zm2 2v12h14V6H3zm2-6h2v2H5V0zm8 0h2v2h-2V0zM5 9h2v2H5V9zm0 4h2v2H5v-2zm4-4h2v2H9V9zm0 4h2v2H9v-2zm4-4h2v2h-2V9zm0 4h2v2h-2v-2z"></path>
                            </svg>

                            <span v-if="task.due_date">{{ task.due_date }}</span>
                            <span v-else>{{ $trans('labels.due-date') }}</span>
                        </a>
                    </template>

                    <template v-slot:content>
                        <v-input-date
                            inline
                            v-model="task.due_date"
                            @input="updateTask()"
                        />
                    </template>
                </v-dropdown>

                <v-select-task-priority
                    v-model="task.priority"
                    @input="updateTask()"
                />
            </div>

            <div class="px-6" v-if="$page.errors.has('plan.limit')">
                <v-alert variant="warning" dismissible>{{ $page.errors.first('plan.limit') }}</v-alert>
            </div>

            <v-tabs>
                <v-tab class="p-6" :name="$trans('headings.comments')" active>
                    <v-tab-comments
                        :task-uuid="taskUuid"
                        :project-uuid="projectUuid"
                        @new-comment="onNewCommentSubmitted"
                    />
                </v-tab>

                <v-tab class="p-6" :name="$trans('headings.tasks')">
                    <v-tab-tasks
                        :users="users"
                        :task-uuid="taskUuid"
                        :project-uuid="projectUuid"
                    />
                </v-tab>

                <v-tab class="p-6" :name="$trans('headings.attachments')">
                    <v-tab-attachments
                        :task-uuid="taskUuid"
                        :project-uuid="projectUuid"
                        ref="tab_attachments"
                    />
                </v-tab>
            </v-tabs>
        </div>
    </v-modal>
     
</template>

<script>
    import VModal from '@/components/modal'
    import VInputTextEditable from '@/components/input-text-editable'
    import VInputDate from '@/components/input-date'
    import VDropdown from '@/components/dropdown'
    import VAlert from '@/components/alert'
    import {Tab as VTab, Tabs as VTabs} from '@/components/tabs'
    import VSelectTaskPriority from '@/components/select-task-priority'
    import VSelectUser from '@/components/select-user'
    import Form from '@/utils/form'
    import VDraggable from 'vuedraggable'
    import VTabComments from '@/views/back/app/tasks/tab-comments'
    import VTabTasks from '@/views/back/app/tasks/tab-tasks'
    import VTabAttachments from '@/views/back/app/tasks/tab-attachments'
    import VTaskAddJUModal from '@/views/back/app/tasks/modal-task-add-ju'


    export default {
        components: {
            VModal,
            VTab,
            VTabs,
            VSelectTaskPriority,
            VSelectUser,
            VDropdown,
            VAlert,
            VInputTextEditable,
            VInputDate,
            VDraggable,
            VTabComments,
            VTabTasks,
            VTabAttachments,
            VTaskAddJUModal
        },

        props: {
            users: {
                type: Array,
                default: []
            },
            projectUuid: {
                type: String,
                required: true
            },
            taskUuid: {
                type: String,
                required: true
            },
            content: {
                type: String,
                required: true
            },
            jamboard_url: {
                type: String,
                required: true
            },
            isCompleted: {
                type: Boolean,
                default: false
            },
            userUuid: {
                type: String,
                default: null
            },
            priority: {
                type: Number,
                default: null
            },
            dueDate: {
                type: String,
                default: null
            }
        },

        data() {
            return {
                task: new Form({
                    uuid: this.uuid,
                    content: this.content,
                    jamboard_url: this.jamboard_url,
                    is_completed: this.isCompleted,
                    user_uuid: this.userUuid,
                    due_date: this.dueDate,
                    priority: this.priority
                })
            }
        },

        methods: {
            show() {
                this.$refs.modal.show();
            },

            hide() {
                this.$refs.modal.hide();
                this.task.reset();
            },

            showDeleteTaskModal() {
                this.$confirm('Do you want to delete this task permanently?').then((modal) => {
                    this.$inertia.delete(route('app:project.tasks.destroy', {
                        project: this.projectUuid,
                        task: this.taskUuid
                    }))
                        .then(() => {
                            modal.hide()
                        });
                });
            },
            showTaskAddJUModal(){
                  this.$modal(VTaskAddJUModal, {
                    users: this.users,
                    projectUuid: this.projectUuid,
                    taskUuid: this.taskUuid,
                    userUuid: this.userUuid,
                    // content: task.content,
                    // isCompleted: task.is_completed,
                    // dueDate: task.due_date,
                    // priority: task.priority,
                });

                // this.$confirm('Do you want to delete this task permanently?').then((modal) => {
                //     this.$inertia.delete(route('app:project.tasks.destroy', {
                //         project: this.projectUuid,
                //         task: this.taskUuid
                //     }))
                //         .then(() => {
                //             modal.hide()
                //         });
                // });
            },
            
            showJamboardLinkModal() {
                this.$confirm('Jamboard Link Text Field').then((modal) => {
                });
            },

            updateTask() {
                this.$inertia.put(route('app:project.tasks.update', {
                    project: this.projectUuid,
                    task: this.taskUuid
                }), {
                    'content': this.task.content,
                    'due_date': this.task.due_date,
                    'is_completed': this.task.is_completed,
                    'user_uuid': this.task.user_uuid,
                    'priority': this.task.priority,
                });
            },

            onNewCommentSubmitted() {
                this.$refs.tab_attachments.getAttachments();
            }
        }
    }
</script>
