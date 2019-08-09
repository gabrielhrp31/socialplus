// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import vuetify from './plugins/vuetify';
import axios from 'axios'

import 'roboto-fontface/css/roboto/roboto-fontface.css'
import '@mdi/font/css/materialdesignicons.min.css'

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
  components: { App },
  vuetify,
  template: '<App/>'
});
