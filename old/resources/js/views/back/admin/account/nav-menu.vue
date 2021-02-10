<template>
    <nav>
        <inertia-link
            :href="route('admin:profile.edit')"
            :class="{ 'bg-white' : route().current('admin:profile.edit') }"
            class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white font-semibold transition duration-150"
        >
            {{ $trans('labels.edit-profile') }}
        </inertia-link>

        <inertia-link
            :href="route('admin:password.edit')"
            :class="{ 'bg-white' : route().current('admin:password.edit') }"
            class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white font-semibold transition duration-150"
        >
            {{ $trans('labels.change-password') }}
        </inertia-link>
    </nav>
</template>
