<template>
<div class="note-daily">

  <board  :operate="true"></board>
  <hr>
<div v-show="loading" class="daily-mask">
  <div class="daily-mask-text">加载中...</div>
</div>
  <div style="text-align:center;color: #adadad;font-size: .8em; height: 2em; line-height: 2em;">
    <span @click="loadMore">加载历史</span></div>
  <history v-for="(item, index) in historys" :key="item.attendance.id" :history="item"></history>
  <daily v-on:dailySubmit="submit"  v-on:loadingChange="loadingChange"></daily>

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
            isUpdate: true,
            currentUser: '',
            loading: false

        }
    },
    components: { // 注册组件，这很重要
        // daily: (resolve) => require(['../modules/daily.vue'], resolve),
        daily,
        history,
        board
    },
    mounted:function () {
      console.log('mounted', new Date());
      this.currentUser = _user.emplId;
    },
    methods:{
      submit:function(param){
        //字符串转字符串数组
        var response=param.response;
        this.isUpdate=false;
        if(param.attId==-2){
          response.attendance.attendance = response.attendance.attendance.split(",");
          this.historys.push(response);
        }
        else{
          for(var i=0; i<this.historys.length; i++){
            if(response.attendance.id == this.historys[i].attendance.id){
              this.historys[i].dailys.splice(0,this.historys[i].dailys.length);
              for(var j=0; j<response.dailys.length; j++)
              {
                this.historys[i].dailys.push(response.dailys[j]);
              }
              this.historys[i].dailyCc.splice(0,this.historys[i].dailyCc.length);
              for(var k=0; k<response.dailyCc.length; k++)
              {
                this.historys[i].dailyCc.push(response.dailyCc[k]);
              }
            }
          }
        }
      },
      loadMore:function(){
        this.loading=true;
        var param;
        if(this.historys.length){
          param={user:this.currentUser,offset:this.historys.length};
        }
        else{
          param={user:this.currentUser,offset:0};
        }
        var url = HOST+'/php/daily/daily-loadhistory.php'
      this.$http.post(url, param, {
          emulateJSON: true,
          headers: {
              'Content-Type': 'enctype="application/x-www-form-urlencoded; charset=utf-8"'
          }
      }).then((response)=>{
        if(response.data.error == 0){
          var results = response.data.results;
          if(!results.length){
            this.$message({message: '已经没有纪录了哦',type: 'warning'});
          }
          for(var i=0; i<results.length; i++)
          {
            results[i].attendance.attendance=results[i].attendance.attendance.split(",");
            this.historys.unshift(results[i]);
          }
        }
         this.loading=false;
      }, (response)=>{
        this.loading=false;
          this.$message.error({showClose: true, message: '日志模块通信失败!'});
        });
      },
      loadingChange:function(loading) {
        this.loading=loading
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
