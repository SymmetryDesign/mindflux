<template>
    <div class="h-0 flex-1 flex flex-col pb-4 overflow-y-auto">
        <div class="flex items-center flex-shrink-0 bg-gray-900 py-4 px-4 mb-4">
            <inertia-link :href="route('admin:dashboard')">
                <img class="h-8 w-auto select-none" :src="$page.logo_dark" alt="logo"/>
            </inertia-link>
        </div>

        <div class="flex-shrink-0 flex px-6 pt-1">
            <inertia-link :href="route('admin:profile.edit')" class="flex-shrink-0 group block focus:outline-none">
                <div class="flex items-center">
                    <div>
                        <img class="inline-block h-9 w-9 rounded-full" :src="$page.user.avatar_url" :alt="$page.user.name"/>
                    </div>

                    <div class="ml-3">
                        <p class="text-sm leading-5 font-medium text-white">
                            {{ $page.user.name }}
                        </p>

                        <p class="text-xs leading-4 font-medium text-gray-400 group-hover:text-gray-300 group-focus:underline transition ease-in-out duration-150">
                            {{ $trans('labels.edit-profile') }}
                        </p>
                    </div>
                </div>
            </inertia-link>
        </div>

        <nav class="mt-5 bg-gray-800">
            <inertia-link
                :href="route('admin:dashboard')"
                :class="[ route().current('admin:dashboard') ? 'text-white bg-gray-900' : 'text-gray-300']"
                class="group mb-1 flex items-center px-6 py-2 text-sm leading-6 focus:outline-none focus:bg-gray-700 hover:text-white hover:bg-gray-700 transition ease-in-out duration-150"
            >
                <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current mr-3">
                    <path d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm-5.6-4.29a9.95 9.95 0 0 1 11.2 0 8 8 0 1 0-11.2 0zm6.12-7.64l3.02-3.02 1.41 1.41-3.02 3.02a2 2 0 1 1-1.41-1.41z"></path>
                </svg>

                {{ $trans('labels.dashboard') }}
            </inertia-link>

            <inertia-link
                :href="route('admin:subscriptions.index')"
                :class="[ route().current('admin:subscriptions.index') ? 'text-white bg-gray-900' : 'text-gray-300']"
                class="group mb-1 flex items-center px-6 py-2 text-sm leading-6 focus:outline-none focus:bg-gray-700 hover:text-white hover:bg-gray-700 transition ease-in-out duration-150"
            >
                <svg class="h-4 w-4 fill-current mr-3" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M48 48a48 48 0 1 0 48 48 48 48 0 0 0-48-48zm0 160a48 48 0 1 0 48 48 48 48 0 0 0-48-48zm0 160a48 48 0 1 0 48 48 48 48 0 0 0-48-48zm448 16H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-320H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16zm0 160H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z"></path>
                </svg>

                {{ $trans('labels.subscriptions') }}
            </inertia-link>

            <inertia-link
                :href="route('admin:plans.index')"
                :class="[ route().current('admin:plans.index') ? 'text-white bg-gray-900' : 'text-gray-300']"
                class="group mb-1 flex items-center px-6 py-2 text-sm leading-6 focus:outline-none focus:bg-gray-700 hover:text-white hover:bg-gray-700 transition ease-in-out duration-150"
            >
                <svg class="h-4 w-4 fill-current mr-3" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path fill="currentColor" d="M427.84 380.67l-196.5 97.82a18.6 18.6 0 0 1-14.67 0L20.16 380.67c-4-2-4-5.28 0-7.29L67.22 350a18.65 18.65 0 0 1 14.69 0l134.76 67a18.51 18.51 0 0 0 14.67 0l134.76-67a18.62 18.62 0 0 1 14.68 0l47.06 23.43c4.05 1.96 4.05 5.24 0 7.24zm0-136.53l-47.06-23.43a18.62 18.62 0 0 0-14.68 0l-134.76 67.08a18.68 18.68 0 0 1-14.67 0L81.91 220.71a18.65 18.65 0 0 0-14.69 0l-47.06 23.43c-4 2-4 5.29 0 7.31l196.51 97.8a18.6 18.6 0 0 0 14.67 0l196.5-97.8c4.05-2.02 4.05-5.3 0-7.31zM20.16 130.42l196.5 90.29a20.08 20.08 0 0 0 14.67 0l196.51-90.29c4-1.86 4-4.89 0-6.74L231.33 33.4a19.88 19.88 0 0 0-14.67 0l-196.5 90.28c-4.05 1.85-4.05 4.88 0 6.74z"></path>
                </svg>

                {{ $trans('labels.plans') }}
            </inertia-link>

            <inertia-link
                :href="route('admin:customers.index')"
                :class="[ route().current('admin:customers.index') ? 'text-white bg-gray-900' : 'text-gray-300']"
                class="group mb-1 flex items-center px-6 py-2 text-sm leading-6 focus:outline-none focus:bg-gray-700 hover:text-white hover:bg-gray-700 transition ease-in-out duration-150"
            >
                <svg class="h-4 w-4 fill-current mr-3" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path>
                </svg>

                {{ $trans('labels.customers') }}
            </inertia-link>
        </nav>

        <nav class="mt-auto">
            <inertia-link :href="route('admin:system-settings.edit')" class="group flex items-center px-6 py-2 text-sm leading-6 text-gray-300 focus:outline-none focus:bg-gray-700 hover:text-white hover:bg-gray-700 transition ease-in-out duration-150">
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
