/* jshint esversion: 6 */
import Vue from 'vue'
import VueRouter from 'vue-router'
import Yang from 'yangjs'

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'

import App from './App.vue'

Vue.use(VueRouter)
Vue.use(Yang)
Vue.use(ElementUI)

import routes from './routes.js'
const router = new VueRouter({
  mode: 'history',
  // base: 'dashboard',
  base: __dirname,
  routes // （缩写）相当于 routes: routes
})

new Vue({
  router ,
  render: h => h(App)
}).$mount('#app');
