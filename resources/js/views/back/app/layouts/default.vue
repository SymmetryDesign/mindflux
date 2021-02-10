<template>
    <div id="app" class="h-screen flex overflow-hidden bg-gray-100" v-cloak>
        <!-- Mobile Menu -->
        <div class="md:hidden">
            <div @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-gray-600 opacity-0 pointer-events-none transition-opacity ease-linear duration-300"
                 :class="{'opacity-75 pointer-events-auto': sidebarOpen, 'opacity-0 pointer-events-none': !sidebarOpen}">
            </div>

            <div class="fixed inset-y-0 left-0 flex flex-col z-40 max-w-xs w-full bg-gray-800 transform ease-in-out duration-300 " :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
                <div class="absolute top-0 right-0 -mr-14 p-1">
                    <button v-if="sidebarOpen" @click="sidebarOpen = false" class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none focus:bg-gray-600">
                        <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <v-nav-menu></v-nav-menu>
            </div>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-gray-800">
                <v-nav-menu></v-nav-menu>
            </div>
        </div>

        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <div class="md:hidden pl-1 pt-1 sm:pl-3 sm:pt-3">
                <button @click.stop="sidebarOpen = true" class="-ml-0.5 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:bg-gray-200 transition ease-in-out duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            <main class="flex flex-col flex-1 relative z-0 overflow-y-auto pt-6 focus:outline-none" tabindex="0">
                <div class="flex items-center px-4 mb-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>

                <slot></slot>
            </main>
        </div>
    </div>
</template>

<script>
    import VNavMenu from '@/views/back/app/layouts/nav-menu'

    export default {
        components: {
            VNavMenu,
        },

        data() {
            return {
                sidebarOpen: false
            }
        }
    }
</script>
