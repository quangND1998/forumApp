require('./bootstrap');


import Vue from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'
import {
    ColorPicker,
    ColorPanel
} from 'one-colorpicker'
import CKEditor from 'ckeditor4-vue';
import vueCountryRegionSelect from 'vue-country-region-select'
Vue.use(vueCountryRegionSelect)
Vue.use(ColorPanel)
Vue.use(ColorPicker)
Vue.mixin({
    methods: {
        route: window.route,
    }
})
import moment from 'moment';
Vue.use(CKEditor);
Vue.mixin(require('./base'))
Vue.mixin({
    methods: {
        hasAnyPermission: function(permissions) {

            var allPermissions = this.$page.props.auth.can;
            var hasPermission = false;
            permissions.forEach(function(item) {
                if (allPermissions[item]) hasPermission = true;
            });
            return hasPermission;
        },
        formatDate: function(value) {
            if (value) {
                return moment(String(value)).format('DD/MM/YYYY HH:mm')
            }
        },

        formatDateMonth: function(value) {
            if (value) {
                return moment(String(value), "YYYY-MM-DD").format("MMM D YY")
            }
        },

    },
})


createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        Vue.use(plugin)

        new Vue({
            render: h => h(App, props),
        }).$mount(el)
    },
})
window.ChatterEvents = new Vue();


InertiaProgress.init({
    delay: 250,
    color: '#1E377F',
    includeCSS: true,
    showSpinner: true,
});