<template>
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6" v-if="links.length > 3">
        <div class="block">
            <span class="relative z-0 inline-flex shadow-sm">
                <template v-for="(link, key) in links">
                    <div :key="key" v-if="link.url === null" :class="{ 'rounded-l-md': key === 0, '-ml-px': key > 0, 'rounded-r-md': key+1 === links.length }" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" v-if="link.label === 'Previous'">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                         </svg>

                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" v-else-if="link.label === 'Next'">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>

                        <span v-else>{{ link.label }}</span>
                    </div>

                    <inertia-link v-else :key="key" :href="link.url" :class="{ 'rounded-l-md': key === 0, '-ml-px': key > 0, 'rounded-r-md': key+1 === links.length }" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" v-if="link.label === 'Previous'">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                         </svg>

                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" v-else-if="link.label === 'Next'">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>

                        <span v-else>{{ link.label }}</span>
                    </inertia-link>
                </template>
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            links: Array,
        }
    }
</script>
