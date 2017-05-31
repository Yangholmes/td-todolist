<template>
  <div id="app">
    <router-view></router-view>
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
  *{
      font-family: "Microsoft Yahei","Lucida Grande","Lucida Sans Unicode",Helvetica,Arial,Verdana,sans-serif;
      font-size: 100%;
      /*color: black;*/
      margin: 0; padding: 0;
  }
  html,
  body,
  #app {
    width: 100%; height: 100%;
  }
  #app {
    background-color: #EBEBEB;
  }
</style>
