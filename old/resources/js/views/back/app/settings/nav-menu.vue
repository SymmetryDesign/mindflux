<template>
    <nav>
        <inertia-link
            :href="route('app:users.index')"
            :class="{ 'bg-white' : route().current('app:users.index') }"
            class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white font-semibold transition duration-150"
        >
            {{ $trans('labels.team-members') }}
        </inertia-link>

        <inertia-link
            :href="route('app:subscription')"
            :class="{ 'bg-white' : route().current('app:subscription') }"
            class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white font-semibold transition duration-150"
        >
            {{ $trans('labels.subscription') }}
        </inertia-link>

        <inertia-link
            :href="route('app:billing-information.edit')"
            :class="{ 'bg-white' : route().current('app:billing-information.edit') }"
            class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white font-semibold transition duration-150"
        >
            {{ $trans('labels.billing-information') }}
        </inertia-link>
    </nav>
</template>
