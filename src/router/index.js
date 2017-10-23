import Vue from 'vue'
import Router from 'vue-router'
import VueResource from 'vue-resource'
import Events from '@/components/Event/Events'
import CreateEvent from '@/components/Event/CreateEvent'
import Login from '@/components/User/Login'
import Register from '@/components/User/Register'

Vue.use(Router)
Vue.use(VueResource)

Vue.http.headers.common['Authorization'] = 'Bearer ' + localStorage.token;
Vue.http.options.root = 'http://localhost:8000/api/';

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Events',
      component: Events
    },
    {
      path: '/new',
      name: 'CreateEvent',
      component: CreateEvent
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/register',
      name: 'Register',
      component: Register
    }
  ]
})
