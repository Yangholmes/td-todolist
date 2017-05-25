<template>
  <div class="board">
    <h1>今年任务</h1>
    <ul>
      <li>
        <div class="task">
          <div class="content">
            <h2 class="task-name">任务一</h2>
            <div class="task-info">
              <p class="schedule-date">计划完成：<span>05/12/2017</span></p>
              <el-rate class="rate"
                v-model="value4"
                :colors="['#99A9BF', '#F7BA2A', '#FF9900']">
              </el-rate>
            </div>
          </div>
          <div class="create-date">5/22</div>
        </div>
        <div class="toolbar">

        </div>
      </li>
      <li></li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'board',
  data() {
      return {
        value4: null
      }
    }
}
</script>

<style>
.board{
  height: 100%; width: 100%;
}
.board h1{
  font-size: 1em;
  font-weight: normal;
  text-align: center;
  margin: 0 auto; padding: 0;
  width: calc( 100% - 2em );
}
.board ul{
  margin: 0 auto; padding: 0;
  list-style: none;
  height: calc( 100% - 1em );
  width: calc( 100% - 2em );
}
.board ul li .task{
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.schedule-date,
.rate
{
  display: inline-block;
}
</style>
