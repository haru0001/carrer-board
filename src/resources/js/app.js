require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import router from './route.js';

window.Vue = Vue;
Vue.use(VueRouter);

const app = new Vue({
  router,
  el: '#app',
});