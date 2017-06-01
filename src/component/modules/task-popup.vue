<template>
  <div id="task-popup" :class="{'task-popup': !taskPopupShow}">
    <header class="">
      <h1>{{ title }}</h1>
    </header>

    <div class="task-popup-content">
      <div class="input-field text-field">
        <label class="input-field-label">任务名称:</label>
        <input type="text" placeholder="请输入任务名称" v-model="thisTask.taskName">
      </div>
      <div class="input-field date-field">
        <div class="open-date-picker" @touchend="openDatePicker"></div>
        <label class="input-field-label">预计完成:</label>
        <input type="text" placeholder="点击选择日期" v-model="thisTask.scheduleDate">
      </div>
    </div>

    <footer class="">
      <div class="button button-cancel" @touchend="cancel">取消</div>
      <div class="button button-confirm" @touchend="confirm">确定</div>
    </footer>

    <!-- <div class="date-time-picker">
      <div class="date-time-picker-toolbar">
        <span class="date-time-picker-toolbar-cancel">取消</span>
        <span class="date-time-picker-toolbar-confirm">确定</span>
      </div>
      <div class="date-time-picker-items">
      </div>
    </div> -->

  </div>
</template>

<script>
export default {
  props: ['task', 'tasks', 'taskPopupShow'],
  data () {
    return {
      // thisTask: {
        // id: this.task.id,
        // taskName: this.task.taskName,
        // scheduleDate: this.task.scheduleDate
      // },
      // title: '新建'
    }
  },
  computed: {
    title () {
      return this.task.id ? '修改' : '新建';
    },
    thisTask (){
      let task = {};
      for( let p in this.task ){
        if(typeof this.task[p] !== 'function')
        task[p] = this.task[p];
      }
      return task;
    }
  },
  methods: {
    openDatePicker () {
      // 引入钉钉后可用
      // dd.biz.util.datetimepicker({
      //   format: 'yyyy-MM-dd',
      //   value: '', //默认显示
      //   onSuccess : function(result) {
      //     result.value
      //   },
      //   onFail : function() {
      //
      //   }
      // });
    },
    cancel () {
      this.$emit('closeTaskDialog');
    },
    confirm () {
      if( this.thisTask.id ){
        this.$emit( 'updateTask', this.thisTask );
        this.$emit('closeTaskDialog');
      }
      else{
        this.thisTask.createDate = new Date();
        this.$emit( 'createTask', this.thisTask );
        this.$emit('closeTaskDialog');
      }
    }
  }
}
</script>

<style>
#task-popup{
  position: absolute;
  width: 100%; height: 100%;
  left: 0; top: 0;
  background: rgba(255, 255, 255, 1);
  /*padding: .5em 1em;*/
  border-radius: 10px;
  box-shadow: 1px 0 5px hsla(0,0%,59%,.9);
}
.task-popup{
  display: none;
}
#task-popup > * {
  margin: 0 1em;
}

header h1{
  margin: .5em 0;
  font-size: 1.5em;
}

.task-popup-content{

}
.input-field{
  margin: .5em auto;
}
.input-field-label{
  display: inline-block;
  width: 5em;
}
.input-field input{
  border: none;
  background: rgba(255, 255, 255, 0);
  outline: none
}
.date-field .open-date-picker{
  position: absolute;
  width: calc( 100% - 2em ); height: 1.5em;
  background: rgba(100, 100, 100, .5);
}

footer{
  display: flex;
  justify-content: flex-end;
}
.button{
  /*color: white;*/
  font-size: 1em;
  display: inline-block;
  width: 5em; height: 2em;
  line-height: 2em;
  border-radius: 5px;
  text-align: center;
  box-sizing:border-box;
  margin: .5em .5em;
}
.button-cancel{
  border: 1px solid black;
}
.button-confirm{
  background: #5cabff;
}
</style>
