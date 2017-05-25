<template>
  <daily></daily>
</template>

<script>
import daily from '../modules/daily.vue'

export default {
  data () {
    return {}
  },
  components: { // 注册组件，这很重要
    daily // 相当于 entry: entry
  }
}
</script>

<style>

</style>
