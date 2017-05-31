<template>
<div class="history daily">
    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <span style="line-height: 36px;">{{date}} 工作日志</span>
        </div>
        <el-checkbox-group v-model="checkList">
            <el-checkbox label="本地" disabled></el-checkbox>
            <el-checkbox label="加班" disabled></el-checkbox>
            <el-checkbox label="外勤" disabled></el-checkbox>
            <el-checkbox label="出差" disabled></el-checkbox>
        </el-checkbox-group>
        <div v-for="(o,index) in dailys" :key="index" class="text item">
            <div class="heading">任务{{ index+1 }} <i v-if="o.status" class="el-icon-check"></i><i v-else class="el-icon-more"></i></div>
            <p class="info">{{o.content}}</p>
        </div>
    </el-card>
</div>
</template>

<script>
export default {
    name: 'history',
    props: ['history'],
    created: function() {
        // `this` 指向 vm 实例
        if (this.history) {
            this.dailys = this.history.dailys ? this.history.dailys : [];
            this.date = this.history.date ? this.history.date : '';
            this.checkList = this.history.checkList ? this.history.checkList : '';
        } else {
            console.log("error");

        }
    },
    data() {
        return {
            date: '',
            checkList: [],
            dailys: []
        };
    }
}
</script>
