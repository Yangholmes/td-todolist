<template>
<div class="note-daily">
  <board class="board"></board>
  <div style="text-align:center;color: #adadad;font-size: .8em; height: 2em; line-height: 2em;">
    <span @click="loadMore">加载历史</span></div>
  <history  v-for="(item,index) in historys" :key="index" :history="item"></history>
  <daily v-on:dailySubmit="submit"></daily>
</div>
</template>

<script>
import daily from '../modules/daily.vue'
import history from '../modules/history.vue'
import board from '../modules/board.vue'

export default {
    data() {
        return {
            historys: []

        }
    },
    components: { // 注册组件，这很重要
        daily, // 相当于 entry: entry
        history,
        board
    },
    methods:{
      submit:function(param){
        //this.historys.splice(0,0,param);
        this.historys.push(param);
      },
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
.note-daily {
    padding: 1.5em;
    background-color: #EBEBEB;
}
</style>
