require('./bootstrap');
import 'tw-elements';

import Vue from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'
import {
    ColorPicker,
    ColorPanel
} from 'one-colorpicker'
import CKEditor from 'ckeditor4-vue';
import vueCountryRegionSelect from 'vue-country-region-select'
import VueToast from 'vue-toast-notification';
import VueCompositionAPI from '@vue/composition-api'
import 'vue-toast-notification/dist/theme-sugar.css';
import moment from 'moment';
Vue.use(VueToast);
createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        Vue.use(plugin)

        new Vue({
            render: h => h(App, props),
        }).$mount(el)
    },
})
Vue.use(vueCountryRegionSelect)
Vue.use(ColorPanel)
Vue.use(ColorPicker)
Vue.mixin({
    methods: {
        route: window.route,
    }
})
Vue.use(VueCompositionAPI)
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
        formatNumber(value) {
            let val = (value / 1).toFixed(0).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        isBlock() {
            return (this.$page.props.auth.user && this.$page.props.auth.user.type == 'block') ? true : false
        },

    },
})



window.ChatterEvents = new Vue();


InertiaProgress.init({
    delay: 250,
    color: '#1E377F',
    includeCSS: true,
    showSpinner: true,
});