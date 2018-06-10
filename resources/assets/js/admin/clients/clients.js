require('./../../bootstrap');

// Import Plugins
import VueRouter from 'vue-router'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css';

// Use Plugins
Vue.use(VueRouter);
Vue.use(ElementUI);

// Import Components
const ClientsListComponent = Vue.component('clients-list', require('./components/clients-list.vue'));
const ClientsCreateComponent = Vue.component('clients-create', require('./components/clients-create.vue'));
const ClientsViewComponent = Vue.component('clients-view', require('./components/clients-view.vue'));
const ClientsEditComponent = Vue.component('clients-edit', require('./components/clients-edit.vue'));

// Resource Url
const clientsResourceUrl = '/api/v1/admin/clients';
const riderResourceUrl = '/api/v1/admin/riders';
const horseResourceUrl = '/api/v1/admin/horses';
const saddleResourceUrl = '/api/v1/admin/saddles';

// Routing
const router = new VueRouter({
    routes: [
        {
            path: '',
            name: 'clients-list',
            component: ClientsListComponent,
            props: { clientsResourceUrl }
        },
        {
            path: '/create',
            name: 'clients-create',
            component: ClientsCreateComponent,
            props: { clientsResourceUrl }
        },
        {
            path: '/view/:id',
            name: 'clients-view',
            component: ClientsViewComponent,
            props: {
                clientsResourceUrl,
                riderResourceUrl,
                horseResourceUrl,
                saddleResourceUrl,
            }
        },
        {
            path: '/edit/:id',
            name: 'clients-edit',
            component: ClientsEditComponent,
            props: { clientsResourceUrl }
        },
    ]
});

// Init Vue
const app = new Vue({
    router: router,
    el: '#app',
});