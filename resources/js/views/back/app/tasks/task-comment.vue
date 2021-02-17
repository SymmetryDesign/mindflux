<template>
    <div class="flex mt-6 pb-4">
        <div class="w-12 flex-shrink-0">
            <img :src="user.avatar_url" class="avatar avatar-sm" alt="avatar">
        </div>

        <div class="flex flex-col flex-1">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-sm leading-5 font-medium text-indigo-600">{{ user.name }}</span>
                    
                
                   
                    
                </div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>

                <div>
                    <span class="text-xs text-gray-500">{{ createdAt }}</span>
                </div>






               


                <div class="pl-3 flex items-center">
                     <div v-if="!(pinned_comment)">
                        <a @click.prevent="makePinned(pinned_comment)" class="my-pointer"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="grey" class="bi bi-pin-fill" viewBox="0 0 16 16">
                            <path d="M4.146.146A.5.5 0 0 1 4.5 0h7a.5.5 0 0 1 .5.5c0 .68-.342 1.174-.646 1.479-.126.125-.25.224-.354.298v4.431l.078.048c.203.127.476.314.751.555C12.36 7.775 13 8.527 13 9.5a.5.5 0 0 1-.5.5h-4v4.5c0 .276-.224 1.5-.5 1.5s-.5-1.224-.5-1.5V10h-4a.5.5 0 0 1-.5-.5c0-.973.64-1.725 1.17-2.189A5.921 5.921 0 0 1 5 6.708V2.277a2.77 2.77 0 0 1-.354-.298C4.342 1.674 4 1.179 4 .5a.5.5 0 0 1 .146-.354z"></path>
                        </svg></a>
                    </div>
                    <a v-else @click.prevent="makeUnPinned(pinned_comment)" class="my-pointer"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pin-fill text-indigo-600" viewBox="0 0 16 16">
                        <path d="M4.146.146A.5.5 0 0 1 4.5 0h7a.5.5 0 0 1 .5.5c0 .68-.342 1.174-.646 1.479-.126.125-.25.224-.354.298v4.431l.078.048c.203.127.476.314.751.555C12.36 7.775 13 8.527 13 9.5a.5.5 0 0 1-.5.5h-4v4.5c0 .276-.224 1.5-.5 1.5s-.5-1.224-.5-1.5V10h-4a.5.5 0 0 1-.5-.5c0-.973.64-1.725 1.17-2.189A5.921 5.921 0 0 1 5 6.708V2.277a2.77 2.77 0 0 1-.354-.298C4.342 1.674 4 1.179 4 .5a.5.5 0 0 1 .146-.354z"/>
                    </svg></a>






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
                                
                                <a @click.prevent="showTaskCommentEditModal()" href="#"
                                       class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"
                                    >
                                        edit
                                </a>
                                    
                                    
                                <a @click.prevent="showDeleteCommentModal()" href="#" class="dropdown-item">
                                    {{ $trans('labels.delete') }}
                                </a>
                                
                            </div>
                        </template>
                    </v-dropdown>

                
                </div>


            </div>

            <div class="mt-2">
                <p class="leading-5 text-gray-900 pre-formatted">{{ content }}</p>
            </div>

            <ul class="border border-gray-200 rounded-md mt-4" v-if="attachments.length > 0">
                <li class="pl-3 pr-2 py-3 flex items-center justify-between text-sm leading-5" v-for="attachment in attachments">
                    <div class="w-0 flex-1 flex items-center">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd"></path>
                        </svg>

                        <a :href="route('app:project.attachments.download', {project: projectUuid, attachment: attachment.uuid})" class="hover:underline">
                            <span class="ml-2 truncate">{{ attachment.filename }}</span>
                        </a>
                    </div>

                    <div class="ml-4 flex-shrink-0">
                        <a :href="route('app:project.attachments.download', {project: projectUuid, attachment: attachment.uuid})" class="btn btn-flat btn-xs" :title="$trans('labels.download')">
                            <svg class="w-3 h-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/>
                            </svg>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
        <!-- Edit Comment modal -->
        <v-modal ref="modal" id="modal_edit_comment">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            

                <v-tabs>
                    <v-tab :name="$trans('headings.edit-comment')" active>
                        <div class="flex flex-col px-6 pt-6 pb-6">
                            <div class="mb-6">
                                <div class="form-group">
                                    <label for="project-name" class="form-label">{{ $trans('labels.edit-comment') }}</label>

                                    <div class="flex flex-col rounded-lg shadow-sm border border-gray-300">
                                        <v-textarea-exapandable
                                            class="border-none shadow-none focus:outline-none focus:shadow-none rounded-lg"
                                            :placeholder="$trans('placeholders.write-something')"
                                            v-model="comment_content"
                                        
                                        
                                        />

                                        <div class="mt-2 px-3 pb-3 flex items-center justify-between">
                                            <div>
                                                <button type="button" class="btn btn-sm btn-indigo" @click="submit()">
                                                    <svg class="w-3 h-3 mr-1.5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path d="M0 0l20 10L0 20V0zm0 8v4l10-2L0 8z"/>
                                                    </svg>
                                                    {{ $trans('labels.send') }}
                                                </button>
                                            </div>

                                            <div>
                                            
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
        
                        </div>
                    </v-tab>

                
                </v-tabs>

                <div class="bg-gray-50 p-4 sm:px-6 sm:py-4 sm:flex sm:flex-row-reverse">

                    <button type="button" class="btn btn-flat mr-3" @click="hide()">
                        {{ $trans('labels.cancel') }}
                    </button>
                </div>
            </div>
        </v-modal>
    </div>
    
