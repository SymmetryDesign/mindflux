<template>
    <v-modal ref="modal">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
          

            <v-tabs>
                <v-tab :name="$trans('headings.add-jamboard')" active>
                    <div class="flex flex-col px-6 pt-6 pb-6">
                        <div class="mb-6">
                            <div class="form-group">
                                <label for="project-name" class="form-label">{{ $trans('labels.url') }}</label>
                                <input id="project-name" class="form-input" :placeholder="$trans('placeholders.project-jamboardURL')" v-model="form.jamboard_url">
                                <p class="invalid-feedback" v-if="$page.errors.has('project-jamboardURL')">{{ $page.errors.first('project-jamboardURL') }}</p>
                            </div>
                        </div>

                       

                       

                       

                      
                    </div>
                </v-tab>

               
            </v-tabs>

            <div class="bg-gray-50 p-4 sm:px-6 sm:py-4 sm:flex sm:flex-row-reverse">
                <button type="button" class="btn btn-indigo" @click="submit()" :disabled="form.processing">
                    {{ $trans('labels.save-url') }}
                </button>

                <button type="button" class="btn btn-flat mr-3" @click="hide()">
                    {{ $trans('labels.cancel') }}
                </button>
            </div>
        </div>
    </v-modal>
</template>

<script>
    import VInputColor from '@/components/input-color'
    import VInputDate from '@/components/input-date'
    import VModal from '@/components/modal'
    import VRenderlessSelect from '@/components/renderless/select'
    import {Tab as VTab, Tabs as VTabs} from '@/components/tabs'
    import Form from '@/utils/form'

    export default {
        components: {
            VInputColor,
            VInputDate,
            VModal,
            VTabs,
            VTab,
            VRenderlessSelect,
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
           
           
            userUuid: {
                type: String,
                default: null
            },
            
            
        },

        data() {
            return {
                form: new Form({
                    jamboard_url: '',
                })
            }
        },

        mounted() {
            this.form.name = this.$page.project.name;
            this.form.description = this.$page.project.description;
            this.form.timeline = this.$page.project.timeline;
            this.form.color = this.$page.project.color;
            this.form.visibility = this.$page.project.visibility;
            this.form.team_members = this.$page.project.team_members;
        },

        methods: {
            show() {
                this.$refs.modal.show();
            },

            hide() {
                this.$refs.modal.hide();
            },

            submit() {
                //alert(this.projectUuid);
                this.$inertia.put(route('app:project.tasks.update', {
                    project: this.projectUuid,
                    task: this.taskUuid
                }), {
                    // 'content': this.task.content,
                    // 'due_date': this.task.due_date,
                    // 'is_completed': this.task.is_completed,
                    // 'user_uuid': this.task.user_uuid,
                    // 'priority': this.task.priority,
                    'jamboard_url': this.form.jamboard_url,
                }).then(() => {
                    this.form.processing = false;

                    if (this.$page.errors.none()) {
                        this.hide();
                    }
                });
            }
        }
    }
</script>
