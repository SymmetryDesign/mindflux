<template>
    <v-renderless-select
        :items="users"
        mode="single"
        item-text="name"
        item-value="uuid"
        v-model="selectedUser"
        toggle-select
        @input="$emit('input', selectedUser)"
    >
        <div class="flex items-center" slot-scope="{ items : users, search, isSelected, select, selected }">
            <v-dropdown :placement="placement">
                <template v-slot:button>
                    <slot name="button" v-bind="{ selected }">
                        <a @click.prevent="" href="#" class="flex items-center text-xs text-gray-600 hover:underline">
                            <svg class="w-4 h-4 mr-1.5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M2 6H0v2h2v2h2V8h2V6H4V4H2v2zm7 0a3 3 0 0 1 6 0v2a3 3 0 0 1-6 0V6zm11 9.14A15.93 15.93 0 0 0 12 13c-2.91 0-5.65.78-8 2.14V18h16v-2.86z"/>
                            </svg>

                            <span v-if="selected">{{ selected.name }}</span>
                            <span v-else>{{ $trans('labels.assign-user') }}</span>
                        </a>
                    </slot>
                </template>

                <template v-slot:content>
                    <div class="dropdown-menu w-64">
                        <div class="flex flex-col">
                            <div class="px-4 pt-4 mb-2">
                                <input class="form-input" :placeholder="$trans('placeholders.search')" @input="search($event.target.value)">
                            </div>

                            <div class="w-64 overflow-y-auto" style="height: 220px">
                                <a href="#" class="dropdown-item flex items-center" v-for="user in users" :key="user.id" @click.prevent="select(user)">
                                    <div class="flex-shrink-0 flex items-center">
                                        <div v-if="selected && selected.uuid === user.uuid" class="inline-flex w-6 h-6 justify-center items-center text-xs bg-green-400 text-white rounded-full">
                                            <svg class="w-3 h-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/>
                                            </svg>
                                        </div>

                                        <img v-else class="avatar avatar-xs" :src="user.avatar_url" alt="avatar">
                                    </div>

                                    <div class="text-sm leading-5 text-gray-700 group-hover:text-gray-900 truncate pl-4">
                                        {{ user.name }}
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </template>
            </v-dropdown>
        </div>
    </v-renderless-select>
</template>

<script>
    import VRenderlessSelect from '@/components/renderless/select'
    import VDropdown from '@/components/dropdown'

    export default {
        components: {
            VRenderlessSelect,
            VDropdown
        },

        props: {
            value: {
                type: [Array, String, Number],
                default: null
            },
            users: {
                type: Array,
                default: []
            },
            placement: {
                type: String,
                default: 'left-0'
            }
        },

        data() {
            return {
                selectedUser: this.value
            }
        },

        watch: {
            value(val) {
                this.selectedUser = val;
            }
        }
    }
</script>
