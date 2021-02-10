import Vue from 'vue'
import {InertiaApp} from "@inertiajs/inertia-vue";
import VueMeta from 'vue-meta'

const plugins = [
    InertiaApp,
    VueMeta,
];

plugins.forEach(plugin => {
    Vue.use(plugin);
});

export {
    InertiaApp
}
