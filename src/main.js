/* jshint esversion: 6 */
import Vue from 'vue'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'

import './css/daily.css'
import App from './App.vue'

Vue.use(VueRouter)
Vue.use(VueResource)
Vue.use(ElementUI)

import routes from './routes.js'
const router = new VueRouter({
  mode: 'history',
  // base: 'test/todolist',
  base: __dirname,
  routes // （缩写）相当于 routes: routes
})

new Vue({
  router ,
  render: h => h(App)
}).$mount('#app');
