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
				 "touser"  => "03424264076698",
				 "agentid" => "100844581",
				 "msgtype" => "markdown",
				 "markdown" => [
				 					"title" => "",
				 					"text" => "",
				 				],
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
    $this->msg["markdown"]["title"] = $msg["title"];
    $this->msg["markdown"]["text"]  = $msg["text"];

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
// 	"text"  => ""
// ]);

// echo $respond;
