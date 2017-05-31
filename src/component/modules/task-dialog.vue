<template>
  <el-dialog :title="task.taskName?'修改':'新建'" id="task-dialog" :visible="true" size="large" :visible.sync="taskDialogShow" @close="closetaskDialog">
    <el-form :model="task" label-width="5rem" label-position="left">
      <el-form-item label="任务名称">
        <el-input v-model="task.taskName" auto-complete="on"></el-input>
      </el-form-item>
      <el-form-item label="预计完成">
        <el-date-picker v-model="task.scheduleDate" type="date" placeholder="选一天"> </el-date-picker>
      </el-form-item>
    </el-form>
    <span slot="footer" class="dialog-footer">
      <el-button @click="closetaskDialog" @touchend="closetaskDialog">取消</el-button>
      <el-button type="primary" @click="createTask" @touchend="createTask">确认</el-button>
    </span>
  </el-dialog>
</template>

<script>
export default {
  props: ['task', 'tasks', 'taskDialogShow'],
  data () {
    return {
    }
  },
  methods: {
    createTask () {
      console.log(this.task.id);
      this.$emit('closeTaskDialog')
    },
    updateTask () {
      console.log(this.task.id);
      console.log('update');
    },
    closetaskDialog () {
      console.log('close');
      this.$emit('closeTaskDialog')
    }
  }
}
</script>

<style>
.el-form-item{
  width: 100%
}
.el-form-item__content{
  width: 13em;
}
.el-input,
.el-date-editor.el-input{
  width: 100%
}
</style>
