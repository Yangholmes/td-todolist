<template>
  <div class="board">
    <div class="board-head">
      <h1>今年任务</h1>
      <div class="task-add el-icon-plus" @touchend=""></div>
    </div>
    <ul>
      <li v-for="task in tasks">
        <div class="task" @touchend="operate(task)">
          <div class="content">
            <h2 class="task-name">{{task.taskName}}</h2>
            <div class="task-info">
              <p class="schedule-date">计划完成：<span>{{task.scheduleDate}}</span></p>
              <p class="finish-date">完成日期：<span>{{task.finishDate}}</span></p>
              <div class="rate" @touchend="rate(task, $event)" @click.stop="operate(task)">
                <el-rate v-model="task.rate" :colors="['#99A9BF', '#F7BA2A', '#FF9900']">
                </el-rate>
              </div>
            </div>
          </div>
          <div class="create-date">{{task.createDate}}</div>
        </div>
        <transition name="toggle">
          <div class="toolbar" v-if="task.operate">
            <el-button class="" size="mini" type="info" icon="edit"></el-button>
            <el-button class="" size="mini" type="danger" icon="delete"></el-button>
            <el-button class="" size="mini" type="success" icon="check"></el-button>
            <el-button class="" size="mini" type="warning" icon="close"></el-button>
          </div>
        </transition>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'board',
  data() {
      return {
        tasks: [{
          id: 1,
          taskName: '营业额突破2亿美金',
          createDate: '01/10',
          scheduleDate: '2017/05/31',
          finishDate: '2017/05/31',
          rate: 0,
          operate: false,
        },{
          id: 2,
          taskName: '利润1亿美金',
          createDate: '01/10',
          scheduleDate: '2017/05/31',
          finishDate: '2017/05/31',
          rate: 0,
          operate: false,
        },{
          id: 3,
          taskName: '新开发10个客户',
          createDate: '01/10',
          scheduleDate: '2017/05/31',
          finishDate: '2017/05/31',
          rate: 0,
          operate: false,
        }]
      }
    },
  methods: {
    rate (task, e) {
    },
    operate (task) {
      task.operate = !task.operate
    }
  }
}
</script>

<style>
.board{
  height: auto; width: calc( 100% - 2em );
  margin: 0 auto;

  border: 1px solid hsla(0,0%,59%,.9);
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
.board ul li .task .create-date{
  font-size: 1em;
  color: gray
}

.toolbar{
  display: flex;
  justify-content: space-between;
  margin-top: .5em;
}
.toolbar .el-button{
  margin: 0;
  width: 20%
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
