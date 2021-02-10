<template>
    <div class="flex flex-col rounded-lg shadow-sm border border-gray-300">
        <v-textarea-exapandable
            class="border-none shadow-none focus:outline-none focus:shadow-none rounded-lg"
            :placeholder="$trans('placeholders.write-something')"
            v-model="content"
            @input="$emit('input', content)"
        />

        <div class="mt-2 px-3 pb-3 flex items-center justify-between">
            <div>
                <button type="button" class="btn btn-sm btn-indigo" :disabled="!content || uploading" @click="submit()">
                    <svg class="w-3 h-3 mr-1.5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M0 0l20 10L0 20V0zm0 8v4l10-2L0 8z"/>
                    </svg>
                    {{ $trans('labels.send') }}
                </button>
            </div>

            <div>
                <span class="btn-group shadow-none">
                    <button type="button" class="btn btn-sm btn-flat" ref="btn_attach">
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M15 3H7a7 7 0 1 0 0 14h8v-2H7A5 5 0 0 1 7 5h8a3 3 0 0 1 0 6H7a1 1 0 0 1 0-2h8V7H7a3 3 0 1 0 0 6h8a5 5 0 0 0 0-10z"/>
                        </svg>
                    </button>
                </span>
            </div>
        </div>

        <div class="flex flex-col" ref="dz"></div>

        <!-- Attachment Preview Template -->
        <script type="text/x-template" ref="attachment">
            <div class="flex flex-col">
                <div class="pl-3 pr-4 py-3 flex items-center justify-between text-sm leading-5">
                    <div class="w-0 flex-1 flex items-center">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd"></path>
                        </svg>

                        <span class="ml-2 truncate" data-dz-name></span>
                    </div>

                    <div class="ml-4 flex-shrink-0">
                        <button type="button" class="btn btn-flat btn-xs" data-dz-remove>
                            <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 fill-current">
                                <path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="dz-progress flex w-full h-1 rounded-b-lg px-4 mb-4">
                    <span class="dz-upload block bg-indigo-200" data-dz-uploadprogress></span>
                </div>
            </div>
        </script>
    </div>
</template>

<script>
    import VTextareaExapandable from '@/components/textarea-expandable'
    import Dropzone from 'dropzone'

    export default {
        components: {
            VTextareaExapandable
        },

        props: {
            value: {
                type: String,
                default: null
            },
            taskUuid: {
                type: String,
                required: true
            },
            projectUuid: {
                type: String,
                required: true
            }
        },

        data() {
            return {
                content: this.value,
                attachments: [],
                dropzone: null,
                uploading: false
            }
        },

        watch: {
            value(val) {
                this.content = val;
            }
        },

        mounted() {
            this.dropzone = new Dropzone(this.$refs.dz, {
                clickable: this.$refs.btn_attach,
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                },
                url: route('app:project.task.attachments.store', {
                    project: this.projectUuid,
                    task: this.taskUuid
                }),
                previewTemplate: this.$refs.attachment.innerHTML
            });

            this.dropzone.on('sending', (file, xhr, formData) => {
                this.uploading = true;
                formData.append('_token', document.head.querySelector('meta[name="csrf-token"]').content)
                formData.append('uuid', file.upload.uuid);
            });

            this.dropzone.on('queuecomplete', () => {
                this.uploading = false;
            });

            this.dropzone.on('removedfile', (file) => {
                this.attachments = this.attachments.filter(attachment => {
                    return file.upload.uuid !== attachment;
                });
            });

            this.dropzone.on('success', (file, response) => {
                file.previewElement.querySelector(".dz-progress").remove();
                this.attachments.push(response.uuid);
            });
        },

        methods: {
            submit() {
                this.$inertia.post(route('app:project.task.comments.store', {
                    project: this.projectUuid,
                    task: this.taskUuid
                }), {
                    content: this.content,
                    attachments: this.attachments
                }).then(() => {
                    this.$emit('submitted');
                    this.reset();
                })
            },

            reset() {
                this.content = '';
                this.attachments = [];
                this.dropzone.removeAllFiles(true);
            }
        }
    }
</script>
