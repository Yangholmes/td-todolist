<template>
<div class="history daily">
    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <span style="line-height: 36px;">{{createDate}} 工作日志</span>
        </div>
        <el-checkbox-group v-model="attendance">
            <el-checkbox label="1" disabled>本地</el-checkbox>
            <el-checkbox label="2" disabled>加班</el-checkbox>
            <el-checkbox label="3" disabled>外勤</el-checkbox>
            <el-checkbox label="4" disabled>出差</el-checkbox>
        </el-checkbox-group>
        <div v-for="(o,index) in dailys" :key="index" class="text item">
            <div class="heading">任务{{ index+1 }} <i v-if="o.status == '1'" class="el-icon-check"></i><i v-else class="el-icon-more"></i></div>
            <p class="info">{{o.content}}</p>
        </div>
        <div><span v-for="o in dailyCc" class="dailycc-group" :class="o.read=='1'?'hasreaded':''">
          <span>{{o.name}}</span><span class="dailycc-read" :class="o.read=='1'?'hasreaded':''">{{o.read=='1'?'已阅':'未读'}}</span></span></div>
    </el-card>
</div>
</template>

<script>
export default {
    name: 'history',
    props: ['history'],
    data() {
        return {
            createDate: this.history.attendance.createDate ? this.history.attendance.createDate : '',
            attendance: this.history.attendance.attendance ? this.history.attendance.attendance : '',
            dailys: this.history.dailys ? this.history.dailys : [],
            dailyCc: this.history.dailyCc ? this.history.dailyCc : [],
        };
    },

}
</script>
