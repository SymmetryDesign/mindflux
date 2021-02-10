<template>
    <div class="flex flex-col">
        <div class="flex flex-col items-center" v-if="attachments.length === 0">
            <v-empty-view :message="$trans('messages.no-data-to-show-here')"/>
        </div>

        <ul v-if="attachments.length > 0">
            <li class="pl-3 pr-2 py-3 flex items-center justify-between text-sm leading-5 rounded-lg mb-1 hover:bg-gray-100" v-for="attachment in attachments">
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
</template>

<script>
    import VEmptyView from '@/views/common/empty'

    export default {
        components: {
            VEmptyView
        },

        props: {
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
                attachments: []
            }
        },

        mounted() {
            this.getAttachments();
        },

        methods: {
            getAttachments() {
                axios.get(route('app:project.task.attachments.index', {
                    project: this.projectUuid,
                    task: this.taskUuid
                })).then((response) => {
                    this.attachments = response.data;
                })
            }
        }
    }
</script>
