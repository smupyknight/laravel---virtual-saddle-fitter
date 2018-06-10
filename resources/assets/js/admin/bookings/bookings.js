require('./../../bootstrap');

// Import Plugins
import VueRouter from 'vue-router'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css';

// Use Plugins
Vue.use(VueRouter);
Vue.use(ElementUI);

// Import Components
const BookingsListComponent = Vue.component('bookings-list', require('./components/bookings-list.vue'));
const BookingsCreateComponent = Vue.component('bookings-create', require('./components/bookings-create.vue'));
const BookingsViewComponent = Vue.component('bookings-view', require('./components/bookings-view.vue'));
const BookingsEditComponent = Vue.component('bookings-edit', require('./components/bookings-edit.vue'));

// Resource Url
const bookingsResourceUrl = '/api/v1/admin/bookings';
const clientsResourceUrl = '/api/v1/admin/clients';
const fittersResourceUrl = '/api/v1/admin/fitters';
const horsesResourceUrl = '/api/v1/admin/horses';

// Routing
const router = new VueRouter({
    routes: [
        {
            path: '',
            name: 'bookings-list',
            component: BookingsListComponent,
            props: {
                bookingsResourceUrl,
            }
        },
        {
            path: '/create',
            name: 'bookings-create',
            component: BookingsCreateComponent,
            props: {
                bookingsResourceUrl,
                clientsResourceUrl,
                fittersResourceUrl,
                horsesResourceUrl,
            }
        },
        {
            path: '/view/:id',
            name: 'bookings-view',
            component: BookingsViewComponent,
            props: {
                bookingsResourceUrl,
            }
        },
        {
            path: '/edit/:id',
            name: 'bookings-edit',
            component: BookingsEditComponent,
            props: {
                bookingsResourceUrl,
                clientsResourceUrl,
                fittersResourceUrl,
                horsesResourceUrl,
            }
        },
    ]
});

// Init Vue
const app = new Vue({
    router: router,
    el: '#app',
});