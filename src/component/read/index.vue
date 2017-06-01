<template>
  <div class="read">
    <board id="board"></board>
    <history  v-for="(item,index) in historys" :key="index" :history="item"></history>
    <div style="text-align:center;color: #adadad;font-size: .8em; height: 2em; line-height: 2em;">
      <span @click="loadMore()">点击加载</span></div>
  </div>
</template>

<script>
import board from '../modules/board.vue'
import history from '../modules/history.vue'
export default {
  data () {
    return {
      historys: [{
          id:'5',
          date: '2017/5/5',
          checkList: ['本地'],
          dailys: [{
              content: '11111',
              status: 1
          },
          {
              content: '2222',
              status: 0
          }]
      }]
    }
  },
  components: {
    history,
    board
  },
  methods:{
    loadMore:function(){
      let array=[{
          id:'1',
          date: '2017/5/5',
          checkList: ['本地'],
          dailys: [{
              content: '11111',
              status: 1
          },
          {
              content: '2222',
              status: 0
          }]
      },
      {
          id:'2',
          date: '2017/5/6',
          checkList: ['外勤'],
          dailys: [{
              content: '11111',
              status: 1
          },
          {
              content: '2222',
              status: 0
          }]
      },
      {
          id:'3',
          date: '2017/5/7',
          checkList: ['本地','加班'],
          dailys: [{
              content: '11111',
              status: 1
          },
          {
              content: '2222',
              status: 0
          }]
        }
      ];
      for(var i=0; i < array.length; i++){
        console.log(i);
        this.historys.push(array[i]);
      }
    }
  }
}
</script>

<style>
.read {
    padding: 1.5em;
    background-color: #EBEBEB;
}
#board{
  margin-bottom: 1.5em;
}
</style>
