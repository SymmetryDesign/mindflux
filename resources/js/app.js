import Vue from 'vue'
import {InertiaApp} from "@/plugins";
import {Errors} from "@/utils/form";
import flatpickr from "flatpickr";
import lodash from 'lodash'

/**
 * Register Plugins.
 */
require('@/plugins');

/**
 * Register Vue Prototypes.
 */
require('@/prototypes');

/**
 * Register Vue Directives.
 */
require('@/directives');

/**
 * Register Route Mixin.
 */
Vue.mixin({
    methods: {
        route: window.route
    }
});

/**
 * Register flatpickr.
 */
window.flatpickr = flatpickr;

/**
 * Register lodash.
 */
window._ = lodash;

/**
 * Register Axios.
 */
window.axios = require('axios');

/**
 * Moment
 */
window.moment = require('moment');

/**
 * Initialize Vue application instance
 */
let app = document.getElementById('app');
let title = document.head.querySelector('meta[name="title"]').content;

new Vue({
    metaInfo() {
        return {
            title: 'Loading…',
            titleTemplate: '%s - ' + title
        }
    },

    render: h => h(InertiaApp, {
        props: {
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: name => import(`@/views/${name}`).then(module => module.default),
            transformProps: props => {
                return {
                    ...props,
                    errors: new Errors(props.errors),
                }
            },
        },
    }),
}).$mount(app);
