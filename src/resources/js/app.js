
require('./bootstrap');

window.Vue = require('vue');

Vue.component('todo-component', require('./components/TodoComponent.vue').default);

const app = new Vue({
  el: '#app'
})