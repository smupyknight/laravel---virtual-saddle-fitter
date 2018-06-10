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
const clientsResourceUrl = '/api/v1/admin/clients';
const horsesResourceUrl = '/api/v1/admin/horses';

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
                horsesResourceUrl,
            }
        },
        {
            path: '/create',
            name: 'horses-create',
            component: HorsesCreateComponent,
            props: {
                horsesResourceUrl,
                clientsResourceUrl,
                disciplinesResourceUrl,
                breedsResourceUrl,
            }
        },
        {
            path: '/view/:id',
            name: 'horses-view',
            component: HorsesViewComponent,
            props: {
                horsesResourceUrl,
            }
        },
        {
            path: '/edit/:id',
            name: 'horses-edit',
            component: HorsesEditComponent,
            props: {
                horsesResourceUrl,
                clientsResourceUrl,
                disciplinesResourceUrl,
                breedsResourceUrl,
            }
        },
    ]
});

// Init Vue
const app = new Vue({
    router: router,
    el: '#app',
});