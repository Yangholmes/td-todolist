/* jshint esversion: 6 */
import index from './component/index/index.vue'
import note  from './component/note/index.vue'
import read  from './component/read/index.vue'

// 采用异步加载模式

const routes = [
  {
    path: '/',
    redirect: '/index'
  },
  {
    path: '/index',
    component: (resolve) => require(['./component/index/index.vue'], resolve),
    name: 'index'
  },
  {
    path: '/note',
    component: (resolve) => require(['./component/note/index.vue'], resolve),
    name: 'note'
  },
  {
    path: '/read',
    component: (resolve) => require(['./component/read/index.vue'], resolve),
    name: 'read'
  }
]

export default routes
