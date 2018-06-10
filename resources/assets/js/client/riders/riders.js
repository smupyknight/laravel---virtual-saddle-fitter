require('./../../bootstrap');

// Import Plugins
import VueRouter from 'vue-router'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css';

// Use Plugins
Vue.use(VueRouter);
Vue.use(ElementUI);

// Import Components
const RidersListComponent = Vue.component('riders-list', require('./components/riders-list.vue'));
const RidersCreateComponent = Vue.component('riders-create', require('./components/riders-create.vue'));
const RidersViewComponent = Vue.component('riders-view', require('./components/riders-view.vue'));
const RidersEditComponent = Vue.component('riders-edit', require('./components/riders-edit.vue'));

// Resource Url
const ridersResourceUrl = '/api/v1/client/riders';
const disciplinesResourceUrl = '/api/v1/disciplines';

// Routing
const router = new VueRouter({
    routes: [
        {
            path: '',
            name: 'riders-list',
            component: RidersListComponent,
            props: { resourceUrl: ridersResourceUrl }
        },
        {
            path: '/create',
            name: 'riders-create',
            component: RidersCreateComponent,
            props: {
                resourceUrl: ridersResourceUrl,
                disciplinesResourceUrl: disciplinesResourceUrl,
            }
        },
        {
            path: '/view/:id',
            name: 'riders-view',
            component: RidersViewComponent,
            props: { resourceUrl: ridersResourceUrl }
        },
        {
            path: '/edit/:id',
            name: 'riders-edit',
            component: RidersEditComponent,
            props: {
                resourceUrl: ridersResourceUrl,
                disciplinesResourceUrl: disciplinesResourceUrl,
            }
        },
    ]
});

// Init Vue
const app = new Vue({
    router: router,
    el: '#app',
});