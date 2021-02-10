<template>
    <a href="#" @click.prevent="$emit('click', task)" class="flex flex-col bg-white rounded-lg shadow mb-3 select-none focus:outline-none">
        <div v-if="task.is_completed" class="flex items-center py-2 px-4 rounded-t-lg bg-green-100 text-green-500 text-xs">
            <svg class="w-3 h-3 mr-1.5" height="100%" viewBox="0 0 20 20" width="100%">
                <g fill="none" fill-rule="evenodd">
                    <circle cx="10" cy="10" fill="currentColor" r="10"></circle>
                    <path d="M7.76 11.911L5.632 9.782a.5.5 0 0 0-.707 0l-.848.85a.5.5 0 0 0 0 .706l3.685 3.684 7.693-7.69a.5.5 0 0 0 0-.708l-.848-.848a.5.5 0 0 0-.707 0L7.76 11.91z" fill="#FFF" fill-rule="nonzero"></path>
                </g>
            </svg>

            {{ $trans('labels.completed') }}
        </div>

        <span class="text-sm p-4">
            {{ task.content }}
        </span>

        <div class="flex items-center text-xs justify-between text-gray-500 px-4 pb-4" v-if="task.due_date || task.sub_tasks.total || task.user.name !== null">
            <div class="flex items-center -mx-3">
                <div class="px-3" :class="{ 'text-red-700': task.priority === 4, 'text-orange-500' : task.priority === 3, 'text-blue-500' : task.priority === 2 }" v-if="task.priority">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="w-3 h-3 flex-shrink-0 fill-current">
                        <path d="M7.667 12H2v8H0V0h12l.333 2H20l-3 6 3 6H8l-.333-2z"></path>
                    </svg>
                </div>

                <div class="flex items-center px-3" v-if="task.due_date">
                    <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current mr-1.5">
                        <path d="M1 4c0-1.1.9-2 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4zm2 2v12h14V6H3zm2-6h2v2H5V0zm8 0h2v2h-2V0zM5 9h2v2H5V9zm0 4h2v2H5v-2zm4-4h2v2H9V9zm0 4h2v2H9v-2zm4-4h2v2h-2V9zm0 4h2v2h-2v-2z"></path>
                    </svg>

                    {{ task.due_date }}
                </div>

                <div class="flex items-center px-3" v-if="task.sub_tasks.total > 0">
                    <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current mr-1.5">
                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM6.7 9.29L9 11.6l4.3-4.3 1.4 1.42L9 14.4l-3.7-3.7 1.4-1.42z"></path>
                    </svg>

                    {{ task.sub_tasks.completed + '/' + task.sub_tasks.total }}
                </div>
            </div>

            <div class="ml-auto" v-if="task.user.name !== null">
                <img class="avatar avatar-xs" :src="task.user.avatar_url" alt="avatar">
            </div>
        </div>
    </a>
</template>

<script>
    export default {
        props: {
            task: {
                type: Object,
                required: true
            }
        }
    }
</script>
