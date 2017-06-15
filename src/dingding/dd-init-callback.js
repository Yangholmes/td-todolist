/* jshint esversion: 6 */
import Yang from 'yangjs'

((global, ddInit) => {
  const yang = new Yang();
  yang.ajax(HOST+'/php/verification/auth.php', {'dataType': 'application/json'}).then((res)=>{
    // 预处理response
    ddInit(global, JSON.parse(res.response));
  }, (res)=>{
    alert('身份验证失败');
  });
})(window, (global, _config)=>{
  console.log(_config);
  global.dd._config = _config; // dd配置的全局变量
  global.dd._user   = {};

  /**
   * jsapi权限验证配置
   * global.dd._config 是保存dd配置的全局变量
   */
  dd.config({
      agentId: _config.agentId[0], // this app ID
      corpId: _config.corpId[0],
      timeStamp: _config.timeStamp,
      nonceStr: _config.nonceStr,
      signature: _config.signature, // jsapi signature
      type: 0, //选填。0表示微应用的jsapi,1表示服务窗的jsapi。
      jsApiList: [ // 需要调用的jsapi列表
          'runtime.info',
          'biz.contact.choose',
          'device.notification.confirm',
          'device.notification.alert',
          'device.notification.prompt',
          'biz.ding.post',
          'biz.util.openLink',
          'ui.pullToRefresh.enable',
          'ui.pullToRefresh.stop',
          'biz.util.openLink',
          'biz.navigation.setLeft',
          'biz.navigation.setTitle',
          'biz.navigation.setRight'
      ]
  }); // jsapi permission

  /**
   * 钉钉入口
   */
  dd.ready( function(){

    // 获取容器信息
    dd.runtime.info({
        onSuccess: function(info) {
            console.log('runtime info: ' + JSON.stringify(info));
        },
        onFail: function(err) {
            console.log('fail: ' + JSON.stringify(err));
        }
    }); // runtime info

    /**
     * 导航栏设置
     */
    dd.biz.navigation.setMenu({
        items: [{
            "id": "1",
            "text": "写日志",
        }],
        onSuccess (data) {
        },
        onFail (err) {
        }
    });
  });

  dd.error( (err) => {
    alert('错误信息: ' + JSON.stringify(err));
  });
});
