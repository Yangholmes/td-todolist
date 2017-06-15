<template>
  <div class="board">
    <div class="board-content">
      <div class="board-head">
        <h1>今年任务</h1>
        <div class="task-add el-icon-plus" @touchend.stop.prevent="openCreateTask" v-if="operate"></div>
      </div>
      <div class="no-task" v-if="!tasks.length"><h2>还没有任务!<span v-if="operate">新建一个吧↗</span></h2></div>
      <ul>
        <li v-for="task in tasks">
          <div class="task" @touchend="showToolbar(task)">
            <div class="content">
              <h2 class="task-name">{{task.taskName}}</h2>
              <div class="task-info">
                <p class="create-date">创建日期：<span>{{task.createDate}}</span></p>
                <p class="schedule-date">计划日期：<span>{{task.scheduleDate}}</span></p>
                <div class="rate" v-if="task.status == 1"  @touchend="rate">
                  <el-rate v-model="task.rate" :colors="['#99A9BF', '#F7BA2A', '#FF9900']">
                  </el-rate>
                </div>
              </div>
            </div>
            <img src="../../assets/finish.png" v-if="task.status==1" class="badge finish-badge">
            <img src="../../assets/cancel.png" v-if="task.status==3" class="badge cancel-badge">
            <div class="finish-date">{{task.finishDate ? task.finishDate.replace(/[0-9]{4}-/, '') : null}}</div>
          </div>
          <transition name="toggle">
            <div class="toolbar" v-if="operate && task.toolbar && task.status==0" @touchend="showToolbar(task)">
              <div class="toolbar-button toolbar-edit" @touchend="openUpdateTask(task)">修改</div>
              <div class="toolbar-button toolbar-delete" @touchend="deleteTask(task)">删除</div>
              <div class="toolbar-button toolbar-close" @touchend="cancelTask(task)">取消</div>
                <div class="toolbar-button toolbar-check" @touchend="finishTask(task)">完成</div>
            </div>
          </transition>
        </li>
      </ul>
    </div>

    <task-popup :task="task" :tasks="tasks" :taskPopupShow="taskPopupShow" @createTask="createTask" @updateTask="updateTask" @closeTaskDialog="closeTaskDialog"  v-if="taskPopupShow"></task-popup>
  </div>
</template>

<script>
// import taskPopup from './task-popup.vue'
export default {
  name: 'board',
  components: {
    taskPopup: (resolve) => require(['./task-popup.vue'], resolve)
  },
  props: ['operate', 'other'],
  mounted () {
    if(!this.other)
      this.retrieveData(_user.emplId);
    else
      this.retrieveData(this.other.user);
  },
  data() {
    return {
      taskPopupShow: false,
      task: {
        id: null,
        taskName: null,
        createDate: null,
        scheduleDate: null,
        finishDate: null,
        rate: null,
        toolbar: false,
        user: _user.emplId,
        status: 0
      },
      tasks: []
    }
  },
  watch: {
    other: {
      deep: true,
      handler: function(val, oldVal){
        console.log(val);
        this.retrieveData(val.user.emplId || val.user);
      }
    }
  },
  methods: {
    rate (task, e) {
    },
    showToolbar (task) {
      task.toolbar = !task.toolbar;
    },
    openCreateTask () {
      this.taskPopupShow = true;
    },
    openUpdateTask (task) {
      this.task = task;
      this.taskPopupShow = true;
    },
    createTask (task) {
      this.tasks.push(task);
    },
    finishTask (task) {
      this.endTask(1, task);
    },
    retrieveTask (task) {
      console.log('retrieve');
    },
    updateTask (task) {
      for(let i=0; i<this.tasks.length; i++){
        if(this.tasks[i].id == task.id)
          for( let t in this.tasks[i] ){
            if( typeof this.tasks[i][t] != 'function' )
              // console.log( this.tasks[i][r].toString() );
              this.tasks[i][t] = task[t];
          }
      }
    },
    deleteTask (task) {
      this.postData(0, {id: task.id}, (data)=>{
        if(!data.error){
          let tasks = [];
          for(let i=0; i<this.tasks.length; i++){
            if(this.tasks[i].id!=data.id){
              tasks.push( this.tasks[i] );
            }
          }
          this.tasks = tasks;
        }
      });
    },
    cancelTask (task) {
      this.endTask(3, task);
    },
    rate () {
      this.$message({ showClose: true, message: '评级功能尚未开放', type: 'warning' });
    },
    closeTaskDialog () {
      this.taskPopupShow = false;
      this.task = {
        id: null,
        taskName: null,
        createDate: null,
        scheduleDate: null,
        finishDate: null,
        rate: null,
        toolbar: false,
        user: "03424264076698",
        status: 0
      };
    },
    endTask (status, task) {
      let date = new Date(),
          temp = {};

      for( let t in task ){
        if( typeof task[t] != 'function' && t!='toolbar' )
          // console.log( task[r].toString() );
          temp[t] = task[t];
      }
      temp.finishDate = date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate();
      temp.status = status;

      this.postData(1, {task: temp}, (data)=>{
        if(data.error==0){
          for(let i=0; i<this.tasks.length; i++){
            if(this.tasks[i].id == data.task.id){
              this.tasks[i].finishDate = date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate();;
              this.tasks[i].status = status;
            }
          }
        }
      });
    },
    retrieveData (user) {
      if(!user){
        // this.$message.error({showClose: true, message: '用户参数出错!'});
        return false;
      }
      this.$http.get(HOST+'/php/task/task-retrieve.php?user='+user).then( (respones)=>{
        this.tasks = respones.data.tasks.map((task)=>{
          task.toolbar = false;
          return task
        });
      }, (respones)=>{
        this.tasks = [];
        this.$message.error({showClose: true, message: '任务模块通信失败!'});
      } );
    },
    postData (method, data, callback) {
      let that = this,
          url = method ? HOST+'/php/task/task-update.php' : HOST+'/php/task/task-delete.php';
      this.$http.post(url, data, {
              emulateJSON: true,
              headers: {
                  'Content-Type': 'enctype="application/x-www-form-urlencoded; charset=utf-8"'
              }
          }).then((response)=>{
            callback(response.data);
          }, (response)=>{
            this.$message.error({showClose: true, message: '任务模块通信失败!'});
          });
    }
  }
}
</script>

