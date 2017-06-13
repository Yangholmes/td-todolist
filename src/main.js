/* jshint esversion: 6 */
import Vue from 'vue'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'

// import ElementUI from 'element-ui'
// import 'element-ui/lib/theme-default/index.css'
import {
  Button, Rate, Icon, Checkbox, Tag, Card, Radio, Form, Message, Dialog, CheckboxGroup, FormItem, Input, RadioGroup
} from 'element-ui'

import './css/daily.css'
import App from './App.vue'

Vue.use(VueRouter)
Vue.use(VueResource)
// Vue.use(ElementUI)
Vue.use(Button)
Vue.use(Rate)
Vue.use(Icon)
Vue.use(Checkbox)
Vue.use(Tag)
Vue.use(Card)
Vue.use(Radio)
Vue.use(Form)
Vue.use(Dialog)
Vue.use(CheckboxGroup)
Vue.use(FormItem)
Vue.use(Input)
Vue.use(RadioGroup)

Vue.prototype.$message = Message

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
