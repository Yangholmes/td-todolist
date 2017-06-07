<template>
  <div class="watch-other-popup">
    <div class="watch-other-popup-main">

      <header class="watch-other-popup-header">
        <h1>想看谁？</h1>
      </header>

      <div class="watch-other-popup-content">
        <div class="input-field colleague-field">
          <div class="open-colleague-picker picker" @touchend="openDatePicker"></div>
          <label class="input-field-label">选择同事</label>
          <input type="text" placeholder="点击选择同事" v-model="user">
        </div>
        <div class="input-field date-field">
          <div class="open-date-picker picker" @touchend="openDatePicker"></div>
          <label class="input-field-label">选择日期</label>
          <input type="text" placeholder="点击选择日期" v-model="date">
        </div>
      </div>

      <footer class="watch-other-popup-footer">
        <div class="button button-cancel" @touchend="cancel">取消</div>
        <div class="button button-confirm" @touchend="confirm">确定</div>
      </footer>

    </div>

    <div class="watch-other-popup-mask mask" @touchend="cancel"></div>

  </div>
</template>

<script>
export default {
  data () {
    return {
      user: null,
      date: null
    }
  },
  methods: {
    openDatePicker (){
      // 引入钉钉后可用
      // dd.biz.contact.choose({
      //      startWithDepartmentId: -1, //-1表示打开的通讯录从自己所在部门开始展示, 0表示从企业最上层开始，(其他数字表示从该部门开始:暂时不支持)
      //      multiple: false, //是否多选： true多选 false单选； 默认true
      //      users: null, //默认选中的用户列表，userid；成功回调中应包含该信息
      //      disabledUsers: null, // 不能选中的用户列表，员工userid
      //      corpId: window._config.corpId, //企业id
      //      // max: , //人数限制，当multiple为true才生效，可选范围1-1500
      //      limitTips: "挑太多啦！", //超过人数限制的提示语可以用这个字段自定义
      //      isNeedSearch: true, // 是否需要搜索功能
      //      title: "挑个人呗~", // 如果你需要修改选人页面的title，可以在这里赋值
      //      local: "false", // 是否显示本地联系人，默认false
      //      onSuccess: function(data) {
      //        // todo
      //        this.user = data;
      //      },
      //      onFail: function(err) {
      //        // todo
      //      }
      // });
    },
    openDatePicker () {
      // 引入钉钉后可用
      // dd.biz.util.datetimepicker({
      //   format: 'yyyy-MM-dd',
      //   value: '', //默认显示
      //   onSuccess : function(result) {
      //     this.date = result.value;
      //   },
      //   onFail : function() {
      //
      //   }
      // });
    },
    cancel () {
      this.$emit('watchOther', null);
    },
    confirm () {
      let other = {user: this.user, date: this.date};
      this.$emit('watchOther', other);
    }
  }
}
</script>

<style>
.watch-other-popup {
  display: block;
  color: black;
  text-align: left;;
}
.watch-other-popup-main{
  position: fixed;
  justify-content: flex-start;
  z-index: 9999;
  width: calc( 100% - 1em );
  /*height: calc( 100% - 1em );*/
  left: .5em; top: 20%;
  background: rgba(255, 255, 255, 1);
  /*padding: .5em 1em;*/
  border-radius: 10px;
  box-shadow: 1px 0 5px hsla(0,0%,59%,.9);
}
.watch-other-popup{
  /*display: none;*/
}
.watch-other-popup-main > * {
  margin: 0 1em;
}

header.watch-other-popup-header h1{
  margin: .5em 0;
  font-size: 1.25em;
}

.watch-other-popup-content{

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
.picker{
  position: absolute;
  width: calc( 100% - 2em ); height: 1.5em;
  background: rgba(100, 100, 100, .5);
}

footer.watch-other-popup-footer{
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

.watch-other-popup-mask {
  display: block;
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(100, 100, 100, .7);
  z-index: 998;
}
</style>
