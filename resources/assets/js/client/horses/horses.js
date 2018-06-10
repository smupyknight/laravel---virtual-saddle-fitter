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
const HorsesListComponent = Vue.component('horses-list', require('./components/horses-list.vue'));
const HorsesCreateComponent = Vue.component('horses-create', require('./components/horses-create.vue'));
const HorsesViewComponent = Vue.component('horses-view', require('./components/horses-view.vue'));
const HorsesEditComponent = Vue.component('horses-edit', require('./components/horses-edit.vue'));

// Resource Url
const clientHorsesResourceUrl = '/api/v1/client/horses';
const disciplinesResourceUrl = '/api/v1/disciplines';
const breedsResourceUrl = '/api/v1/breeds';

// Routing
const router = new VueRouter({
    routes: [
        {
            path: '',
            name: 'horses-list',
            component: HorsesListComponent,
            props: {
                resourceUrl: clientHorsesResourceUrl,
            }
        },
        {
            path: '/create',
            name: 'horses-create',
            component: HorsesCreateComponent,
            props: {
                resourceUrl: clientHorsesResourceUrl,
                disciplinesResourceUrl: disciplinesResourceUrl,
                breedsResourceUrl: breedsResourceUrl,
            }
        },
        {
            path: '/view/:id',
            name: 'horses-view',
            component: HorsesViewComponent,
            props: {
                resourceUrl: clientHorsesResourceUrl,
            }
        },
        {
            path: '/edit/:id',
            name: 'horses-edit',
            component: HorsesEditComponent,
            props: {
                resourceUrl: clientHorsesResourceUrl,
                disciplinesResourceUrl: disciplinesResourceUrl,
                breedsResourceUrl: breedsResourceUrl,
            }
        },
    ]
});

// Init Vue
const app = new Vue({
    router: router,
    el: '#app',
});