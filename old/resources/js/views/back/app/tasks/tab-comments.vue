<template>
    <div class="flex flex-col">
        <v-task-comment-editor
            :task-uuid="taskUuid"
            :project-uuid="projectUuid"
            @submitted="onCommentSubmitted"
        />

        <div class="flex flex-col mt-2">
            <div class="flex flex-col items-center" v-if="comments.length === 0">
                <v-empty-view :message="$trans('messages.no-data-to-show-here')"/>
            </div>

            <div v-else>
                <v-task-comment
                    :key="comment.uuid"
                    :user="comment.user"
                    :content="comment.content"
                    :attachments="comment.attachments"
                    :created-at="comment.created_at"
                    :project-uuid="projectUuid"
                    :task-uuid="taskUuid"
                    v-for="comment in comments"
                />
            </div>
        </div>
    </div>
</template>

<script>
    import VTab from '@/components/tabs'
    import VEmptyView from '@/views/common/empty'
    import VTaskCommentEditor from '@/views/back/app/tasks/task-comment-editor'
    import VTaskComment from '@/views/back/app/tasks/task-comment'

    export default {
        components: {
            VTab,
            VEmptyView,
            VTaskCommentEditor,
            VTaskComment
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
        },

        data() {
            return {
                comments: []
            }
        },

        mounted() {
            this.getComments();
        },

        methods: {
            onCommentSubmitted() {
                this.getComments();
                this.$emit('new-comment')
            },

            getComments() {
                axios.get(route('app:project.task.comments.index', {
                    task: this.taskUuid,
                    project: this.projectUuid
                })).then(response => {
                    this.comments = response.data;
                });
            }
        }
    }
</script>
