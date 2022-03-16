require('./bootstrap');


import Vue from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'
Vue.mixin({
    methods: {
        route: window.route,
    }
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

// createInertiaApp({
//     resolve: name => require(`./Pages/${name}`),
//     setup({
//         el,
//         App,
//         props
//     }) {
//         new Vue({
//             render: h => h(App, props),
//         }).$mount(el)
//     },
// })

InertiaProgress.init({
    delay: 250,
    color: '#1E377F',
    includeCSS: true,
    showSpinner: true,
});