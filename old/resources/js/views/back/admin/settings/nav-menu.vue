<template>
    <nav>
        <inertia-link
            :href="route('admin:system-settings.edit')"
            :class="{ 'bg-white' : route().current('admin:system-settings.edit') }"
            class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white font-semibold transition duration-150"
        >
            {{ $trans('labels.system-settings') }}
        </inertia-link>

        <inertia-link
            :href="route('admin:landing-page-settings.edit')"
            :class="{ 'bg-white' : route().current('admin:landing-page-settings.edit') }"
            class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white font-semibold transition duration-150"
        >
            {{ $trans('labels.landing-page') }}
        </inertia-link>

        <inertia-link
            :href="route('admin:webhook')"
            :class="{ 'bg-white' : route().current('admin:webhook') }"
            class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white font-semibold transition duration-150"
        >
            {{ $trans('labels.gateway-webhook') }}
        </inertia-link>

        <inertia-link
            :href="route('admin:privacy-policy.edit')"
            :class="{ 'bg-white' : route().current('admin:privacy-policy.edit') }"
            class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white font-semibold transition duration-150"
        >
            {{ $trans('labels.privacy-policy') }}
        </inertia-link>

        <inertia-link
            :href="route('admin:terms-and-conditions.edit')"
            :class="{ 'bg-white' : route().current('admin:terms-and-conditions.edit') }"
            class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white font-semibold transition duration-150"
        >
            {{ $trans('labels.terms-and-conditions') }}
        </inertia-link>

        <inertia-link
            :href="route('admin:homepage-settings.edit')"
            :class="{ 'bg-white' : route().current('admin:homepage-settings.edit') }"
            class="flex items-center px-4 py-2 rounded-lg text-sm mb-1 hover:bg-white font-semibold transition duration-150"
        >
            {{ $trans('labels.homepage-settings') }}
        </inertia-link>
    </nav>
</template>
