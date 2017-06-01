<template>
  <div id="task-popup" :class="{'task-popup': !taskPopupShow}">
    <header class="">
      {{ title }}
    </header>

    <div class="task-popup-content">
      <div class="input-field text-field">
        <label class="input-field-label">任务名称:</label>
        <input type="text" placeholder="请输入任务名称" :value="task.taskName">
      </div>
      <div class="input-field date-field">
        <div class="open-date-picker" @touchend="openDatePicker"></div>
        <label class="input-field-label">预计完成:</label>
        <input type="text" placeholder="点击选择日期">
      </div>
    </div>

    <footer class="">
      <div class="button button-cancel" @touchend="">取消</div>
      <div class="button button-confirm" @touchend="">确定</div>
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
      title: '新建',
    }
  },
  methods: {
    openDatePicker () {
      console.log('hhh');
    }
  }
}
</script>

<style>
#task-popup{
  position: absolute;
  width: calc( 100% - 2em ); height: auto;
  left: 1em;
  background: white;
  /*padding: .5em 1em;*/
}
.task-popup{
  display: none;
}

header{
  margin: .5rem 1rem;
  font-size: 1.5em;
}

.task-popup-content{
  margin: 0 1em;
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
    margin: 0 1em;
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
