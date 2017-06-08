<template>
<div class="daily">
    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <span style="line-height: 36px;">{{date}} 工作日志</span>
            <el-button type="primary" class="btn-add" @click="openDial()"><i class="el-icon-plus"></i></el-button>
        </div>
        <el-checkbox-group v-model="checkList">
            <el-checkbox label="本地"></el-checkbox>
            <el-checkbox label="加班"></el-checkbox>
            <el-checkbox label="外勤"></el-checkbox>
            <el-checkbox label="出差"></el-checkbox>
        </el-checkbox-group>
        <p v-if="!dailys.length" class="info">请增加工作内容</p>
        <div v-for="(o,index) in dailys" :key="index" class="text item toggle">
            <div class="heading">任务{{ index+1 }} <i v-if="o.status" class="el-icon-check"></i><i v-else class="el-icon-more"></i></div>
            <p class="info">{{o.content}}</p>
            <div class="text-right toggleContent">
                <i class="el-icon-edit" @click="dailyEdit(o,index)"></i>
                <i class="el-icon-delete" style="margin-left:10px;" @click="dailyDelete(index)"></i>
            </div>
        </div>
        <div v-if="dailys.length" class="text-right">
            <el-button @click="dailySubmit('checkForm')">提交</el-button>
        </div>
    </el-card>
    <el-dialog title="新增" :visible.sync="dialogVisible" size="large">
        <el-form :model="daily" :rules="rules" ref="dailyForm">
            <el-form-item label="工作内容" prop="content">
                <el-input type="textarea" autosize placeholder="请输入内容" v-model="daily.content">
                </el-input>
            </el-form-item>
            <el-form-item label="完成情况" prop="status">
                <el-radio-group v-model="daily.status">
                    <el-radio label=1>已完成</el-radio>
                    <el-radio label=0>进行中</el-radio>
                </el-radio-group>
            </el-form-item>
        </el-form>
        <span slot="footer" class="dialog-footer">
        <el-button @click="dialogVisible = false">取 消</el-button>
        <el-button type="primary" @click="addToCard('dailyForm')">确 定</el-button>
      </span>
    </el-dialog>
</div>
</template>

<script>
export default {
    name: 'daily',
    created: function() {
        // `this` 指向 vm 实例
        let currentDate = new Date();
        this.date = currentDate.getFullYear()+'/'+(currentDate.getMonth()+1)+'/'+currentDate.getDate();
    },
    data() {
        return {
            editIndex:-1,
            date: '',
            checkList: [],
            check1: {},
            dialogVisible: false,
            daily: {
                content: '',
                status: '1'
            },
            dailys: [],
            rules: {
                content: [{
                    required: true,
                    message: '请填写工作内容',
                    trigger: 'blur'
                }],
                status: [{
                    required: true,
                    message: '请选择完成情况',
                    trigger: 'change'
                }]
            }
        };
    },
    methods: {
        openDial: function() {
          this.daily.content='';//每次打开置空
          this.dialogVisible = true;
          this.editIndex=-1;//每次打开判断为增加纪录而不是编辑
        },
        addToCard: function(formName) {
          console.log(formName);
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    let i = {
                        content: this.daily.content,
                        status: parseInt(this.daily.status)
                    };
                    if(this.editIndex != -1){this.dailys.splice(this.editIndex, 1, i);}
                    else{this.dailys.push(i);}
                    this.dialogVisible = false;
                } else {
                    console.log('error submit!!');
                    return false;
                }
            });

        },
        dailyEdit: function(daily,index) {
            this.dialogVisible = true;
            this.editIndex=index;
            this.daily.content = daily.content;
            this.daily.status = daily.status + '';
        },
        dailyDelete: function(index) {
            this.dailys.splice(index, 1);
            console.log(this.dailys);
        },
        dailySubmit: function(checkForm) {
            if (this.checkList.length) {
              let param = {
                  date: this.date,
                  checkList: this.checkList,
                  dailys: this.dailys
              };
              this.$emit('dailySubmit',param);
                this.$message.success('添加日志成功！');
                this.dailys = [];
            } else {
                this.$message.error('请选择考勤');
                return false;
            }
        }
    }
}
</script>
<style>
  .toggleContent{display: none;}
  .toggle:hover .toggleContent{display: block;}
</style>
