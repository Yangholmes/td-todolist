<template>
<div class="daily">
    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <span style="line-height: 36px;">{{createDate}} 工作日志</span>
            <el-button type="primary" class="btn-add el-icon-plus" @click="openDial()"></el-button>
        </div>
        <el-checkbox-group v-model="attendance">
            <el-checkbox label="1">本地</el-checkbox>
            <el-checkbox label="2">加班</el-checkbox>
            <el-checkbox label="3">外勤</el-checkbox>
            <el-checkbox label="4">出差</el-checkbox>
        </el-checkbox-group>
        <p v-if="!dailys.length" class="info">请增加工作内容</p>
        <transition-group name="list" tag="div">
          <div v-for="(o,index) in dailys" :key="index" class="text item toggle">
              <div class="heading">任务{{ index+1 }} <i v-if="o.status" class="el-icon-check"></i><i v-else class="el-icon-more"></i></div>
              <p class="info">{{o.content}}</p>
              <div class="text-right toggleContent">
                  <i class="el-icon-edit" @click="dailyEdit(o,index)"></i>
                  <i class="el-icon-delete" style="margin-left:10px;" @click="dailyDelete(index)"></i>
              </div>
          </div>
        </transition-group>
        <div v-if="dailys.length" class="cc-picker-content">
          <label>抄送</label>
          <div class="cc-picker-list">
            <div  class="cc-picker-item"><el-tag type="primary">陈朝晖</el-tag></div>
            <div  class="cc-picker-item" v-for="(item,index) in ccUsers" @click="deleteCCPicker(index)" :key="index">
              <el-tag type="primary">{{item.name}}</el-tag>
            </div>
            <div @click="openCCPicker" class="cc-picker-item"><el-tag type="warning" >添加抄送人</el-tag></div>
          </div>
        </div>
        <div v-if="dailys.length" class="text-right">
            <p id="submit-tips">点击“提交”按钮后生效</p>
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
                    <el-radio label="1">已完成</el-radio>
                    <el-radio label="0">进行中</el-radio>
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
    mounted: function() {
        // `this` 指向 vm 实例
        this.currentUser = _user.emplId;
        this.$emit('loadingChange',true);
        let currentDate = new Date();
        this.createDate = currentDate.getFullYear()+'-'+(currentDate.getMonth()+1)+'-'+currentDate.getDate();
        var url = HOST+'/php/daily/daily-retrieve.php'
        var param = {
            user: this.currentUser,
            createDate:this.createDate
        };
        console.log(param);
      this.$http.post(url, param, {
          emulateJSON: true,
          headers: {
              'Content-Type': 'enctype="application/x-www-form-urlencoded; charset=utf-8"'
          }
      }).then((response)=>{
        if(response.data.error == 0 && response.data.attendance.attendance){
          this.$emit('dailySubmit',{response:response.data,attId:this.attId});
          this.attId = response.data.attendance.id;
        }
        this.$emit('loadingChange',false);
      }, (response)=>{
          this.attId = -1;
          this.$emit('loadingChange',false);
          this.$message.error({showClose: true, message: '日志模块通信失败!'});
        });


    },
    data() {
        return {
            editIndex:-1,
            createDate: '',
            attendance: [],
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
            },
            ccUsers:[],
            ccUserIds:[],
            attId:-2,//初始状态，-1初始化失败，>=0则为id
            currentUser:"",
        };
    },
    methods: {
        openDial: function() {
          this.daily.content='';//每次打开置空
          this.dialogVisible = true;
          this.editIndex=-1;//每次打开判断为增加纪录而不是编辑
        },
        addToCard: function(formName) {
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
            if (this.attendance.length) {
              if(this.attId == -1){
                this.$message.error('初始化失败，请退出重新进入');
              }else{
                this.ccUserIds.push({user:'03401659233316'}); // 加上固定的抄送人  陈总
                // this.ccUserIds.push({user:'03424264076698'}); // 加上固定的抄送人  小红
                let att=this.attendance.toString();
                var url;
                var param;
                if(this.attId==-2){
                  url = HOST+'/php/daily/daily-add.php'
                  param = {
                      attendance: {attendance:att,user:this.currentUser,createDate:this.createDate},
                      dailys: this.dailys,
                      dailyCc: this.ccUserIds
                  };
                }else{
                  url = HOST+'/php/daily/daily-update.php'
                  param = {
                      attendance: {id:this.attId,attendance:att},
                      dailys: this.dailys,
                      dailyCc: this.ccUserIds
                  };
                }
                this.$emit('loadingChange',true);
                this.$http.post(url, param, {
                    emulateJSON: true,
                    headers: {
                        'Content-Type': 'enctype="application/x-www-form-urlencoded; charset=utf-8"'
                    }
                }).then((response)=>{
                  if(response.data.error == 0){
                    this.$emit('loadingChange',false);
                    this.$message.success('添加日志成功！');
                    this.$emit('dailySubmit',{response:response.data,attId:this.attId});
                    this.attId = response.data.attendance.id;
                  }
                }, (response)=>{
                    this.$emit('loadingChange',false);
                    this.$message.error({showClose: true, message: '日志模块通信失败!'});
                  });
                  this.dailys.splice(0,this.dailys.length);
                  this.ccUsers.splice(0,this.ccUsers.length);
                  this.ccUserIds.splice(0,this.ccUserIds.length);
              }

            } else {
                this.$message.error('请选择考勤');
                return false;
            }
        },
        openCCPicker: function(){
          let that = this;
          //引入钉钉后可用
          dd.biz.contact.choose({
               startWithDepartmentId: 0, //-1表示打开的通讯录从自己所在部门开始展示, 0表示从企业最上层开始，(其他数字表示从该部门开始:暂时不支持)
               multiple: true, //是否多选： true多选 false单选； 默认true
               users: null, //默认选中的用户列表，userid；成功回调中应包含该信息
               disabledUsers: ['03401659233316'], // 不能选中的用户列表，员工userid (默认选中陈总)
               corpId: window._config.corpId, //企业id
               // max: , //人数限制，当multiple为true才生效，可选范围1-1500
               limitTips: "挑太多啦！", //超过人数限制的提示语可以用这个字段自定义
               isNeedSearch: true, // 是否需要搜索功能
               title: "挑个人呗~", // 如果你需要修改选人页面的title，可以在这里赋值
               local: "false", // 是否显示本地联系人，默认false
               onSuccess: function(data) {
                 // todo
                 data.forEach( (user, index, data)=>{
                  that.ccUsers.push(user);
                  that.ccUserIds.push({user: user.emplId});
                 } );
                 console.log(that.ccUsers, that.ccUserIds);
               },
               onFail: function(err) {
                 // todo
                 that.$message.error('非常抱歉！您的通信录打不开。。。');
               }
          });
        },
        deleteCCPicker: function(index){
          this.ccUsers.splice(index,1);
          this.ccUserIds.splice(index,1);
        }
    }
}
</script>
<style>
  .toggleContent{display: none;}
  .toggle:hover .toggleContent{display: block;}
  .daily .cc-picker-item{
    display: inline-block;
    margin: 5px 5px 5px 0;
  }
  .list-item {
    display: inline-block;
    margin-right: 10px;
  }
  .list-enter-active, .list-leave-active {
    transition: all 1s;
  }
  .list-enter, .list-leave-active {
    opacity: 0;
    transform: translateY(30px);
  }
  #submit-tips {
    font-size: .5em;
    color: gray;
  }
</style>
