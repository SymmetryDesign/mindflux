<template>
    <div>
        <div class="bg-gray-50 p-6 sm:hidden">
            <select v-model="mobileTab" class="form-select" @change="setActive(mobileTab)">
                <option :value="tab" v-for="tab in tabs" :disabled="tab.disabled">{{ tab.name }}</option>
            </select>
        </div>

        <div class="hidden sm:block">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex">
                    <a
                        href="#"
                        class="flex-1 py-4 px-1 text-center border-b-2 border-transparent font-medium text-sm leading-5 text-gray-600 focus:outline-none"
                        :class="{ 'border-indigo-500 text-indigo-500 focus:text-indigo-800 focus:border-indigo-700' : tab.isVisible, 'text-gray-300 cursor-not-allowed' : tab.disabled }"
                        v-for="tab in tabs"
                        @click.prevent="setActive(tab)"
                    >
                        {{ tab.name }}
                    </a>
                </nav>
            </div>
        </div>

        <slot name="tab">
            <slot></slot>
        </slot>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tabs: [],
                mobileTab: null
            }
        },

        mounted() {
            this.tabs.forEach(tab => {
                if (tab.isVisible) {
                    this.mobileTab = tab;
                }
            })
        },

        created() {
            this.tabs = this.$children;
        },

        methods: {
            setActive(tab) {
                if (tab.disabled) {
                    return;
                }

                this.tabs.map(t => {
                    tab.id === t.id ? tab.isVisible = true : t.isVisible = false;
                });
            }
        }
    }
</script>
