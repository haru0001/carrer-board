require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import router from './route.js';
import HeaderComponent from "./components/HeaderComponent";

window.Vue = Vue;

//htmlタグのように<xxxxx><xxxxx/>使用出来るようにする
Vue.component('header-component', HeaderComponent);

Vue.use(VueRouter);

const app = new Vue({
  router,
  el: '#app',
});