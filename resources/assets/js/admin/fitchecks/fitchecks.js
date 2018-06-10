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
const FitChecksListComponent = Vue.component('fitchecks-list', require('./components/fitchecks-list.vue'));
const FitChecksCreateComponent = Vue.component('fitchecks-create', require('./components/fitchecks-create.vue'));
const FitChecksViewComponent = Vue.component('fitchecks-view', require('./components/fitchecks-view.vue'));
const FitChecksEditComponent = Vue.component('fitchecks-edit', require('./components/fitchecks-edit.vue'));

// Resource Url
const fitchecksResourceUrl = '/api/v1/admin/fitchecks';
const ridersResourceUrl = '/api/v1/admin/riders';
const horsesResourceUrl = '/api/v1/admin/horses';
const fittersResourceUrl = '/api/v1/admin/fitters';
const clientsResourceUrl = '/api/v1/admin/clients';
const saddlesResourceUrl = '/api/v1/admin/saddles';
const drawingsResourceUrl = '/api/v1/admin/drawings';

const brandsResourceUrl = '/api/v1/brands';
const disciplinesResourceUrl = '/api/v1/disciplines';
const breedsResourceUrl = '/api/v1/breeds';

// Routing
const router = new VueRouter({
    routes: [
        {
            path: '',
            name: 'fitchecks-list',
            component: FitChecksListComponent,
            props: {
                fitchecksResourceUrl,
                ridersResourceUrl,
                horsesResourceUrl,
                fittersResourceUrl,
            }
        },
        {
            path: '/create',
            name: 'fitchecks-create',
            component: FitChecksCreateComponent,
            props: {
                fitchecksResourceUrl,
                clientsResourceUrl,
            }
        },
        {
            path: '/view/:id',
            name: 'fitchecks-view',
            component: FitChecksViewComponent,
            props: {
                fitchecksResourceUrl,
                ridersResourceUrl,
                horsesResourceUrl,
                saddlesResourceUrl,
	            drawingsResourceUrl,
                brandsResourceUrl,
                disciplinesResourceUrl,
                breedsResourceUrl,
            }
        },
        {
            path: '/edit/:id',
            name: 'fitchecks-edit',
            component: FitChecksEditComponent,
            props: {
                fitchecksResourceUrl,
                ridersResourceUrl,
                horsesResourceUrl,
                saddlesResourceUrl,
	            drawingsResourceUrl,
                brandsResourceUrl,
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