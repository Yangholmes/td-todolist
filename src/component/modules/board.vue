<template>
  <div class="board">
    <div class="board-content">
      <div class="board-head">
        <h1>今年任务</h1>
        <div class="task-add el-icon-plus" @touchend.stop.prevent="openCreateTask"></div>
      </div>
      <ul>
        <li v-for="task in tasks">
          <div class="task" @touchend="operate(task)">
            <div class="content">
              <h2 class="task-name">{{task.taskName}}</h2>
              <div class="task-info">
                <p class="create-date">创建日期：<span>{{task.createDate}}</span></p>
                <p class="schedule-date">计划日期：<span>{{task.scheduleDate}}</span></p>
                <div class="rate" v-if="task.finishDate">
                  <el-rate v-model="task.rate" :colors="['#99A9BF', '#F7BA2A', '#FF9900']">
                  </el-rate>
                </div>
              </div>
            </div>
            <img src="../../assets/finish.png" v-if="task.status==1" class="badge finish-badge">
            <img src="../../assets/cancel.png" v-if="task.status==3" class="badge cancel-badge">
            <div class="finish-date">{{task.finishDate}}</div>
          </div>
          <transition name="toggle">
            <div class="toolbar" v-if="task.operate && task.status==0">
              <div class="toolbar-button toolbar-edit" @touchend="openUpdateTask(task)">修改</div>
              <div class="toolbar-button toolbar-delete" @touchend="deleteTask(task)">删除</div>
              <div class="toolbar-button toolbar-close" @touchend="cancelTask(task)">取消</div>
                <div class="toolbar-button toolbar-check" @touchend="finishTask(task)">完成</div>
            </div>
          </transition>
        </li>
      </ul>
    </div>

    <task-popup :task="task" :tasks="tasks" :taskPopupShow="taskPopupShow" @createTask="createTask" @updateTask="updateTask" @closeTaskDialog="closeTaskDialog"  v-if="taskPopupShow" ></task-popup>
  </div>
</template>

<script>
// import taskPopup from './task-popup.vue'
export default {
  name: 'board',
  components: {
    taskPopup: (resolve) => require(['./task-popup.vue'], resolve)
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
          operate: null,
          status: 0
        },
        tasks: [{
          id: 1,
          taskName: '营业额突破2亿美金',
          createDate: '2017/01/10',
          scheduleDate: '2017/05/31',
          finishDate: '05/31',
          rate: 0,
          operate: false,
          status: 1
        },{
          id: 2,
          taskName: '利润1亿美金',
          createDate: '2017/01/10',
          scheduleDate: '2017/05/31',
          finishDate: '',
          rate: 0,
          operate: false,
          status: 0
        },{
          id: 3,
          taskName: '新开发10个客户',
          createDate: '01/10',
          scheduleDate: '2017/05/31',
          finishDate: '',
          rate: 0,
          operate: false,
          status: 0
        }]
      }
    },
  methods: {
    rate (task, e) {
    },
    operate (task) {
      task.operate = !task.operate
    },
    openCreateTask () {
      this.taskPopupShow = true;
    },
    openUpdateTask (task) {
      this.task = task;
      this.taskPopupShow = true;
    },
    createTask (task) {
      console.log(task);
      this.tasks.push(task);
    },
    finishTask (task) {
      task.operate = false;
      task.finishDate = new Date().getMonth() + '/' + new Date().getDay();
      task.status = 1;
    },
    retrieveTask (task) {
      console.log('retrieve');
    },
    updateTask (task) {
      for(let i=0;i<this.tasks.length;i++){
        if( this.tasks[i].id == task.id ){
          for( let p in this.tasks[i] ){
            if(typeof this.tasks[i][p] !== 'function')
            this.tasks[i][p] = task[p];
          }
        }
          // this.tasks[i] = task;
      }
    },
    deleteTask (task) {
      console.log('delete');
    },
    cancelTask (task) {
      task.operate = false;
      task.status = 3;
    },
    closeTaskDialog () {
      this.taskPopupShow = false;
      this.task = { taskName: null, scheduleDate: null };
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
  height: auto; width: calc( 100% - 2em );
  margin: 0 auto;

  /*border: 1px solid hsla(0,0%,59%,.9);*/
  border-radius: 5px;

  box-shadow: 1px 0 5px hsla(0,0%,59%,.9);

  position: relative;
}
.board .board-head{
  margin: 0 auto; padding: .5em 0;
  width: 100%;
  text-align: center;

  border-bottom: 1px solid hsla(0,0%,59%,.9);
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

.board ul{
  margin: 0 auto; padding: 0;
  list-style: none;
  height: auto;
  width: 100%;

  /*border: 1px solid black;
  border-radius: 0 0 3px 5px;*/
}
.board ul li{
  border-bottom: 1px solid hsla(0,0%,59%,.9);
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
  font-size: 1em;
  width: 3em; height: 3em;
  line-height: 3em;
  color: rgba(100, 100, 100, .7);
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
