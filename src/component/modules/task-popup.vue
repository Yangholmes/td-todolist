<template>
  <div id="task-popup" :class="{'task-popup': !taskPopupShow}">
    <div class="input-field text-field">
      <label class="input-field-label">任务名称:</label>
      <input type="text" placeholder="请输入任务名称">
    </div>
    <div class="input-field date-field">
      <div class="open-date-picker" @touchend="openDatePicker"></div>
      <label class="input-field-label">预计完成:</label>
      <input type="text" placeholder="点击选择日期">
    </div>

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
  width: 100%; height: 100%;
}
.task-popup{
  display: none;
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
  width: 100%; height: 1.5em;
  background: rgba(100, 100, 100, .5);
}
</style>
