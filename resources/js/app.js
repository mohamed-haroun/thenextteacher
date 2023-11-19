import './bootstrap';
import '../css/app.css';

import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m';
import {createPinia} from "pinia";
import MathJax, { initMathJax, renderByMathjax } from 'mathjax-vue3'
function onMathJaxReady() {
    const el = document.body
    renderByMathjax(el)
}

initMathJax({}, onMathJaxReady)

const pinia = createPinia()

// Vuetify
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import {createVuetify} from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
    components,
    directives,
})

import DataTable from 'datatables.net-vue3'
import DataTablesLib from 'datatables.net';
import 'datatables.net-select';

DataTable.use(DataTablesLib);

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${appName} - ${title}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        return createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(vuetify)
            .use(DataTable)
            .use(pinia)
            .use(MathJax)
            .mount(el);
    },
    progress: {
        color: '#29d',
        showSpinner: true,
    },
});
