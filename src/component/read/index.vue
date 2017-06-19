<template>
  <div class="read">
    <header class="read-component-header">
      <span @touchend.prevent="watchSelf">看自己</span>
      <span @touchend.prevent="popupWatchOther">看别人</span>
      <watch-other-popup v-if="watchOtherPopupVisible" @watchOther="watchOther"></watch-other-popup>
    </header>

    <!-- 看板 -->
    <board id="board" :operate="false" :other="other"></board>
    <hr>
    <div v-show="loading" class="daily-mask">
      <div class="daily-mask-text">加载中...</div>
    </div>
    <!-- 日志 -->
    <history  v-for="(item,index) in historys" :key="index" :history="item"></history>
    <div v-if="!historys.length" class="read-component-info">
      纪录为空。。。
    </div>
    <div v-if="isloadMore" class="read-component-info">
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
      historys: [],
      other: null,
      watchOtherPopupVisible: false,
      currentUser: '',
      loading:true,
      selectDate: new Date().getFullYear() + '-' + (new Date().getMonth()+1) + '-' + new Date().getDate(),
      isloadMore:true
    }
  },
  components: {
    history,
    board,
    watchOtherPopup
  },
  mounted () {
    this.currentUser = _user.emplId;
    let otherUser = localStorage.getItem('otherUser'),
        otherDate = localStorage.getItem('otherDate');
    if(otherDate&&otherUser){
      this.other = {user: otherUser, date: otherDate};
      localStorage.clear();
      this.currentUser = this.other.user;
      this.selectDate = this.other.date;
    }
    else{
      this.other = null;
    }
    this.selectARecord();
    localStorage.clear();
  },
  methods:{
    loadMore:function(){
      this.historysLoad();
    },

    watchSelf () {
      this.historys.splice(0,this.historys.length);//清空历史纪录
      this.currentUser = _user.emplId;
      this.historysLoad();
      this.isloadMore = true;
      this.other = {user: _user.emplId};
    },
    popupWatchOther () {
      console.log(_user.department);
      if( _user.department.indexOf(6584151) != -1 ){ // 按照权限打开
        this.watchOtherPopupVisible = !this.watchOtherPopupVisible;
      }
      else{
        this.$message.error({showClose: true, message: '您不是管理干部，不能随便看别人。'});
      }
    },
    watchOther (other) {
      this.watchOtherPopupVisible = false;
      this.other = other;

      this.currentUser=other ? other.user.emplId : _user.userid;
      this.selectDate=other ? other.date : new Date().getFullYear() + '-' + (new Date().getMonth()+1) + '-' + new Date().getDate();
      this.isloadMore=false;
      this.historys.splice(0,this.historys.length);//清空历史纪录
      this.selectARecord();
    },
    historysLoad: function(){
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
          this.historys.push(results[i]);
        }
      }
      this.loading=false;
    }, (response)=>{
      this.loading=false;
        this.$message.error({showClose: true, message: '日志模块通信失败!'});
      });
    },
    selectARecord: function(){
      var url = HOST+'/php/daily/daily-retrieve.php'
      var param = {
          user: this.currentUser,
          createDate:this.selectDate
      };
      console.log(param);
      this.loading=true;
    this.$http.post(url, param, {
        emulateJSON: true,
        headers: {
            'Content-Type': 'enctype="application/x-www-form-urlencoded; charset=utf-8"'
        }
    }).then((response)=>{
      if(response.data.error == 0){
        if(!response.data.attendance.attendance){
          this.$message({message: '已经没有纪录了哦',type: 'warning'});
        }else{
          response.data.attendance.attendance = response.data.attendance.attendance.split(",");
          this.historys.push(response.data);
        }
      }
      this.loading=false;
    }, (response)=>{
        this.loading=false;
        this.$message.error({showClose: true, message: '日志查询失败!'});
      });
    },
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
.read-component-info{
  text-align:center;
  color: #adadad;
  font-size: .8em;
  height: 2em;
  line-height: 2em;
  margin: 1em auto
}
</style>
