/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');
import Vue from 'vue'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
Vue.component('App',require('./App.vue').default);

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('App', require('./App.vue').default);
import router from './router'
import vuetify from './plugins/vuetify';
import axios from 'axios'

import '@mdi/font/css/materialdesignicons.min.css'

import {store} from './store';
import {apiUrl} from "./config";

Vue.config.productionTip = false;
Vue.prototype.$http = axios;
Vue.prototype.$apiUrl = apiUrl;

const app = new Vue({
    el: '#app',
    router,
    store,
    vuetify,
    template: '<App/>'
});
