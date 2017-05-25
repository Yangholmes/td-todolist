<template>
  <entry></entry>
</template>

<script>
import entry from '../modules/entry.vue'

export default {
  data () {
    return {}
  },
  components: { // 注册组件，这很重要
    entry // 相当于 entry: entry
  }
}
</script>

<style>

</style>
