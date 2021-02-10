<template>
    <v-renderless-select
        :items="priorities"
        mode="single"
        item-value="id"
        item-text="name"
        v-model="priority"
        toggle-select
        @input="$emit('input', priority)"
    >
        <div class="flex items-center" slot-scope="{ items , select, selected }">
            <v-dropdown placement="left-0">
                <template v-slot:button>
                    <slot name="button" v-bind="{ selected }">
                        <a @click.prevent href="#" class="flex items-center text-xs text-gray-600 pl-6 hover:underline">
                            <svg class="w-4 h-4 mr-1.5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M7.667 12H2v8H0V0h12l.333 2H20l-3 6 3 6H8l-.333-2z"/>
                            </svg>

                            <span v-if="selected">{{ selected.name }}</span>
                            <span v-else>{{ $trans('labels.priority') }}</span>
                        </a>
                    </slot>
                </template>

                <template v-slot:content>
                    <div class="dropdown-menu">
                        <a v-for="item in items" @click.prevent="select(item)" href="#" class="dropdown-item">
                            {{ item.name }}
                        </a>
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
                type: Number,
                default: null
            }
        },

        data() {
            return {
                priority: this.value,
                priorities: [
                    {id: 4, name: this.$trans('labels.urgent')},
                    {id: 3, name: this.$trans('labels.high')},
                    {id: 2, name: this.$trans('labels.medium')},
                    {id: 1, name: this.$trans('labels.low')}
                ]
            }
        },

        watch: {
            value(val) {
                this.priority = val;
            }
        }
    }
</script>
