<?php

header("Content-type: text/html; charset=utf-8");
ini_set('display_errors', '1');
error_reporting(E_ALL ^ E_NOTICE);

if (get_magic_quotes_gpc()) {
 function stripslashes_deep($value){
  $value = is_array($value) ?
  array_map('stripslashes_deep', $value) :
  stripslashes($value);
  return $value;
 }
 $_POST = array_map('stripslashes_deep', $_POST);
 $_GET = array_map('stripslashes_deep', $_GET);
 $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
}
define('APP_NAME', 'cms');
define('CONF_PATH','./Conf/');
define('TMPL_PATH','./tpl/');
$GLOBALS['_beginTime'] = microtime(TRUE);
define('MEMORY_LIMIT_ON',function_exists('memory_get_usage'));
define('CORE','./');
if(MEMORY_LIMIT_ON) $GLOBALS['_startUseMems'] = memory_get_usage();
define('APP_PATH','./PigCms/');
defined('APP_PATH') 	or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']).'/');
define('RUNTIME_PATH','./Conf/logs/');
defined('RUNTIME_PATH') or define('RUNTIME_PATH',APP_PATH.'Runtime/');
define('APP_DEBUG',1);
defined('APP_DEBUG') 	or define('APP_DEBUG',false);
$runtime = defined('MODE_NAME')?'~'.strtolower(MODE_NAME).'_runtime.php':'~runtime.php';
defined('RUNTIME_FILE') or define('RUNTIME_FILE',RUNTIME_PATH.$runtime);
if(!APP_DEBUG && is_file(RUNTIME_FILE)) {
    require RUNTIME_FILE;
}else{
    defined('THINK_PATH') or define('THINK_PATH', dirname(__FILE__).'/');
    require THINK_PATH.'Common/runtime.php';
}
App::init();
Vendor("wxpay.WxPayPubHelper.WxPayPubHelper");
Log::write("TEST",'DEBUG');
//使用通用通知接口
$notify = new Notify_pub();
//存储微信的回调   
$xml = $GLOBALS['HTTP_RAW_POST_DATA'];	
$notify->saveData($xml);
$log_name = LOG_PATH."weixin_notify.log";//log文件路径
Log::write("执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."\n【接收到的notify通知】:\n".$xml."\n",'INFO','',$log_name);
//验证签名，并回应微信。
//对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
//微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
//尽可能提高通知的成功率，但微信不保证通知最终能成功。
if($notify->checkSign() == FALSE){
	$notify->setReturnParameter("return_code","FAIL");//返回状态码
	$notify->setReturnParameter("return_msg","签名失败");//返回信息
	Log::write("执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."【签名失败】:\n".$xml."\n",'INFO','',$log_name);
}else{
	if ($notify->data["return_code"] == "FAIL") {
		//此处应该更新一下订单状态，商户自行增删操作
		Log::write("执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."【通信出错】:\n".$xml."\n",'INFO','',$log_name);
	}
	elseif($notify->data["result_code"] == "FAIL"){
		//此处应该更新一下订单状态，商户自行增删操作
		Log::write("执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."【业务出错】:\n".$xml."\n",'INFO','',$log_name);
	}
	else{
		//此处应该更新一下订单状态，商户自行增删操作
		$out_trade_no = $notify->data["out_trade_no"]; //本地订单号
		$attach = $notify->data["attach"];
		$attacharray = explode('|',$attach);
		$payHandel=new payHandle($attacharray[0],$attacharray[1]);//0:token,1:from
		$orderInfo=$payHandel->afterPay($out_trade_no,'');
		$from=$payHandel->getFrom();

		//订单处理
		$order = M('product_cart')->where(array('orderid'=>$out_trade_no))->find();
		if($order['setInc']==0){
			$userInfo = M('Distribution_member')->where(array('token' => $attacharray[0], 'wecha_id' => $order['wecha_id']))->find();
			distriOrderStatus($attacharray[0],$order['id'],1);
			/*if($userInfo['fid']!=0){
				M('Distribution_member')->where(array('token' => $attacharray[0], 'id' => $userInfo['fid']))->setInc('orderNums');//一级订单累加
			}
			if($userInfo['sid']!=0){
				M('Distribution_member')->where(array('token' => $attacharray[0], 'id' => $userInfo['sid']))->setInc('orderNums');//二级订单累加
			}
			if($userInfo['tid']!=0){
				M('Distribution_member')->where(array('token' => $attacharray[0], 'id' => $userInfo['tid']))->setInc('orderNums');//三级订单累加
			}*/
			$orderNums = M('product_cart')->where(array('wecha_id'=>$order['wecha_id'],'token'=>$attacharray[0],'paid'=>1))->count();
			if($orderNums==1){
				$dataDistri['beDistri'] = 1;
				M('product_cart')->where(array('orderid'=>$out_trade_no,'token'=>$attacharray[0]))->save($dataDistri);
			}
			if($userInfo['distritime']==0){
				$datas['distritime'] = time();
				M('Distribution_member')->where(array('wecha_id' => $order['wecha_id'], 'token' => $attacharray[0]))->save($datas);
			}
			//个人消息推送
			$access_token = get_access_token($attacharray[0]);
			$data = '{"touser":"'.$order['wecha_id'].'","msgtype":"text","text":{"content":"亲：您已成功付款，等候签收宝贝吧！"}}';
			$result = api_notice_increment('https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token,$data);
			//上级消息推送
			infoSend($attacharray[0],$order['id'],$out_trade_no,$access_token);
			M('product_cart')->where(array('orderid'=>$out_trade_no))->setField('setInc',1);
		}
		Log::write("执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."【支付成功】:\n".$xml."\n",'INFO','',$log_name);
	}
	$notify->setReturnParameter("return_code","SUCCESS");//设置返回码
}
$returnXml = $notify->returnXml();
echo $returnXml;

	/**
	 * distriOrderStatus
	 */
	function distriOrderStatus($token,$order_id,$status) {
		$condition['order_id'] = $order_id;
		$condition['token'] = $token;
		$data['status'] = $status;
		$db = M('Distribution_ordermoney');
		$db->where($condition)->save($data);
	}
	function infoSend($token,$orderid,$order_id,$access_token) {
		$condition['order_id'] = $orderid;
		$condition['token'] = $token;
		$db = M('Distribution_ordermoney');
		$orders = $db->where($condition)->select();
		foreach($orders as $key=>$value){
			$wecha_id = M('Distribution_member')->where('id='.$value['mid'])->getField('wecha_id');
			//$wecha_id = 'o3mw-s2byHCb4QnPLFQlI-6vsOQo';
			$url = "<a href='".C('site_url')."/index.php?g=Wap&m=Distribution&a=followOrder&token=".$token."&wecha_id=".$wecha_id."'>查看</a>";
			$data = '{"touser":"'.$wecha_id.'","msgtype":"text","text":{"content":"订单['.$order_id.']新增推广佣金+'.sprintf("%.2f",$value['offerMoney']/100).'元['.$url.']"}}';
			api_notice_increment('https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token,$data);
		}
	}
	function get_access_token($token){
		if($token!=''&&preg_match('/^[0-9a-zA-Z]{3,42}$/', $token)){
			$access_token = M('access_token')->where(array('token'=>$token))->find();
			if($access_token){
				$access_str = get_new_access_token($token);
				$data['access_token'] = $access_str;
				$data['updatetime'] = time();
				M('access_token')->where(array('token'=>$token))->save($data);
			}else{
				$access_str = get_new_access_token($token);
				$data['token'] = $token;
				$data['access_token'] = $access_str;
				$data['updatetime'] = time();
				M('access_token')->add($data);
			}
			return $access_str;
		}
	}
	function get_new_access_token($token){
		$wxuser = D('Wxuser')->where(array('token' => $token))->find();
		$rt = curlGet('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $wxuser['appid'] . '&secret=' . $wxuser['appsecret']);
        $jsonrt = json_decode($rt, 1);
		return $jsonrt['access_token'];
	}
	function api_notice_increment($url, $data){
		$ch = curl_init();
		$header = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$tmpInfo = curl_exec($ch);
		$errorno=curl_errno($ch);
		if ($errorno) {
			return array('rt'=>false,'errorno'=>$errorno);
		}else{
			$js=json_decode($tmpInfo,1);
			if ($js['errcode']=='0'){
				return array('rt'=>true,'errorno'=>0);
			}else {
				//$this->error('发生错误：错误代码'.$js['errcode'].',微信返回错误信息：'.$js['errmsg']);
				Log::write('发生错误：错误代码'.$js['errcode'].',微信返回错误信息：'.$js['errmsg'].'openid='.$data->touser,'ERR');
			}
		}
	}
	function curlGet($url)
    {
        $ch = curl_init();
        $header = 'Accept-Charset: utf-8';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $temp = curl_exec($ch);
        return $temp;
    }
?>