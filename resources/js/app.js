require('./bootstrap');

import Vue from 'vue';
import router from '@/routes/routes';
import App from '@/views/App.vue';
import { BootstrapVue } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

Vue.prototype.$http = window.axios;

Vue.use(BootstrapVue);

const app = new Vue({
    el: '#app',
    router,
    render: (h) => h(App)
});
