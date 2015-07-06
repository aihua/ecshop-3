<?php
/******************************************************************************
Filename       : signature.php
Author         : SouthBear
Email          : SouthBear819@163.com
Date/time      : 2014-07-11 11:14:10 
Purpose        : ΢�ſ�������֤
Description    : 
Modify         : 
******************************************************************************/
//include_once("function.php");

$str_echostr = strval(trim($_REQUEST['echostr'])); //����ַ���
$str_nonce = strval(trim($_REQUEST['nonce'])); //�����
$str_timestamp = strval(trim($_REQUEST['timestamp'])); //ʱ���
$str_signature = strval(trim($_REQUEST['signature'])); //ǩ���ִ�
/*
$user_mail = array('xiongbo@mail.untx.cn'); 
$subject   = '��΢�Ų��ԡ����Ե�ַ';                 
$mailBody  = 'ϵͳ��' . date("Y-m-d H:i:s") . '�յ����ݣ��������£�<BR>';
$mailBody .= '[if/weixin/signature.php] �յ������Ĳ�����'.print_r($_REQUEST,true);
autoSendEmail($subject, $mailBody, $user_mail); 
*/

if (empty($str_echostr)) {
	die('����ַ���Ϊ�ա�NO-01');
}
if (empty($str_nonce)) {
	die('�����Ϊ�ա�NO-02');
}
if (empty($str_timestamp)) {
	die('ʱ���Ϊ�ա�NO-03');
}
if (empty($str_signature)) {
	die('ǩ���ִ�Ϊ�ա�NO-04');
}

define('TOKEN','untxO2Otxd');

$arr_data = array();
$arr_data['token'] = TOKEN;
$arr_data['timestamp'] = $str_timestamp;
$arr_data['nonce'] = $str_nonce;
$arr_data['signature'] = $str_signature;

$obj_weixin_check = new weixin_check;
$bol_sign = $obj_weixin_check->check_signature($arr_data);
if ($bol_sign) {//��֤ǩ��OK
	echo $str_nonce.'<br/>';
/*
$user_mail = array('xiongbo@mail.untx.cn'); 
$subject   = '��΢�Ų��ԡ����Ե�ַ';              
$mailBody  = 'System Is' . date("Y-m-d H:i:s") . '[if/weixin/signature.php]  check Sign is Ok,echo is ��'.$str_nonce;
autoSendEmail($subject, $mailBody, $user_mail); 
*/
} else {
	echo 'Error'.'<br/>';
}

class weixin_check {
	
	/**
	 * ��֤ǩ��
	 * @paras
	 * return bollean
	 */
	function check_signature ($paras) {
		if (empty($paras)) {
			return false;
		}
		$arr_data = array();
		$arr_data['token'] = TOKEN;
		$arr_data['timestamp'] = $paras['timestamp'];
		$arr_data['nonce'] = $paras['nonce'];
		sort($arr_data, SORT_STRING);
		
		$str_clear_string = implode($arr_data);
		$str_encypt_string = sha1($str_clear_string);

		if ($str_encypt_string == $paras['signature']) {
	    	return true;
	    } else {
			return false;
		}
	}

	/**
	 * ��������
	 * @paras
	 * return 
	 */
    function response_msg() {
		//get post data, May be due to the different environments
		$str_postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($str_postStr)){                
			$postObj = simplexml_load_string($str_postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
			$textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
						</xml>";             
			if(!empty( $keyword )){
          		$msgType = "text";
            	$contentStr = "Welcome to wechat world!";
            	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            	echo $resultStr;
			} else {
				echo "Input something...";
			}
        } else {
        	echo "Error";
        	exit;
        }
    } 

}