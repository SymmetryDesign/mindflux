<template>
    <nav>
        <inertia-link
            :href="route('app:profile.edit')"
            :class="{ 'bg-white' : route().current('app:profile.edit') }"
            class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white font-semibold transition duration-150"
        >
            {{ $trans('labels.edit-profile') }}
        </inertia-link>

        <inertia-link
            :href="route('app:password.edit')"
            :class="{ 'bg-white' : route().current('app:password.edit') }"
            class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white font-semibold transition duration-150"
        >
            {{ $trans('labels.change-password') }}
        </inertia-link>

        <inertia-link
            :href="route('app:email-notifications.edit')"
            :class="{ 'bg-white' : route().current('app:email-notifications.edit') }"
            class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white font-semibold transition duration-150"
        >
            {{ $trans('labels.email-notifications') }}
        </inertia-link>

        <inertia-link
            :href="route('app:system-preferences.edit')"
            :class="{ 'bg-white' : route().current('app:system-preferences.edit') }"
            class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white font-semibold transition duration-150"
        >
            {{ $trans('labels.system-preferences') }}
        </inertia-link>
    </nav>
</template>
