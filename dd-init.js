;

/**
 * super global variables
 * _config  √
 * _user    √
 * _car     °
 */
var HOST = 'http://192.168.4.16/dingding/td-todolist',
    _user = {}, // user info
    _config = _config; // dd config

/**
 * jsapi权限验证配置
 * _config 是保存dd配置的全局变量
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
dd.ready(function() {

    /**
     * 容器
     */
    // 获取容器信息
    dd.runtime.info({
        onSuccess: function(info) {
            console.log('runtime info: ' + JSON.stringify(info));
        },
        onFail: function(err) {
            console.log('fail: ' + JSON.stringify(err));
        }
    }); // runtime info

    // 获取微应用免登授权码、登陆用户信息
    dd.runtime.permission.requestAuthCode({
        corpId: _config.corpId[0],
        onSuccess: function(result) {
            yang.ajax("./server/verification/get-user-info.php?access_token=" + _config.accessToken + "&code=" + result.code, {dataType: 'json', method: 'GET'})
                .then( (respond) => {
                    _user = JSON.parse(respond.response);
                }, (respond) => {
                    alert('err');
                })
        },
        onFail: function(err) {
            alert('error');
            console.log('微应用免登授权码, 错误: ', err);
        }

    });

    /**
     * 下拉刷新
     */
    dd.ui.pullToRefresh.disable();

    /**
     * 标题栏
     */
    dd.biz.navigation.setTitle({
        title: '控制台',

    }); // set navigation title

    /**
     * 导航栏设置
     */
    dd.biz.navigation.setMenu({
        items: [{
            "id": "1",
            "text": "欢迎使用",
        }],
        onSuccess: function(data) {
          switch(data.id){
            case '1':
                alert('欢迎'+_user.name);
              break;
            default:
              break;
          }
        },
        onFail: function(err) {}
    });

    /**
     * 其他业务
     */

});

dd.error(function(err) {
    console.log('错误信息: ' + JSON.stringify(err));
    alert('错误信息: ' + JSON.stringify(err));
});
