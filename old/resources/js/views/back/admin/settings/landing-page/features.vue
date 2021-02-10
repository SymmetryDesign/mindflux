<template>
    <div class="flex flex-col bg-white rounded-lg shadow mb-6">
        <div class="px-4 py-5 sm:p-6">
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-no-wrap">
                <div class="ml-4 mt-2">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        {{ $trans('headings.features') }}
                    </h3>
                </div>

                <div class="ml-4 mt-2 flex-shrink-0">
                    <button @click.prevent="showAddFeatureModal()" type="button" class="btn text-indigo-600 btn-link">
                        {{ $trans('labels.add-feature') }}
                    </button>
                </div>
            </div>
        </div>

        <div class="pb-4">
            <ul v-if="features.length > 0">
                <li v-for="feature in features">
                    <div class="flex items-center px-4 py-5 sm:p-6 ease-in-out duration-150 hover:bg-gray-50">
                        <div class="min-w-0 flex-1 flex items-center">
                            <div class="min-w-0 flex-1 md:grid md:grid-cols-1 md:gap-4">
                                <div class="hidden md:block">
                                    <div>
                                        <div class="leading-5 text-gray-900 font-medium">
                                            {{ feature.title }}
                                        </div>

                                        <div class="mt-2 flex items-center text-sm leading-5 text-gray-500 truncate mr-4">
                                            {{ feature.description }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <a @click.prevent="showEditFeatureModal(feature)" class="text-gray-400 hover:text-gray-500" href="#">
                                    <svg class="w-4 h-4 fill-current" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path fill="currentColor" d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z"></path>
                                    </svg>
                                </a>

                                <a @click.prevent="showDeleteFeatureModal(feature)" class="text-gray-400 hover:text-gray-500 ml-3" href="#">
                                    <svg class="w-4 h-4 fill-current ml-3" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>

            <v-empty v-else :message="$trans('messages.no-data-to-show-here')"></v-empty>
        </div>
    </div>
</template>

<script>
    import VAddFeatureModal from '@/views/back/admin/settings/landing-page/modal-feature-add'
    import VEditFeatureModal from '@/views/back/admin/settings/landing-page/modal-feature-edit'
    import VEmpty from '@/views/common/empty'

    export default {
        components: {
            VAddFeatureModal,
            VEmpty
        },

        props: {
            features: {
                type: Array,
                required: true
            }
        },

        methods: {
            showAddFeatureModal() {
                this.$modal(VAddFeatureModal);
            },

            showEditFeatureModal(feature) {
                this.$modal(VEditFeatureModal, {
                    id: feature.id,
                    title: feature.title,
                    description: feature.description
                });
            },

            showDeleteFeatureModal(feature) {
                this.$confirm(this.$trans('messages.delete-this-feature'), {
                    confirmButtonText: this.$trans('labels.delete'),
                }).then(modal => {
                    this.$inertia.delete(route('admin:landing-page-features.destroy', {feature: feature.id}))
                        .then(() => modal.hide());
                });
            }
        }
    }
</script>
