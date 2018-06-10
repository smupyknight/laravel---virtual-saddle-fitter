require('./../../bootstrap');

// Import Plugins
import VueRouter from 'vue-router'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css';

// Use Plugins
Vue.use(VueRouter);
Vue.use(ElementUI);

// Import Components
const MyFittersListComponent = Vue.component('my-fitters-list', require('./components/my-fitters-list.vue'));

// Resource Url
const myFittersResourceUrl = '/api/v1/client/my-fitters';

// Routing
const router = new VueRouter({
    routes: [
        {
            path: '',
            name: 'my-fitters-list',
            component: MyFittersListComponent,
            props: { myFittersResourceUrl, }
        }
    ]
});

// Init Vue
const app = new Vue({
    router: router,
    el: '#app',
});