</template>

<script>
    import VTaskCommentEditor from '@/views/back/app/tasks/task-comment-editor'
    import VDropdown from '@/components/dropdown'
    import VModal from '@/components/modal'
    import {Tab as VTab, Tabs as VTabs} from '@/components/tabs'
    import VTextareaExapandable from '@/components/textarea-expandable'
   



    export default {
        components: {
            VTaskCommentEditor,
            VTextareaExapandable,
            VDropdown,
            VModal,
            VTabs,
            VTab,
        },

        props: {
            task_id: {
                //type: Integer,
                required: true
            },
            comment_id: {
                type: String,
                required: true
            },
            projectUuid: {
                type: String,
                required: true
            },
            taskUuid: {
                type: String,
                required: true
            },
            user: {
                type: Object,
                required: true
            },
            createdAt: {
                type: String,
                required: true
            },
            content: {
                type: String,
                required: true
            },
            pinned_comment: {
                //type: Boolean,
                required: true
            },
            attachments: {
                type: Array,
                default: []
            }
        },
        data() {
            return {
                comment_content: this.content
                
            }
        },
        methods:{
            showDeleteCommentModal() {
                this.$confirm('Do you want to delete this comment permanently?').then((modal) => {
                    this.$inertia.delete(route('app:project.comments.destroy', {
                        project: this.projectUuid,
                        task: this.taskUuid,
                        comment_uuid: this.comment_id,
                    }))
                        .then(() => {
                            modal.hide();
                            this.$emit('onCommentPinned');
                        });
                });
            },
            showTaskCommentEditModal(){
                this.$refs.modal.show();

            },
            makePinned(val){
                
                this.$inertia.post(route('app:project.task.comments.store', {
                    project: this.projectUuid,
                    task: this.taskUuid
                   
                }), {
                    comment_uuid: this.comment_id,
                    task_id: this.task_id,
                    pinned_comment: true,
                    //attachments: this.attachments
                }).then(() => {
                    this.$emit('onCommentPinned');
                    this.reset();
                })
            },
            makeUnPinned(val){
                this.$inertia.post(route('app:project.task.comments.store', {
                    project: this.projectUuid,
                    task: this.taskUuid
                   
                }), {
                    comment_uuid: this.comment_id,
                    task_id: this.task_id,
                    pinned_comment: false,
                    //attachments: this.attachments
                }).then(() => {
                    this.$emit('onCommentPinned');
                    this.reset();
                })
            },
            submit() {
                //alert(this.projectUuid);
               this.$inertia.post(route('app:project.task.comments.store', {
                    project: this.projectUuid,
                    task: this.taskUuid
                }), {
                     'content': this.comment_content,
                     'comment_uuid': this.comment_id,
                   
                }).then(() => {
                   
                        this.$refs.modal.hide();
                        this.$emit('onCommentPinned');
                    
                });
            },
             hide() {
                this.$refs.modal.hide();
            },
        }
    }
</script>
<style scoped>
.my-pointer{
    cursor: pointer;
}
.pre-formatted {
  white-space: pre;
}
</style>
