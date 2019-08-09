/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Vue from 'vue'

Vue.component('App', require('./App.vue').default);

import '@mdi/font/css/materialdesignicons.min.css'

import router from './router'
import vuetify from './plugins/vuetify';
import axios from 'axios'

import {store} from './store';
import {apiUrl} from "./config";

Vue.config.productionTip = false;
Vue.prototype.$http = axios;
Vue.prototype.$apiUrl = apiUrl;

/* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    store,
    vuetify,
    template: '<App/>',
})