<style>
.board{
  width: 100%; height: 100%;
}
.board-content{
  background-color: white;
  height: auto; width: 100%;
  margin: 0 auto;

  border: 1px solid #d1dbe5;
  border-radius: 5px;

  box-shadow: 0 2px 4px 0 rgba(0,0,0,.12), 0 0 6px 0 rgba(0,0,0,.04);

  position: relative;
}
.board .board-head{
  margin: 0 auto; padding: .5em 0;
  width: 100%;
  text-align: center;

  border-bottom: 1px solid #d1dbe5;
  /*border: 1px solid black;
  border-bottom: none;
  border-radius: 5px 5px 0 0;*/

  /*background: rgba(0, 188, 212, .3);*/
}
.board .board-head h1{
  font-size: 1.5em;
  font-weight: normal;
  text-align: center;
  display: inline-block;
}
.board .board-head .task-add{
  position: absolute;
  background: rgba(0, 124, 255, 0.7);
  top: .5em; right: 1em;
  width: 2em; height: 2em;
  line-height: 2em;
  border-radius: 50%;
  color: white;
}

.no-task h2 {
  font-size: 100%;
  font-weight: normal;
  margin: 0 auto; padding: 0;
  text-align: center;
}

.board ul{
  margin: 0 auto; padding: 0;
  list-style: none;
  height: auto;
  width: 100%;

  /*border: 1px solid black;
  border-radius: 0 0 3px 5px;*/
}
.board ul li{
  border-bottom: 1px solid #d1dbe5;
  padding: .5em .5em;
}
.board ul li:last-child{
  border-bottom: none;
}
.board ul li .task{
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.board ul li .task h2.task-name{
  max-width: 12em;
  font-size: 1.25em;
  font-weight: normal;
}
.board ul li .task .task-info{
  font-size: .7em;
  color: gray;
}
.board ul li .task .task-info p{
  display: inline-block;
}
.board ul li .task .finish-date{
  text-align: center;
  font-size: 1em;
  width: 3em; height: 3em;
  line-height: 3em;
  color: rgba(120, 120, 120, 1);
}
.badge{
  position: absolute;
  right: .5em;
  width: 3em; height: 3em;
}

.toolbar{
  display: flex;
  justify-content: space-between;
  margin-top: .5em;
}
.toolbar .toolbar-button{
  font-size: .75em;
  color: white;
  text-align: center;
  display: inline-block;
  margin: 0;
  width: 20%; height: 2em;
  line-height: 2em;
  border-radius: 5px;
}
.toolbar .toolbar-check{
  background: #47d847;
}
.toolbar-edit{
  background: #5cabff;
}
.toolbar-delete{
  background: #ff5555;
}
.toolbar .toolbar-close{
  background: #f7db4e;
}
.toolbar i{
  color: white;
}

/* Vue动画 */
.toggle-enter-active,
.toggle-leave-active{
  transition: all .2s;
}
.toggle-enter,
.toggle-leave-active{
  opacity: 0;
}
</style>
