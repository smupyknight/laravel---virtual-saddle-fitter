require('./../../bootstrap');

// Import Plugins
import VueRouter from 'vue-router'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css';
import elementUILocale from 'element-ui/lib/locale'
import elemntUILangEn from 'element-ui/lib/locale/lang/en'

// Use Plugins
Vue.use(VueRouter);
Vue.use(ElementUI);
elementUILocale.use(elemntUILangEn);
Vue.use(ElementUI, { elemntUILangEn });

// Import Components
const SaddlesListComponent = Vue.component('saddles-list', require('./components/saddles-list.vue'));
const SaddlesCreateComponent = Vue.component('saddles-create', require('./components/saddles-create.vue'));
const SaddlesViewComponent = Vue.component('saddles-view', require('./components/saddles-view.vue'));
const SaddlesEditComponent = Vue.component('saddles-edit', require('./components/saddles-edit.vue'));

// Resource Url
const saddlesResourceUrl = '/api/v1/admin/saddles';
const horsesResourceUrl = '/api/v1/admin/horses';
const ridersResourceUrl = '/api/v1/admin/riders';
const brandsResourceUrl = '/api/v1/brands';

// Routing
const router = new VueRouter({
    routes: [
        {
            path: '',
            name: 'saddles-list',
            component: SaddlesListComponent,
            props: {
                saddlesResourceUrl,
                horsesResourceUrl,
            }
        },
        {
            path: '/create',
            name: 'saddles-create',
            component: SaddlesCreateComponent,
            props: {
                saddlesResourceUrl,
                brandsResourceUrl,
                horsesResourceUrl,
                ridersResourceUrl,
            }
        },
        {
            path: '/view/:id',
            name: 'saddles-view',
            component: SaddlesViewComponent,
            props: {
                saddlesResourceUrl,
            }
        },
        {
            path: '/edit/:id',
            name: 'saddles-edit',
            component: SaddlesEditComponent,
            props: {
                saddlesResourceUrl,
                brandsResourceUrl,
                horsesResourceUrl,
                ridersResourceUrl,
            }
        },
    ]
});

// Init Vue
const app = new Vue({
    router: router,
    el: '#app',
});