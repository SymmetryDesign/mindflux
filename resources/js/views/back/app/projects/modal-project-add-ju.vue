<template>
    <v-modal ref="modal">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
          

            <v-tabs>
                <v-tab :name="$trans('headings.add-jamboard')" active>
                    <div class="flex flex-col px-6 pt-6 pb-6">
                        <div class="mb-6">
                            <div class="form-group">
                                <label for="project-name" class="form-label">{{ $trans('labels.url') }}</label>
                                <input id="project-name" class="form-input" :placeholder="$trans('placeholders.project-jamboardURL')" v-model="form.url">
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

        data() {
            return {
                form: new Form({
                    url: '',
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
                this.form.processing = true;

                this.$inertia.put(route('app:projects.update', {project: this.$page.project.uuid}), {
                    name: this.form.name,
                    description: this.form.description,
                    timeline: this.form.timeline,
                    color: this.form.color,
                    visibility: this.form.visibility,
                    team_members: this.form.team_members
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
