<template>
  <div class="read">
    <header class="read-component-header">
      <span @touchend.prevent="watchSelf">看自己</span>
      <span @touchend.prevent="popupWatchOther">看别人</span>
      <watch-other-popup v-if="watchOtherPopupVisible" @watchOther="watchOther"></watch-other-popup>
    </header>

    <!-- 看板 -->
    <board id="board" :operate="false"></board>
    <hr>
    <!-- 日志 -->
    <history  v-for="(item,index) in historys" :key="index" :history="item"></history>
    <div style="text-align:center;color: #adadad;font-size: .8em; height: 2em; line-height: 2em; margin: 1em auto">
      <span @click="loadMore">点击加载</span>
    </div>
  </div>
</template>

<script>
import board from '../modules/board.vue'
import history from '../modules/history.vue'
import watchOtherPopup from '../modules/watch-other-popup.vue'
export default {
  data () {
    return {
      historys: [{attendance:{
          id:'1',
          createDate: '2017/5/5',
          attendance: ['1'],

      },dailys: [{
          content: '11111',
          status: 1
      },
      {
          content: '2222',
          status: 0
      }]}
    ],
      watchOtherPopupVisible: false,
    }
  },
  components: {
    history,
    board,
    watchOtherPopup
  },
  methods:{
    loadMore:function(){
      let array=[{attendance:{
          id:'1',
          createDate: '2017/5/5',
          attendance: ['1'],

      },dailys: [{
          content: '11111',
          status: 1
      },
      {
          content: '2222',
          status: 0
      }]},
      {attendance:{
          id:'2',
          createDate: '2017/5/6',
          attendance: ['1'],

      },dailys: [{
          content: '11111',
          status: 1
      },
      {
          content: '2222',
          status: 0
      }]},
      {attendance:{
          id:'3',
          createDate: '2017/5/7',
          attendance: ['1'],

      },dailys: [{
          content: '11111',
          status: 1
      },
      {
          content: '2222',
          status: 0
      }]},
      ];
      for(var i=0; i < array.length; i++){
        console.log(i);
        this.historys.push(array[i]);
      }
    },
    watchSelf () {

    },
    popupWatchOther () {
      this.watchOtherPopupVisible = !this.watchOtherPopupVisible;
    },
    watchOther (other) {
      this.watchOtherPopupVisible = false;
      console.log(other);
    }
  }
}
</script>

<style>
.read {
    padding: 2.5em 1em 1em 1em;
    background-color: #EBEBEB;
}

header.read-component-header {
    z-index: 999;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: auto;
    display: flex;
    justify-content: space-around;
    box-sizing: border-box;
    border-bottom: 1px solid #d1dbe5;
    background: rgba(255, 255, 255, .9);
    color: rgba(80, 175, 250, 1);
    text-align: center;
}
header.read-component-header span {
  display: inline-block;
  font-size: 1em;
  line-height: 2em;
  width: 100%;
  border-right: 1px solid #d1dbe5;
}
header.read-component-header span:last-child {
  border: none;
}
header.read-component-header span:active {
  background: rgba(220, 220, 220, .9);
}
#board{
  /*margin-bottom: 1.5em;*/
}
hr{
  margin: 1em auto;
  border: none;
  display: block;
  width: 100%;
  height: 1px;
  background: rgba(120, 120, 120, 0.4);
}
</style>
