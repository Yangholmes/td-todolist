<template>
  <div :class="{'task-popup': !taskPopupShow}">
    <div class="task-popup-main">
      <header class="task-popup-header">
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

      <footer class="task-popup-footer">
        <div class="button button-cancel" @touchend="cancel">取消</div>
        <div class="button button-confirm" @touchend="confirm">确定</div>
      </footer>

    </div>

    <div class="task-popup-mask mask" @touchend="cancel"></div>
  </div>
</template>

<script>
export default {
  props: ['task', 'tasks', 'taskPopupShow'],
  data () {
    return {

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
        const date = new Date();
        this.thisTask.createDate = date.getFullYear() + '/' + (date.getMonth()+1) + '/' + date.getDate();
        let task = {};
        for( let t in this.thisTask ){
          if( typeof this.thisTask[t] != 'function' && t!='toolbar' )
            // console.log( this.thisTask[r].toString() );
            task[t] = this.thisTask[t];
        }
        task.user = '03424264076698';
        // console.log(task);
        this.$http.post('http://192.168.4.16/dingding/td-todolist/php/task/task-add.php', {task: task}, {
            emulateJSON: true,
            headers: {
                'Content-Type': 'enctype="application/x-www-form-urlencoded; charset=utf-8"'
            }
        }).then((response)=>{
          task = response.data.task;
          task.toolbar = false;
          this.$emit( 'createTask', task);
          this.$emit('closeTaskDialog');
        }, (response)=>{
            alert('通信失败');
          });
      }
    }
  }
}
</script>

<style>
.task-popup-main{
  position: fixed;
  z-index: 9999;
  width: calc( 100% - 1em );
  /*height: calc( 100% - 1em );*/
  left: .5em; top: 20%;
  background: rgba(255, 255, 255, 1);
  /*padding: .5em 1em;*/
  border-radius: 3px;
  box-shadow: 1px 0 5px hsla(0,0%,59%,.9);
}
.task-popup{
  display: none;
}
.task-popup-main > * {
  margin: 0 1em;
}

header.task-popup-header h1{
  margin: .5em 0;
  font-size: 1.25em;
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

footer.task-popup-footer{
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

.task-popup-mask {
  display: block;
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(100, 100, 100, .7);
  z-index: 998;
}
</style>
