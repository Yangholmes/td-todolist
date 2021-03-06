<?php

/**
 * require Auth api
 */
 require_once( __DIR__.'/../../php/api/Auth.php');

/**
 * Yangholmes 2017-03-03
 */
class Msg{

  private $accessToken;
  private $request;
  private $conversationMsg;
  // message template
  private $msg = [
				 "touser"  => "",
				 "agentid" => "100844581",
				 "msgtype" => "oa",
  				 "oa" =>	[
								"message_url" => "",
								"head" => [
									// "bgcolor" => "ff4da9eb",
									"text" => "", // 向普通会话发送时有效，向企业会话发送时会被替换为微应用的名字
								],
								"body" => [
									"content" => "",
									"author" => "© 通导研发 ",
									"image"=> "",
									"rich" => [ "num" => "", "unit" => "" ],
								]
							]
				];

  /**
   * @param $accessToken: could be null.
   */
  public function __construct($accessToken = null){
    if( is_string($accessToken) )
      $this->accessToken = $accessToken;
    else {
      $auth = new Auth(0);  // debug: 1表示本地调试；0表示远程服务器。使用本地调试时，请注意修改config文件
      $this->accessToken = $auth->get_acess_token();
    }
    $this->_instance_http_request();
  }

  public function __destruct(){
    $this->request = null;
  }

  /**
   * instance http class
   */
  private function _instance_http_request(){
      $request = new yang_HTTP_request(null); //
      $request->ssl_verification(false);
      $request->set_header([
                          	"Content-Type" => "application/json",
                          	"Accept"=>"*/*",
                          	"Accept-Charset"=>"utf-8",
                          	"Content-Encoding"=>"utf-8",
                        	]);
      $this->request = $request;
      return $request;
  }

  /**
   * @param $msg: must be a associate array[]
   *  @param touser: [],
   *  @param message_url: string,
   *  @param image: string,
   *  @param rich: [ "num" => "", "unit" => "" ],
   *  @param content: string
   * Yangholmes
   */
  private function _corpMsgFilter($msg){
    if( !is_array($msg) )
      return false;
    if( !is_array($msg["touser"]) || !is_string($msg["title"]) || !is_string($msg["image"]) || !is_array($msg["rich"]) || !is_string($msg["content"]) )
      return false;

    $this->msg['touser']                    = join( '|', $msg['touser'] );
    $this->msg['oa']['message_url']         = $msg['message_url'];
    $this->msg['oa']['head']['bgcolor']     = $msg['bgcolor']?$msg['bgcolor']:"ff4da9eb";
    $this->msg['oa']['body']['title']       = $msg['title'];
    $this->msg['oa']['body']['image']       = $msg['image'];
    $this->msg['oa']['body']['content']     = $msg['content'];
    $this->msg['oa']['body']['rich'] = $msg['rich'];

    $this->conversationMsg = json_encode($this->msg);
    // echo $this->conversationMsg;
    return true;
  }

  /**
   * @param $msg: must be a associate array
   * touser, img, rich, content
   * yangholmes
   */
  public function sendMsg($msg){
    if( !$this->_corpMsgFilter($msg) )
      return false;

    $url = OAPI_HOST."/message/send?access_token=".$this->accessToken;
    $this->request->set_url($url);
    $this->request->set_data($this->conversationMsg);
    $respond = $this->request->request('POST'); // $raw_response is json
    return $respond;
  }

}


/**
 * test
 */

// $msg = new Msg(null);
// $respond = $msg->sendMsg([
// 	"title" => "这是您的新申请",
// 	"touser"  => ["03424264076698"],
// 	"message_url" => "http://www.gdrtc.org/car/page/approval.html?resid=9dJemYZp1I9YGtHgdSK4{1490316119}",
// 	"image"=> "", // 图片
// 	"rich" => "哈哈哈",
// 	"content" => "这是您的新申请这是您的新申请ff4da9eb哈哈哈哈哈",
//   "bgcolor" => "ffff0000"
// ]);

// echo $respond;
