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

                <div>
                    <span class="text-xs text-gray-500">{{ createdAt }}</span>
                </div>
            </div>

            <div class="mt-2">
                <p class="leading-5 text-gray-900">{{ content }}</p>
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
    </div>
</template>

<script>
    import VTaskCommentEditor from '@/views/back/app/tasks/task-comment-editor'

    export default {
        components: {
            VTaskCommentEditor
        },

        props: {
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
            attachments: {
                type: Array,
                default: []
            }
        }
    }
</script>
