<template>
  <div id="app">
    <router-link to="index" replace>入口</router-link>
    <router-link to="note">写日志</router-link>
    <router-link to="read" >查看日志</router-link>

    <router-view id="content"></router-view>
  </div>
</template>

<script>
export default {
  name: 'app',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App'
    }
  }
}
</script>

<style>

</style>
