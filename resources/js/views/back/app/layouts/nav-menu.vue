<template>
    <div class="h-0 flex-1 flex flex-col pb-4 overflow-y-auto">
        <div class="flex items-center flex-shrink-0 bg-gray-900 py-4 px-4 mb-4">
            <inertia-link :href="route('app:dashboard')">
                <img class="h-8 w-auto select-none" :src="$page.logo_dark" alt="logo"/>
            </inertia-link>
        </div>

        <div class="flex-shrink-0 flex px-6 pt-1">
            <inertia-link :href="route('app:profile.edit')" class="flex-shrink-0 group block focus:outline-none">
                <div class="flex items-center">
                    <div>
                        <img class="inline-block h-9 w-9 rounded-full" :src="$page.user.avatar_url" :alt="$page.user.name"/>
                    </div>

                    <div class="ml-3">
                        <p class="text-sm leading-5 font-medium text-white">
                            {{ $page.user.name }}
                        </p>

                        <p class="text-xs leading-4 font-medium text-gray-400 group-hover:text-gray-300 group-focus:underline transition ease-in-out duration-150">
                            {{ $trans('labels.profile-settings') }}
                        </p>
                    </div>
                </div>
            </inertia-link>
        </div>

        <nav class="mt-5 bg-gray-800">
            <inertia-link
                :href="route('app:dashboard')"
                :class="[ route().current('app:dashboard') ? 'text-white bg-gray-900' : 'text-gray-300']"
                class="group mb-1 flex items-center px-6 py-2 text-sm leading-6 focus:outline-none focus:bg-gray-700 hover:text-white hover:bg-gray-700 transition ease-in-out duration-150"
            >
                <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current mr-3">
                    <path d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm-5.6-4.29a9.95 9.95 0 0 1 11.2 0 8 8 0 1 0-11.2 0zm6.12-7.64l3.02-3.02 1.41 1.41-3.02 3.02a2 2 0 1 1-1.41-1.41z"></path>
                </svg>

                {{ $trans('labels.dashboard') }}
            </inertia-link>

            <inertia-link
                :href="route('app:projects.index')"
                :class="[ route().current('app:projects.index') ? 'text-white bg-gray-900' : 'text-gray-300']"
                class="group mb-1 flex items-center px-6 py-2 text-sm leading-6 focus:outline-none focus:bg-gray-700 hover:text-white hover:bg-gray-700 transition ease-in-out duration-150"
            >
                <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current mr-3">
                    <path d="M10 1l10 6-10 6L0 7l10-6zm6.67 10L20 13l-10 6-10-6 3.33-2L10 15l6.67-4z"></path>
                </svg>

                {{ $trans('labels.projects') }}
            </inertia-link>
            

            <inertia-link
                :href="route('app:tasks.index')"
                :class="[ route().current('app:tasks.index') ? 'text-white bg-gray-900' : 'text-gray-300']"
                class="group mb-1 flex items-center px-6 py-2 text-sm leading-6 focus:outline-none focus:bg-gray-700 hover:text-white hover:bg-gray-700 transition ease-in-out duration-150"
            >
                <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current mr-3">
                    <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM6.7 9.29L9 11.6l4.3-4.3 1.4 1.42L9 14.4l-3.7-3.7 1.4-1.42z"></path>
                </svg>

                {{ $trans('labels.my-tasks') }}
            </inertia-link>
            
            
            <a target="_blank" href="https://jamboard.google.com/" class="group mb-1 flex items-center px-6 py-2 text-sm leading-6 focus:outline-none focus:bg-gray-700 hover:text-white hover:bg-gray-700 transition ease-in-out duration-150 text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current mr-3">
                    <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a1.964 1.964 0 0 0-.453-.618A5.984 5.984 0 0 1 2 6zm3 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5z"/>
                </svg>

                Jamboard Changed
            </a>
            

            <inertia-link
                :href="route('app:calendar.index')"
                :class="[ route().current('app:calendar.index') ? 'text-white bg-gray-900' : 'text-gray-300']"
                class="group mb-1 flex items-center px-6 py-2 text-sm leading-6 focus:outline-none focus:bg-gray-700 hover:text-white hover:bg-gray-700 transition ease-in-out duration-150"
            >
                <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current mr-3">
                    <path d="M1 4c0-1.1.9-2 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4zm2 2v12h14V6H3zm2-6h2v2H5V0zm8 0h2v2h-2V0zM5 9h2v2H5V9zm0 4h2v2H5v-2zm4-4h2v2H9V9zm0 4h2v2H9v-2zm4-4h2v2h-2V9zm0 4h2v2h-2v-2z"></path>
                </svg>

                {{ $trans('labels.calendar') }}
            </inertia-link>
        </nav>

        <nav class="flex flex-col flex-1 mt-3 bg-gray-800">
            <div class="px-6 mb-2">
                <span class="text-sm text-gray-500 font-semibold">
                    {{ $trans('labels.favorites') }}
                </span>
            </div>

            <inertia-link
                :key="project.uuid"
                :href="route('app:projects.show', {project: project.uuid})"
                class="group mb-1 flex items-center px-6 py-2 text-sm leading-6 text-gray-300 focus:outline-none focus:bg-gray-700 hover:text-white hover:bg-gray-700 transition ease-in-out duration-150"
                v-for="project in $page.favorite_projects"
            >
                <div class="w-3 h-3 overflow-hidden rounded-full mr-3">
                    <div class="w-full h-full" :class="['bg-' + project.color + '-400']"></div>
                </div>
                {{ project.name }}
            </inertia-link>
        </nav>

        <nav>
            <inertia-link :href="route('app:users.index')" class="group flex items-center px-6 py-2 text-sm leading-6 text-gray-300 focus:outline-none focus:bg-gray-700 hover:text-white hover:bg-gray-700 transition ease-in-out duration-150">
                <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current mr-3">
                    <path d="M3.94 6.5L2.22 3.64l1.42-1.42L6.5 3.94c.52-.3 1.1-.54 1.7-.7L9 0h2l.8 3.24c.6.16 1.18.4 1.7.7l2.86-1.72 1.42 1.42-1.72 2.86c.3.52.54 1.1.7 1.7L20 9v2l-3.24.8c-.16.6-.4 1.18-.7 1.7l1.72 2.86-1.42 1.42-2.86-1.72c-.52.3-1.1.54-1.7.7L11 20H9l-.8-3.24c-.6-.16-1.18-.4-1.7-.7l-2.86 1.72-1.42-1.42 1.72-2.86c-.3-.52-.54-1.1-.7-1.7L0 11V9l3.24-.8c.16-.6.4-1.18.7-1.7zM10 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
                </svg>

                {{ $trans('labels.settings') }}
            </inertia-link>

            <a :href="route('logout')" class="group flex items-center px-6 py-2 text-sm leading-6 text-gray-300 focus:outline-none focus:bg-gray-700 hover:text-white hover:bg-gray-700 transition ease-in-out duration-150">
                <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current mr-3">
                    <path d="M0 10a10 10 0 1 1 20 0 10 10 0 0 1-20 0zm2 0a8 8 0 1 0 16 0 8 8 0 0 0-16 0zm8-2h5v4h-5v3l-5-5 5-5v3z"></path>
                </svg>

                {{ $trans('labels.logout') }}
            </a>
        </nav>
    </div>
</template>
