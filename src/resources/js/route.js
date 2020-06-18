import Router from 'vue-router'
import UserComponent from './components/UserComponent.vue'
import UserDetailComponent from './components/UserDetailComponent.vue'
import UserEditComponent from './components/UserEditComponent.vue'
import UserCreateComponent from './components/UserCreateComponent.vue'

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/user',
      name: 'user',
      component: UserComponent
    },
    {
      path: '/user/create',
      name: 'user_create',
      component: UserCreateComponent
    },
    {
      path: '/user/:id',
      name: 'user_detail',
      component: UserDetailComponent
    },
    {
      path: '/user/:id/edit',
      name: 'user_edit',
      component: UserEditComponent
    },

  ]
});