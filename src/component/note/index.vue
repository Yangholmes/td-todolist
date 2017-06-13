<template>
<div class="note-daily">

  <board  :operate="true"></board>
  <hr>

  <div style="text-align:center;color: #adadad;font-size: .8em; height: 2em; line-height: 2em;">
    <span @click="loadMore">加载历史</span></div>
  <history  v-for="(item,index) in historys" :key="item.attendance.id" :history="item"></history>
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
            historys: [],
            isUpdate: true

        }
    },
    components: { // 注册组件，这很重要
        daily, // 相当于 entry: entry
        history,
        board
    },
    methods:{
      submit:function(param){
        console.log(param);
        //字符串转字符串数组
        var response=param.response;
        this.isUpdate=false;
        if(param.attId==0){
          response.attendance.attendance = response.attendance.attendance.split(",");
          this.historys.push(response);
        }
        else{
          for(var i=0; i<this.historys.length; i++){
            if(response.attendance.id == this.historys[i].attendance.id){
              for(var j=0; j<response.dailys.length; j++)
              this.historys[i].dailys.push(response.dailys[j]);
            }
          }
        }
        console.log(this.historys);

      },
      loadMore:function(){
        let array=[{attendance:{
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
        {attendance:{
            id:'2',
            createDate: '2017/5/6',
            attendance: ['2'],

        },dailys: [{
            content: '11111',
            status: 1
        },
        {
            content: '2222',
            status: 0
        }]},
        {attendance:{
            id:'1',
            createDate: '2017/5/5',
            attendance: ['3'],

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
          this.historys.unshift(array[i]);
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
hr{
  margin: 1em auto;
  border: none;
  display: block;
  width: 100%;
  height: 1px;
  background: rgba(120, 120, 120, 0.4);
}
</style>
