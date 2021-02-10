<template>
    <v-app-default-layout>
        <template v-slot:header>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $trans('headings.landing-page') }}</h1>
        </template>

        <template>
            <div class="container mx-auto px-4 sm:px-6 md:px-8 py-4">
                <div class="md:grid md:gap-6 md:grid-cols-8">
                    <div class="mb-6 sm:col-span-2">
                        <v-nav-menu/>
                    </div>

                    <div class="md:col-span-6">
                        <v-alert v-if="$page.flash" dismissible>
                            {{ $page.flash }}
                        </v-alert>

                        <v-alert variant="failure" v-if="$page.errors.has('demo.restrict')" dismissible>
                            {{ $page.errors.first('demo.restrict') }}
                        </v-alert>

                        <v-hero-settings
                            :heading="$page.hero.heading"
                            :subheading="$page.hero.subheading"
                        />

                        <v-pricing-settings
                            :heading="$page.pricing.heading"
                            :subheading="$page.pricing.subheading"
                        />

                        <v-features-settings
                            :heading="$page.features.heading"
                            :subheading="$page.features.subheading"
                        />

                        <v-features
                            :features="$page.features.data"
                        />
                    </div>
                </div>
            </div>
        </template>
    </v-app-default-layout>
</template>

<script>
    import VAppDefaultLayout from '@/views/back/admin/layouts/default'
    import VNavMenu from '@/views/back/admin/settings/nav-menu'
    import VHeroSettings from '@/views/back/admin/settings/landing-page/hero-settings'
    import VPricingSettings from '@/views/back/admin/settings/landing-page/pricing-settings'
    import VFeaturesSettings from '@/views/back/admin/settings/landing-page/features-settings'
    import VFeatures from '@/views/back/admin/settings/landing-page/features'
    import VAlert from '@/components/alert'

    export default {
        metaInfo() {
            return {
                title: this.$trans('headings.landing-page')
            }
        },

        components: {
            VAppDefaultLayout,
            VNavMenu,
            VHeroSettings,
            VPricingSettings,
            VFeaturesSettings,
            VFeatures,
            VAlert
        }
    }
</script>
