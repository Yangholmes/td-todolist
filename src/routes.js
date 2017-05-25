/* jshint esversion: 6 */
import index from './component/index/index.vue'
import note  from './component/note/index.vue'
import read  from './component/read/index.vue'

const routes = [
  {
    path: '/',
    redirect: '/index'
  },
  {
    path: '/index',
    component: index,
    name: 'index'
  },
  {
    path: '/note',
    component: note,
    name: 'note'
  },
  {
    path: '/read',
    component: read,
    name: 'read'
  }
]

export default routes
