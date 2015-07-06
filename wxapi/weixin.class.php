<?php
/******************************************************************************
Filename       : weixin.class.php
Author         : SouthBear
Email          : SouthBear819@163.com
Date/time      : 2014-07-11 11:14:10 
Purpose        : ΢�Ź��ںſ����ӿ����
Description    : 
Modify         : 
******************************************************************************/

class weixin {
    function __construct() {       
    }
    
    /**
     * ΢�Ź��ں����������Ϣ
     * @paras
     * return 
     */
	private function weixin_config () {
 		$arr_config = array();
 		$arr_config = array(
 			'token' => 'untxO2Otxd' //untxO2Otxdweixin untxO2Otxd
 			,'appid' => 'wxe7f55d599239f618'
 			,'secret' => '6b4f9818f9e895759af9d3ccaff43f91'
 			,'grant_type_token' => 'client_credential'
 			,'grant_type_auth' => 'authorization_code'
 			,'grant_type_refresh' => 'refresh_token'
 			,'lang' => 'zh_CN'

 			,'token_url' => 'https://api.weixin.qq.com/cgi-bin/token' //��ȡaccess_token
 			,'upload_midea_url' => 'http://file.api.weixin.qq.com/cgi-bin/media/upload' //�ϴ���ý���ļ�
 			,'down_media_url' => 'http://file.api.weixin.qq.com/cgi-bin/media/get' //���ض�ý���ļ�
 			,'send_service_msg_url' => 'https://api.weixin.qq.com/cgi-bin/message/custom/send' //���Ϳͷ���Ϣ
 			,'send_qunfa_image_url' => 'https://api.weixin.qq.com/cgi-bin/media/uploadnews' //�ϴ�ͼ����Ϣ�ز�
 			,'send_qunfa_team_url' => 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall' //���ݷ������Ⱥ��
 			,'send_qunfa_openId_url' => 'https://api.weixin.qq.com/cgi-bin/message/mass/send' //����OpenID�б�Ⱥ��
 			,'send_qunfa_del_url' => 'https://api.weixin.qq.com//cgi-bin/message/mass/delete' //ɾ��Ⱥ��
 			
 			,'get_auth_url' => 'https://open.weixin.qq.com/connect/oauth2/authorize' //��ȡ��Ȩ
 			,'get_auth_tocken_url' => 'https://api.weixin.qq.com/sns/oauth2/access_token' //��ȡ��Ȩ���token
 			,'auth_redirect_url' => 'http://www.91ka.com/if/weixin/auth2.php' //��Ȩ��ҳ���ض����ַ
 			,'refresh_access_tocken' => 'https://api.weixin.qq.com/sns/oauth2/refresh_token' //ˢ��access_token
 			,'get_user_info_url' => 'https://api.weixin.qq.com/sns/userinfo' //��ȡ�û���Ϣ
 			,'check_access_tocken' => 'https://api.weixin.qq.com/sns/auth' //�����Ȩƾ֤��access_token���Ƿ���Ч
 		);
 		return $arr_config;	
 	}
 	
 	/**
 	 * ΢��������
 	 * @paras
 	 * return 
 	 */
 	public function weixin ($paras) {
 		if (empty($paras)) {
 			return false;
 		}
 		$this->config = $this->weixin_config();
 		//��������֤
 		if ($paras['action'] == 'check_dev') {
			$arr_data = array();
			$arr_data['token'] = $this->config['token'];
			$arr_data['timestamp'] = $paras['timestamp'];
			$arr_data['nonce'] = $paras['nonce'];
			$arr_data['signature'] = $paras['signature'];	
		
			$bol_result = $this->_check_signature($arr_data);
			if ($bol_result){
				return true;
			} else {
				return false;
			}				
			
 		}
 		//��ȡacccess_token
 		if ($paras['action'] == 'access_token') {
			$arr_data = array();
			$arr_data['grant_type'] = $this->config['grant_type_token'];
			$arr_data['appid'] = $this->config['appid'];
			$arr_data['secret'] = $this->config['secret'];
			
			$arr_result = $this->_get_access_token($arr_data);
			if ($arr_result){
				return $arr_result;
			} else {
				return false;
			}		 			
 		}
 		//�ϴ���ý���ļ�
 		if ($paras['action'] == 'upload_midea') {
			/**
			 * type ����  ͼƬ��image����������voice������Ƶ��video��������ͼ��thumb��
			 * media ���� form-data��ý���ļ���ʶ����filename��filelength��content-type����Ϣ
			 */
			$arr_data = array();
			$arr_data['access_token'] = $paras['access_token'];
			$arr_data['type'] = $paras['type'];
			$arr_data['media'] = $paras['media'];
			
			$arr_result = $this->_upload_media($arr_data);
			if ($arr_result){
				return $arr_result;
			} else {
				return false;
			}	

 		
 		}
 		//���ض�ý���ļ�
 		if ($paras['action'] == 'down_midea') {
			$arr_data = array();
			$arr_data['access_token'] = $paras['access_token'];
			$arr_data['media_id'] = $paras['media_id'];
			
			$arr_result = $this->_down_media($arr_data);
			if ($arr_result){
				return $arr_result;
			} else {
				return false;
			}	 		
 		}
 		//������Ϣ
 		if ($paras['action'] == 'receive_msg') {
 			$arr_data = array();
 			$arr_data['msg'] = $paras['msg'];		
			$arr_result = $this->_parse_xml($arr_data);
			if ($arr_result){
				return $arr_result;
			} else {
				return false;
			}		
 		}
 		//�����¼�
 		if ($paras['action'] == 'receive_event') {
 			$arr_data = array();
 			$arr_data['msg'] = $paras['msg'];		
			$arr_result = $this->_parse_xml($arr_data);
			if ($arr_result){
				return $arr_result;
			} else {
				return false;
			}	
 		} 
 		//��������
 		if ($paras['action'] == 'receive_voice') {
 			$arr_data = array();
 			$arr_data['msg'] = $paras['msg'];		
			$arr_result = $this->_parse_xml($arr_data);
			if ($arr_result){
				return $arr_result;
			} else {
				return false;
			}		
 		} 
		//���ͱ�����Ӧ��Ϣ
 		if ($paras['action'] == 'send_msg') {
 			$arr_data = array();
			$arr_data['ToUserName'] = $paras['ToUserName'];	//���շ��ʺţ��յ���OpenID��
			$arr_data['FromUserName'] = $paras['FromUserName']; //������΢�ź�
			$arr_data['CreateTime'] = $paras['CreateTime']; //��Ϣ����ʱ�� �����ͣ�
			$arr_data['MsgType'] = $paras['MsgType']; //��Ϣ���� text voice video music	news	
			$arr_data['Content'] = $paras['Content']; //�ظ�����Ϣ���ݣ����У���content���ܹ����У�΢�ſͻ��˾�֧�ֻ�����ʾ��
			$arr_data['MediaId'] = $paras['MediaId']; //ͨ���ϴ���ý���ļ����õ���id
			$arr_data['Title'] = $paras['Title']; //��Ƶ�����֡�ͼ����Ϣ����
			$arr_data['Description'] = $paras['Description']; //��Ƶ�����֡�ͼ����Ϣ����
			$arr_data['MusicURL'] = $paras['MusicURL']; //��������
			$arr_data['HQMusicUrl'] = $paras['HQMusicUrl']; //�������������ӣ�WIFI��������ʹ�ø����Ӳ�������
			$arr_data['ThumbMediaId'] = $paras['ThumbMediaId']; //����ͼ��ý��id��ͨ���ϴ���ý���ļ����õ���id
			$arr_data['ArticleCount'] = $paras['ArticleCount']; //ͼ����Ϣ����������Ϊ10������
			$arr_data['Articles'] = $paras['Articles']; //����ͼ����Ϣ��Ϣ��Ĭ�ϵ�һ��itemΪ��ͼ,ע�⣬���ͼ��������10���򽫻�����Ӧ
			$arr_data['PicUrl'] = $paras['PicUrl'];	//ͼƬ���ӣ�֧��JPG��PNG��ʽ���Ϻõ�Ч��Ϊ��ͼ360*200��Сͼ200*200
			$arr_data['Url'] = $paras['Url'];	//���ͼ����Ϣ��ת����
//echo '<pre>';
//print_r($arr_data);
//echo '</pre>';
//exit;	
			$arr_result = $this->_send_msg($arr_data);
			if ($arr_result){
				return $arr_result;
			} else {
				return false;
			}		
 		} 		
		//������Ϣ
 		if ($paras['action'] == 'send_sevice_msg') {
 			$arr_data = array();
			$arr_data['access_token'] = $paras['access_token'];	//���ýӿ�ƾ֤
			$arr_data['touser'] = $paras['touser']; //��ͨ�û�openid
			$arr_data['msgtype'] = $paras['msgtype']; //��Ϣ���� text voice video music	news	
			switch ($paras['msgtype']) {
				case 'text':
					$arr_data['content'] = $paras['content']; //�ظ�����Ϣ���ݣ����У���content���ܹ����У�΢�ſͻ��˾�֧�ֻ�����ʾ��
				break;
				case 'news':
					$arr_data['articles'] = $paras['articles'];
				break;
			}
//echo '<pre>';
//print_r($arr_data);
//echo '</pre>';	
//exit;
			$arr_result = $this->_send_sevice_msg($arr_data);
			if ($arr_result){
				return $arr_result;
			} else {
				return false;
			}		
 		}
 		
 		
 		
 		
 		//��ȡ�û���Ȩ
 		if ($paras['action'] == 'oauth') {
			$arr_data = array();
			$arr_data['appid'] = $this->config['appid'];
			$arr_data['redirect_uri'] = $this->config['auth_redirect_url'];
			$arr_data['response_type'] = 'code';
			//snsapi_base ��������Ȩҳ�棬ֱ����ת��ֻ�ܻ�ȡ�û�openid
			//snsapi_userinfo ��������Ȩҳ�棬��ͨ��openid�õ��ǳơ��Ա����ڵء����ң���ʹ��δ��ע������£�ֻҪ�û���Ȩ��Ҳ�ܻ�ȡ����Ϣ��
			$arr_data['scope'] = 'snsapi_base';
			$arr_data['state'] = 'test'; //������дa-zA-Z0-9�Ĳ���ֵ
			
			$arr_result = $this->_get_auth($arr_data);
			if ($arr_result){
				return $arr_result;
			} else {
				return false;
			}
 		}
 		//��ȡ�û���Ȩ���access_token
 		if ($paras['action'] == 'oauth_access_token') {
			$arr_data = array();
			$arr_data['appid'] = $this->config['appid'];
			$arr_data['secret'] = $this->config['secret'];
			$arr_data['code'] = $paras['code'];
			$arr_data['grant_type'] = $this->config['grant_type_auth'];
			
			$arr_result = $this->_get_auth_access_token($arr_data);
			if ($arr_result){
				return $arr_result;
			} else {
				return false;
			}
 		}
 		//ˢ����Ȩ���access_token
 		if ($paras['action'] == 'refresh_access_token') {
			$arr_data = array();
			$arr_data['appid'] = $this->config['appid'];
			$arr_data['grant_type'] = $this->config['grant_type_refresh'];
			$arr_data['refresh_token'] = $paras['refresh_token'];
			
			$arr_result = $this->_get_refresh_auth_access_token($arr_data);
			if ($arr_result){
				return $arr_result;
			} else {
				return false;
			}
 		}
 		//��ȡ�û���ϢscopeΪ snsapi_userinfo
 		if ($paras['action'] == 'get_user_info') {
 			$arr_data = array();
			$arr_data['access_token'] = $paras['access_token'];
			$arr_data['openid'] = $paras['openid'];
			$arr_data['lang'] = $this->config['lang'];
			
			$arr_result = $this->_get_user_info($arr_data);
			if ($arr_result){
				return $arr_result;
			} else {
				return false;
			}		
 		}
 		//�����Ȩƾ֤��access_token���Ƿ���Ч
 		if ($paras['action'] == 'check_access_tocken') {
 			$arr_data = array();
			$arr_data['access_token'] = $paras['access_token'];
			$arr_data['openid'] = $paras['openid'];
			
			$arr_result = $this->_check_access_tocken($arr_data);
			if ($arr_result){
				return $arr_result;
			} else {
				return false;
			}	 		
 		} 		
 		
 	} 

	/**
	 * ��֤ǩ��
	 * @paras
	 * return bollean
	 */
	protected function _check_signature ($paras) {
		if (empty($paras)) {
			return false;
		}
		$arr_data = array();
		$arr_data['token'] = $paras['token'];
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
    protected function _response_msg() {
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
        } else {//���ؿմ�
        	echo " ";
        	exit;
        }
    } 

	/**
	 * ��ȡaccess_token
	 * @paras
	 * return 
	 * �ӿ�ʹ��Ƶ��˵��URL http://mp.weixin.qq.com/wiki/index.php?title=�ӿ�Ƶ������˵��
	 */
	protected function _get_access_token ($paras) {
		if (empty($paras)) {
			return false;
		}
		$arr_data = array();
		$arr_data['grant_type'] = $paras['grant_type'];
		$arr_data['appid'] = $paras['appid'];;
		$arr_data['secret'] = $paras['secret'];

		//�ύ����
		$str_qstring = $this->_encode_data($arr_data);
		$str_url     = $this->config['token_url'];
		//echo $str_url.'?'.$str_qstring.'<br/>';
		//exit;
		$str_method  = 'get';
		$str_rtn_msg = $this->curl_request($str_method,$str_url,$str_qstring);
		//$str_rtn_msg = $this->iconv_charset($str_rtn_msg,"GBK",'UTF-8');
/*
		$str_rtn_msg = '
{"access_token":"AredN4gAetQRm5TByGi73yYvlTBEu6GuAVJnwPNSiJFbI4Hn3-r4-Gr9Dz6e4unSo8bllKU3176bnGQ_CwA9tw","expires_in":7200}';	
*/		
		/**
		 * ��������˵��
		 * access_token  ��ȡ����ƾ֤
		 * expires_in ƾ֤��Чʱ�䣬��λ����
		 */	
		$obj_result = json_decode($str_rtn_msg);
		$arr_result = $this->object_to_array($obj_result);

		if (is_array($arr_result) && count($arr_result) > 0) {
			if ($arr_result['errcode'] && $arr_result['errcode'] != '0') {
				$arr_result['err_msg'] = $this->_global_result_code($arr_result['errcode']);
			} 
			return $arr_result;
		} else {
			return false;
		}
	
	} 

	/**
	 * �ϴ�ý���ļ�
	 * @paras
	 * return 
	 */
	protected function _upload_media ($paras) {
		if (empty($paras)) {
			return false;
		}
		$arr_data = array();
		$arr_data['access_token'] = $paras['access_token'];
		$arr_data['type'] = $paras['type'];
		$arr_data['media'] = $paras['media'];
		
		//�ύ����
		$str_qstring = $this->_encode_data($arr_data);
		$str_url     = $this->config['upload_midea_url'];

		//echo $str_url.'?'.$str_qstring.'<br/>';
		//exit;
		$str_method  = 'POST';
		//$str_rtn_msg = $this->curl_request($str_method,$str_url,$str_qstring);

		/**
		 * ��������˵��
		 * type  ý���ļ����ͣ��ֱ���ͼƬ��image����������voice������Ƶ��video��������ͼ��thumb����Ҫ������Ƶ�����ָ�ʽ������ͼ��
		 * media_id ý���ļ��ϴ��󣬻�ȡʱ��Ψһ��ʶ
		 * created_at ý���ļ��ϴ�ʱ���
		 */	
		
		/**	ע������			
		 * 	�ϴ��Ķ�ý���ļ��и�ʽ�ʹ�С���ƣ����£�			
		 *	ͼƬ��image��: 1M��֧��JPG��ʽ
		 *	������voice����2M�����ų��Ȳ�����60s��֧��AMR\MP3��ʽ
		 *	��Ƶ��video����10MB��֧��MP4��ʽ
		 *	����ͼ��thumb����64KB��֧��JPG��ʽ
		 * 	ý���ļ��ں�̨����ʱ��Ϊ3�죬��3���media_idʧЧ��
		 */
		$obj_result = json_decode($str_rtn_msg);
		$arr_result = $this->object_to_array($obj_result);
//echo '<pre>';
//print_r($arr_result);
//echo '</pre>';
		
	}

	/**
	 * ���ض�ý���ļ�
	 * �ɵ��ñ��ӿ�����ȡ��ý���ļ�����ע�⣬��Ƶ�ļ���֧������
	 * @paras
	 * return 
	 */
	protected function _down_media ($paras) {
		if (empty($paras)) {
			return false;
		}
		$arr_data = array();
		$arr_data['access_token'] = $paras['access_token'];
		$arr_data['media_id'] = $paras['media_id'];
		
		//�ύ����
		$str_qstring = $this->_encode_data($arr_data);
		$str_url     = $this->config['down_midea_url'];

		//echo $str_url.'?'.$str_qstring.'<br/>';
		//exit;
		$str_method  = 'POST';
		//$str_rtn_msg = $this->curl_request($str_method,$str_url,$str_qstring);
echo '<pre>';
print_r($str_rtn_msg);
echo '</pre>';
		$obj_result = json_decode($str_rtn_msg);
		$arr_result = $this->object_to_array($obj_result);
//echo '<pre>';
//print_r($arr_result);
//echo '</pre>';
		
	} 

	/**
	 * �Խ��ո���(�ı���Ϣ/ͼƬ��Ϣ/������Ϣ/��Ƶ��Ϣ/����λ����Ϣ/������Ϣ)��Ϣ�Ĵ���
	 * @paras
	 * return 
	 * NOTICE simplexml_load_string ֻ����ȷ����UTF-8�������ַ�
	 */
	protected function _parse_xml ($paras) {
		if (empty($paras)) {
			return false;
		}
		$xml_file = $paras['msg'];
		$obj_xml = simplexml_load_string($xml_file);
		$arr_xml = $this->object_to_array($obj_xml);
//echo '<pre>';
//print_r($arr_xml);
//echo '</pre>';
		$arr_xml = $this->iconv_charset($arr_xml,"UTF-8",'GBK');
		if (is_array($arr_xml)) {
			return $arr_xml;
		} else {
			return false;
		}				
	}

	/**
	 * �ظ�ͼ�Ķ�ý����Ϣ
	 * @paras
	 * return 
	 */
	protected function _send_msg ($paras) {
		if (empty($paras)) {
			return false;
		}
		$arr_data = array();
		$arr_data['ToUserName'] = $paras['ToUserName'];	//���շ��ʺţ��յ���OpenID��
		$arr_data['FromUserName'] = $paras['FromUserName']; //������΢�ź�
		$arr_data['CreateTime'] = $paras['CreateTime']; //��Ϣ����ʱ�� �����ͣ�
		$arr_data['MsgType'] = $paras['MsgType']; //��Ϣ���� text voice video music	news	
		$arr_data['Content'] = $paras['Content']; //�ظ�����Ϣ���ݣ����У���content���ܹ����У�΢�ſͻ��˾�֧�ֻ�����ʾ��
		$arr_data['MediaId'] = $paras['MediaId']; //ͨ���ϴ���ý���ļ����õ���id
		$arr_data['Title'] = $paras['Title']; //��Ƶ�����֡�ͼ����Ϣ����
		$arr_data['Description'] = $paras['Description']; //��Ƶ�����֡�ͼ����Ϣ����
		$arr_data['MusicURL'] = $paras['MusicURL']; //��������
		$arr_data['HQMusicUrl'] = $paras['HQMusicUrl']; //�������������ӣ�WIFI��������ʹ�ø����Ӳ�������
		$arr_data['ThumbMediaId'] = $paras['ThumbMediaId']; //����ͼ��ý��id��ͨ���ϴ���ý���ļ����õ���id
		$arr_data['ArticleCount'] = $paras['ArticleCount']; //ͼ����Ϣ����������Ϊ10������
		$arr_data['Articles'] = $paras['Articles']; //����ͼ����Ϣ��Ϣ��Ĭ�ϵ�һ��itemΪ��ͼ,ע�⣬���ͼ��������10���򽫻�����Ӧ
		$arr_data['PicUrl'] = $paras['PicUrl'];	//ͼƬ���ӣ�֧��JPG��PNG��ʽ���Ϻõ�Ч��Ϊ��ͼ360*200��Сͼ200*200
		$arr_data['Url'] = $paras['Url'];	//���ͼ����Ϣ��ת����
	
		$xml_file = '<xml>';
		$xml_file .= '<ToUserName>'.$arr_data['ToUserName'].'</ToUserName>';
		$xml_file .= '<FromUserName>'.$arr_data['FromUserName'].'</FromUserName>';
		$xml_file .= '<CreateTime>'.$arr_data['CreateTime'].'</CreateTime>';
		$xml_file .= '<MsgType>'.$arr_data['MsgType'].'</MsgType>';
		
		if ($arr_data['MsgType'] == 'text') {//�ı��ļ�
			$xml_file .= '<Content>'.$arr_data['Content'].'</Content>';
		}
		if (in_array($arr_data['MsgType'],array('image','voice'))) {//image ͼƬ��Ϣ voice ������Ϣ
			$xml_file .= '<MediaId>'.$arr_data['MediaId'].'</MediaId>';
		}		
		if ($arr_data['MsgType'] == 'video') {//��Ƶ��Ϣ
			$xml_file .= '<MediaId>'.$arr_data['MediaId'].'</MediaId>';
			$xml_file .= '<Title>'.$arr_data['Title'].'</Title>';
			$xml_file .= '<Description>'.$arr_data['Description'].'</Description>';
		}		
		if ($arr_data['MsgType'] == 'music') {//������Ϣ
			$xml_file .= '<Title>'.$arr_data['Title'].'</Title>';
			$xml_file .= '<Description>'.$arr_data['Description'].'</Description>';
			$xml_file .= '<MusicURL>'.$arr_data['MusicURL'].'</MusicURL>';
			$xml_file .= '<HQMusicUrl>'.$arr_data['HQMusicUrl'].'</HQMusicUrl>';
			$xml_file .= '<ThumbMediaId>'.$arr_data['ThumbMediaId'].'</ThumbMediaId>';
		}			
		if ($arr_data['MsgType'] == 'news') {//ͼ����Ϣ
			$xml_file .= '<ArticleCount>'.$arr_data['ArticleCount'].'</ArticleCount>';
			$xml_file .= '<Articles>'.$arr_data['Articles'].'</Articles>';
			$xml_file .= '<Title>'.$arr_data['Title'].'</Title>';
			$xml_file .= '<Description>'.$arr_data['Description'].'</Description>';
			$xml_file .= '<PicUrl>'.$arr_data['PicUrl'].'</PicUrl>';
			$xml_file .= '<Url>'.$arr_data['Url'].'</Url>';
		}
		$xml_file .= '</xml>';
		
		if ($xml_file) {
			return $xml_file;
		} else {
			return false;
		}
	}

	/**
	 * ���Ϳͷ���Ϣ
	 * @paras
	 * return 
	 */
	protected function _send_sevice_msg ($paras) {
//	echo '--msg data--'.'<br/>';
//	echo '<pre>';
//	print_r($paras);
//	echo '</pre>';
		if (empty($paras)) {
			return false;
		}
		$arr_data = array();
		$arr_data['touser'] = $paras['touser']; //��ͨ�û�openid
		$arr_data['msgtype'] = $paras['msgtype']; //��Ϣ���ͣ�text
		//����
		if ($paras['msgtype'] == 'text') {			
			$arr_data['text']['content'] = $paras['content']; //�ı���Ϣ����
		}
		//ͼƬ������
		if (in_array($paras['msgtype'],array('image','voice'))) {
			$arr_data[$paras['msgtype']]['media_id'] = $paras['media_id']; //���͵�ͼƬ��ý��ID ������ý��ID
		}
		//��Ƶ
		if (in_array($paras['msgtype'],array('video'))) {
			$arr_data[$paras['msgtype']]['media_id'] = $paras['media_id']; //���͵���Ƶ��ý��ID
		    $arr_data[$paras['msgtype']]['thumb_media_id'] = $paras['thumb_media_id']; //����ͼ��ý��ID
			$arr_data[$paras['msgtype']]['title'] = $paras['title']; //��Ϣ�ı���
			$arr_data[$paras['msgtype']]['description'] = $paras['description']; //��Ϣ������
		}
		//����
		if (in_array($paras['msgtype'],array('music'))) {
			$arr_data[$paras['msgtype']]['title'] = $paras['title']; //��Ϣ�ı���
			$arr_data[$paras['msgtype']]['description'] = $paras['description']; //��Ϣ������
			$arr_data[$paras['msgtype']]['musicurl'] = $paras['musicurl']; //��������
			$arr_data[$paras['msgtype']]['hqmusicurl'] = $paras['hqmusicurl']; //��Ʒ���������ӣ�wifi��������ʹ�ø����Ӳ�������
		    $arr_data[$paras['msgtype']]['thumb_media_id'] = $paras['thumb_media_id']; //����ͼ��ý��ID
		}
		//ͼ����Ϣ
		if ($paras['msgtype'] == 'news') {		
			$arr_articles = array();
			$int_num = count($paras['articles']);
			for ($i = 0; $i < $int_num; $i++) {
				$arr_articles[$i]['title'] = $this->iconv_charset($paras['articles'][$i]['title'],"GBK",'UTF-8');
				$arr_articles[$i]['description'] = $this->iconv_charset($paras['articles'][$i]['description'],"GBK",'UTF-8');
				$arr_articles[$i]['url'] = $paras['articles'][$i]['url'];
				$arr_articles[$i]['picurl'] = $paras['articles'][$i]['picurl'];			
			}			
			$arr_data[$paras['msgtype']]['articles'] = $arr_articles; 
		}
//echo '<pre>';
//print_r($arr_data);
//echo '</pre>';

		//�ύ����
		$str_qstring = $this->JSON($arr_data);
//echo '--json data--'.'<br/>';
//echo '<pre>';
//print_r($str_qstring);
//echo '</pre>';
//exit;
		$str_url = $this->config['send_service_msg_url'];
		$str_url .= '?'.'access_token='.$paras['access_token'];
		//echo $str_url.'<br/>'; //.'?'.$str_qstring

		$str_method  = 'POST';
		$str_rtn_msg = $this->curl_request($str_method,$str_url,$str_qstring);

		$obj_result = json_decode($str_rtn_msg);
		$arr_result = $this->object_to_array($obj_result);
	
		if (is_array($arr_result)) {
			if ($arr_result['errcode'] != '0') {
				$arr_result['err_msg'] = $this->_global_result_code($arr_result['errcode']);
			} 
//echo '<pre>';
//print_r($arr_result);
//echo '</pre>';
			return $arr_result;			
		} else {
			return false;
		}
	}

	/**
	 * �߼�Ⱥ����Ϣ
	 * @paras
	 * return 
	 */
	protected function _send_qunfa_msg ($paras) {
		if (empty($paras)) {
			return false;
		}
		
		$arr_data = array();
		/**
		 * type Ⱥ����������
		 * 1 �ϴ�ͼ����Ϣ�ز�
		 * 2 ���ݷ������Ⱥ��
		 * 3 ����OpenID�б�Ⱥ��
		 * 4 ɾ��Ⱥ��
		 * 5 �¼�����Ⱥ�����
		 */
		if ($paras == 'images') {//1 ͼ����Ϣ

		}
		if ($paras == 'images') {//2 ���ݷ������Ⱥ��

		}		
		if ($paras == 'images') {//3 ����OpenID�б�Ⱥ��

		}		
		if ($paras == 'images') {//4 ɾ��Ⱥ��

		}
		if ($paras == 'images') {//5 �¼�����Ⱥ�����

		}
				
		//�ύ����
		$str_qstring = $this->_encode_data($arr_data);
		$str_url     = $this->config[''];

		//echo $str_url.'?'.$str_qstring.'<br/>';
		//exit;
		$str_method  = 'POST';
		$str_rtn_msg = $this->curl_request($str_method,$str_url,$str_qstring);

		
	}

	/**
	 * Ⱥ��ͼ����Ϣ
	 * @paras
	 * return 
	 */
	protected function _qunfa_image_msg ($paras) {
		if (empty($paras)) {
			return false;
		}
		
		$arr_data = array();
		$arr_data['Articles'] = $paras['Articles']; //ͼ����Ϣ��һ��ͼ����Ϣ֧��1��10��ͼ��
		$arr_data['thumb_media_id'] = $paras['thumb_media_id']; //ͼ����Ϣ����ͼ��media_id�������ڻ���֧��-�ϴ���ý���ļ��ӿ��л��
		$arr_data['author'] = $paras['author']; //ͼ����Ϣ������ 
		$arr_data['title'] = $paras['title']; //ͼ����Ϣ�ı���
		$arr_data['content_source_url'] = $paras['content_source_url']; //��ͼ����Ϣҳ�������Ķ�ԭ�ġ����ҳ��
		$arr_data['content'] = $paras['content']; //ͼ����Ϣҳ������ݣ�֧��HTML��ǩ
		$arr_data['digest'] = $paras['digest']; //ͼ����Ϣ������
		$arr_data['show_cover_pic'] = $paras['show_cover_pic']; //�Ƿ���ʾ���棬1Ϊ��ʾ��0Ϊ����ʾ
		$arr_data['touser'] = $paras['touser']; 

		//�ύ����
		$str_qstring = json_encode($this->_encode_data($arr_data));
		$str_url     = $this->config['send_qunfa_image_url'];

		//echo $str_url.'?'.$str_qstring.'<br/>';
		//exit;
		$str_method  = 'POST';
		$str_rtn_msg = $this->curl_request($str_method,$str_url,$str_qstring);
//echo '<pre>';
//print_r($res);
//echo '</pre>';	
		/**
		 * ���ص�����
		 * type	 ý���ļ����ͣ��ֱ���ͼƬ��image����������voice������Ƶ��video��������ͼ��thumb����
		 *       ����Ϊnews����ͼ����Ϣ
		 * media_id	 ý���ļ�/ͼ����Ϣ�ϴ����ȡ��Ψһ��ʶ
		 * created_at	 ý���ļ��ϴ�ʱ��
		 */
		$obj_result = json_decode($str_rtn_msg);
		$arr_result = $this->object_to_array($obj_result);	
			
	}

	/**
	 * Ⱥ��������Ϣ
	 * @paras
	 * return 
	 */
	protected function _qunfa_team_msg ($paras) {
		if (empty($paras)) {
			return false;
		}
		
		$arr_data = array();
		$arr_data['filter'] = $paras['filter']; //�����趨ͼ����Ϣ�Ľ�����
		$arr_data['group_id'] = $paras['group_id']; //Ⱥ�����ķ����group_id
		$arr_data['mpnews'] = $paras['mpnews']; //�����趨�������͵�ͼ����Ϣ 
		$arr_data['media_id'] = $paras['media_id']; //����Ⱥ������Ϣ��media_id
		$arr_data['msgtype'] = $paras['msgtype']; //Ⱥ������Ϣ���ͣ�ͼ����ϢΪmpnews���ı���ϢΪtext������Ϊvoice������Ϊmusic��ͼƬΪimage����ƵΪvideo
		$arr_data['title'] = $paras['title']; //��Ϣ�ı���
		$arr_data['description'] = $paras['description']; //��Ϣ������
		$arr_data['thumb_media_id'] = $paras['thumb_media_id']; //��Ƶ����ͼ��ý��ID

		//�ύ����
		$str_qstring = json_encode($this->_encode_data($arr_data));
		$str_url     = $this->config['send_qunfa_team_url'];

		//echo $str_url.'?'.$str_qstring.'<br/>';
		//exit;
		$str_method  = 'POST';
		$str_rtn_msg = $this->curl_request($str_method,$str_url,$str_qstring);
//echo '<pre>';
//print_r($res);
//echo '</pre>';	
		/**
		 * ���ص�����
		 * type	 ý���ļ����ͣ��ֱ���ͼƬ��image����������voice������Ƶ��video��������ͼ��thumb����
		 *       ����Ϊnews����ͼ����Ϣ
		 * errcode	 ������
		 * errmsg    ������Ϣ
		 * msg_id	 ��ϢID
		 * �ڷ��سɹ�ʱ����ζ��Ⱥ�������ύ�ɹ���������ζ�Ŵ�ʱȺ���Ѿ�����
		 */
		$obj_result = json_decode($str_rtn_msg);
		$arr_result = $this->object_to_array($obj_result);	
			
	}

	/**
	 * Ⱥ��������Ϣ
	 * @paras
	 * return 
	 */
	protected function _qunfa_openId_msg ($paras) {
		if (empty($paras)) {
			return false;
		}
		
		$arr_data = array();
		$arr_data['touser'] = $paras['touser']; //��дͼ����Ϣ�Ľ����ߣ�һ��OpenID�б�OpenID���ٸ������10000��
		$arr_data['mpnews'] = $paras['mpnews']; //�����趨�������͵�ͼ����Ϣ
		$arr_data['media_id'] = $paras['media_id']; //����Ⱥ����ͼ����Ϣ��media_id 
		$arr_data['msgtype'] = $paras['msgtype']; //Ⱥ������Ϣ���ͣ�ͼ����ϢΪmpnews���ı���ϢΪtext������Ϊvoice������Ϊmusic��ͼƬΪimage����ƵΪvideo
		$arr_data['title'] = $paras['title']; //��Ϣ�ı���
		$arr_data['description'] = $paras['description']; //��Ϣ������
		$arr_data['thumb_media_id'] = $paras['thumb_media_id']; //��Ƶ����ͼ��ý��ID

		//�ύ����
		$str_qstring = json_encode($this->_encode_data($arr_data));
		$str_url     = $this->config['send_qunfa_openId_url'];

		//echo $str_url.'?'.$str_qstring.'<br/>';
		//exit;
		$str_method  = 'POST';
		$str_rtn_msg = $this->curl_request($str_method,$str_url,$str_qstring);
//echo '<pre>';
//print_r($res);
//echo '</pre>';	
		/**
		 * ���ص�����
		 * type	 ý���ļ����ͣ��ֱ���ͼƬ��image����������voice������Ƶ��video��������ͼ��thumb����
		 *       ����Ϊnews����ͼ����Ϣ
		 * errcode	 ������
		 * errmsg    ������Ϣ
		 * msg_id	 ��ϢID
		 * �ڷ��سɹ�ʱ����ζ��Ⱥ�������ύ�ɹ���������ζ�Ŵ�ʱȺ���Ѿ�����
		 */
		$obj_result = json_decode($str_rtn_msg);
		$arr_result = $this->object_to_array($obj_result);	
			
	}

	/**
	 * ɾ��Ⱥ����Ϣ
	 * @paras
	 * return 
	 */
	protected function _qunfa_del_msg ($paras) {
		if (empty($paras)) {
			return false;
		}
		
		$arr_data = array();
		$arr_data['msg_id'] = $paras['msg_id']; //���ͳ�ȥ����ϢID
		
		/**
		 * ��ע�⣬ֻ���Ѿ����ͳɹ�����Ϣ����ɾ��ɾ����Ϣֻ�ǽ���Ϣ��ͼ������ҳʧЧ��
		 * �Ѿ��յ����û������������䱾�ؿ�����Ϣ��Ƭ�� ���⣬ɾ��Ⱥ����Ϣֻ��ɾ��
		 * ͼ����Ϣ����Ƶ��Ϣ���������͵���Ϣһ�����ͣ��޷�ɾ����
		 */

		//�ύ����
		$str_qstring = json_encode($this->_encode_data($arr_data));
		$str_url     = $this->config['send_qunfa_del_url'];

		//echo $str_url.'?'.$str_qstring.'<br/>';
		//exit;
		$str_method  = 'POST';
		$str_rtn_msg = $this->curl_request($str_method,$str_url,$str_qstring);
//echo '<pre>';
//print_r($res);
//echo '</pre>';	
		/**
		 * ���ص�����
		 * errcode	 ������
		 * errmsg    ������Ϣ
		 */
		$obj_result = json_decode($str_rtn_msg);
		$arr_result = $this->object_to_array($obj_result);	
			
	}

	/**
	 * �¼�����Ⱥ�����
	 * @paras
	 * return 
	 */
	protected function _qunfa_tuisong_result ($paras) {
		if (empty($paras)) {
			return false;
		}
		
		$arr_data = array();
		$arr_data['ToUserName'] = $paras['ToUserName']; //���ںŵ�΢�ź�
		$arr_data['FromUserName'] = $paras['FromUserName']; //���ں�Ⱥ�����ֵ�΢�źţ�Ϊmphelper
		$arr_data['CreateTime'] = $paras['CreateTime']; //����ʱ���ʱ���
		$arr_data['MsgType'] = $paras['MsgType']; //��Ϣ���ͣ��˴�Ϊevent
		$arr_data['Event'] = $paras['Event']; //�¼���Ϣ���˴�ΪMASSSENDJOBFINISH
		$arr_data['MsgID'] = $paras['MsgID']; //Ⱥ������ϢID
		$arr_data['Status'] = $paras['Status']; //Ⱥ���Ľṹ��Ϊ��send success����send fail����err(num)��
		$arr_data['TotalCount'] = $paras['TotalCount']; //group_id�·�˿��������openid_list�еķ�˿��
		$arr_data['FilterCount'] = $paras['FilterCount']; //���ˣ�������ָ�ض��������Ա�Ĺ��ˡ��û����þ��յĹ��ˣ��û������ѳ�4���Ĺ��ˣ���׼�����͵ķ�˿����ԭ���ϣ�FilterCount = SentCount + ErrorCount
		$arr_data['SentCount'] = $paras['SentCount']; //���ͳɹ��ķ�˿��
		$arr_data['ErrorCount'] = $paras['ErrorCount']; //����ʧ�ܵķ�˿��

//echo '<pre>';
//print_r($res);
//echo '</pre>';	

		$obj_result = json_decode($str_rtn_msg);
		$arr_result = $this->object_to_array($obj_result);	
			
	}

	/**
	 * ��ȡ��ҳ��Ȩ
	 * @paras
	 * return 
	 */
	protected function _get_auth ($paras) {
		if (empty($paras)) {
			return false;
		}
		
		$arr_data = array();
		$arr_data['appid'] = $paras['appid'];
		$arr_data['redirect_uri'] = urlencode($paras['redirect_uri']);
		$arr_data['response_type'] = $paras['response_type'];
		$arr_data['scope'] = $paras['scope'];
		$arr_data['state'] = $paras['state'];
		
		//�ύ����
		$str_qstring = $this->_encode_data($arr_data);
		$str_qstring .= '#wechat_redirect';
		$str_url     = $this->config['get_auth_url'];

		//echo $str_url.'?'.$str_qstring.'<br/>';
		//exit;
		$str_method  = 'POST';
		$str_rtn_msg = $this->curl_request($str_method,$str_url,$str_qstring);
//echo '<pre>';
//print_r($str_rtn_msg);
//echo '</pre>';		
//echo '------_get_auth--------'.'<br/>';
//exit;	
		if ($str_rtn_msg) {
			return $str_rtn_msg;
		} else {
			return false;
		}		
	}

	/**
	 * ��ȡ��Ȩ���access_token
	 * @paras
	 * return 
	 */
	protected function _get_auth_access_token ($paras) {
		if (empty($paras)) {
			return false;
		}
		$arr_data = array();
		$arr_data['appid'] = $paras['appid'];
		$arr_data['secret'] = $paras['secret'];
		$arr_data['code'] = $paras['code'];
		$arr_data['grant_type'] = $paras['grant_type'];

		//�ύ����
		$str_qstring = $this->_encode_data($arr_data);
		$str_url     = $this->config['get_auth_tocken_url'];
		//echo '_get_auth_access_token'.'<br/>';
		//echo $str_url.'?'.$str_qstring.'<br/>';
		//exit;
		$str_method  = 'get';
		$str_rtn_msg = $this->curl_request($str_method,$str_url,$str_qstring);
		$str_rtn_msg = $this->iconv_charset($str_rtn_msg,"GBK",'UTF-8');
//echo '<pre>';
//print_r($str_rtn_msg);
//echo '</pre>';
/*
		$str_rtn_msg = '
{"access_token":"OezXcEiiBSKSxW0eoylIePVeTYBNndr3I0NlzF49udAiHLaGPkZ4CHwntPexYuvepTRJibh-c574g28ADiVEeAy31FMYnkGNASSeWHUCl5y3Q7OlZ47XBZJQ_FVbUmddsyu4Ekn7PLxRY3yJbFuU-A","expires_in":7200,"refresh_token":"OezXcEiiBSKSxW0eoylIePVeTYBNndr3I0NlzF49udAiHLaGPkZ4CHwntPexYuvehSiBmcbDc6kaIHU8pRTPZlXbLWjJN7LtkIPO-SWP8qNN0cMGbE0O4GknrylNUjzMnJjaeBGf1KBvMzwShGHk9Q","openid":"oIQ5Vtxp0W4Cb-MIJP2lho-cH82c","scope":"snsapi_base"}';

Array
(
    [access_token] => OezXcEiiBSKSxW0eoylIePVeTYBNndr3I0NlzF49udAiHLaGPkZ4CHwntPexYuvepTRJibh-c574g28ADiVEeAy31FMYnkGNASSeWHUCl5y3Q7OlZ47XBZJQ_FVbUmddsyu4Ekn7PLxRY3yJbFuU-A
    [expires_in] => 7200
    [refresh_token] => OezXcEiiBSKSxW0eoylIePVeTYBNndr3I0NlzF49udAiHLaGPkZ4CHwntPexYuvehSiBmcbDc6kaIHU8pRTPZlXbLWjJN7LtkIPO-SWP8qNN0cMGbE0O4GknrylNUjzMnJjaeBGf1KBvMzwShGHk9Q
    [openid] => oIQ5Vtxp0W4Cb-MIJP2lho-cH82c
    [scope] => snsapi_base
)	
*/
		/**
		 * ��������˵��
		 * access_token  ��ȡ����ƾ֤
		 * expires_in ƾ֤��Чʱ�䣬��λ����
		 */	
		$obj_result = json_decode($str_rtn_msg);
		$arr_result = $this->object_to_array($obj_result);

		if (is_array($arr_result) && count($arr_result) > 0) {
			if ($arr_result['errcode'] && $arr_result['errcode'] != '0') {
				$arr_result['err_msg'] = $this->_global_result_code($arr_result['errcode']);
			} 
			return $arr_result;
		} else {
			return false;
		}	
	}

	/**
	 * ˢ�»�ȡ��Ȩ���access_token
	 * @paras
	 * return 
	 */
	protected function _get_refresh_auth_access_token ($paras) {
		if (empty($paras)) {
			return false;
		}
		$arr_data = array();
		$arr_data['appid'] = $paras['appid'];
		$arr_data['grant_type'] = $paras['grant_type'];
		$arr_data['refresh_token'] = $paras['refresh_token'];

		//�ύ����
		$str_qstring = $this->_encode_data($arr_data);
		$str_url     = $this->config['refresh_access_tocken'];

		$str_method  = 'get';
		$str_rtn_msg = $this->curl_request($str_method,$str_url,$str_qstring);
		$str_rtn_msg = $this->iconv_charset($str_rtn_msg,"GBK",'UTF-8');

		/**
		 * ��������˵��
		 * access_token  ��ȡ����ƾ֤
		 * expires_in ƾ֤��Чʱ�䣬��λ����
		 */	
		$obj_result = json_decode($str_rtn_msg);
		$arr_result = $this->object_to_array($obj_result);
	
		if (is_array($arr_result) && count($arr_result) > 0) {
			if ($arr_result['errcode'] && $arr_result['errcode'] != '0') {
				$arr_result['err_msg'] = $this->_global_result_code($arr_result['errcode']);
			} 
//echo '--refresh_access_tocken--'.'<br/>';
//echo '<pre>';
//print_r($arr_result);
//echo '</pre>';
//exit;
			return $arr_result;
		} else {
			return false;
		}	
	}

	/**
	 * �����Ȩƾ֤��access_token���Ƿ���Ч
	 * @paras
	 * return 
	 */
	protected function _check_access_tocken ($paras) {
		if (empty($paras)) {
			return false;
		}

		$arr_data = array();
		$arr_data['access_token'] = $paras['access_token'];
		$arr_data['openid'] = $paras['openid'];
			
		//�ύ����
		$str_qstring = $this->_encode_data($arr_data);
		$str_url     = $this->config['check_access_tocken'];

		$str_method  = 'get';
		$str_rtn_msg = $this->curl_request($str_method,$str_url,$str_qstring);
		$str_rtn_msg = $this->iconv_charset($str_rtn_msg,"GBK",'UTF-8');

		/**
		 * ��������˵��
		 * access_token  ��ȡ����ƾ֤
		 * expires_in ƾ֤��Чʱ�䣬��λ����
		 */	
		$obj_result = json_decode($str_rtn_msg);
		$arr_result = $this->object_to_array($obj_result);

		if (is_array($arr_result) && count($arr_result) > 0) {
			if ($arr_result['errcode'] && $arr_result['errcode'] != '0') {
				$arr_result['err_msg'] = $this->_global_result_code($arr_result['errcode']);
			} 
//echo '<pre>';
//print_r($arr_result);
//echo '</pre>';	
//exit;
			return $arr_result;
		} else {
			return false;
		}	
	}



	/**
	 * ΢�Žӿ�ȫ�ִ�����
	 * @paras
	 * return 
	 */
	protected function _global_result_code ($paras) {
		if (empty($paras)) {
			return false;
		}
		$str_rtn_msg = '';
		switch ($paras) {
			case '-1':
				$str_rtn_msg = 'ϵͳ��æ';
			break;
			case '0':
				$str_rtn_msg = '����ɹ�';
			break;			
			case '40001':
				$str_rtn_msg = '��ȡaccess_tokenʱAppSecret���󣬻���access_token��Ч';
			break;
			case '40002':
				$str_rtn_msg = '���Ϸ���ƾ֤����';
			break;	
			case '40003':
				$str_rtn_msg = '���Ϸ���OpenID';
			break;
			case '40004':
				$str_rtn_msg = '���Ϸ���ý���ļ�����';
			break;				
			case '40005':
				$str_rtn_msg = '���Ϸ����ļ�����';
			break;
			case '40006':
				$str_rtn_msg = '���Ϸ����ļ���С';
			break;			
			case '40007':
				$str_rtn_msg = '���Ϸ���ý���ļ�id';
			break;
			case '40008':
				$str_rtn_msg = '���Ϸ�����Ϣ����';
			break;	
			case '40009':
				$str_rtn_msg = '���Ϸ���ͼƬ�ļ���С';
			break;
			case '40010':
				$str_rtn_msg = '���Ϸ��������ļ���С';
			break;
			case '40011':
				$str_rtn_msg = '���Ϸ�����Ƶ�ļ���С';
			break;
			case '40012':
				$str_rtn_msg = '���Ϸ�������ͼ�ļ���С';
			break;			
			case '40013':
				$str_rtn_msg = '���Ϸ���APPID';
			break;
			case '40014':
				$str_rtn_msg = '���Ϸ���access_token';
			break;	
			case '40015':
				$str_rtn_msg = '���Ϸ��Ĳ˵�����';
			break;
			case '40016':
				$str_rtn_msg = '���Ϸ��İ�ť����';
			break;				
			case '40017':
				$str_rtn_msg = '���Ϸ��İ�ť����';
			break;
			case '40018':
				$str_rtn_msg = '���Ϸ��İ�ť���ֳ���';
			break;			
			case '40019':
				$str_rtn_msg = '���Ϸ��İ�ťKEY����';
			break;
			case '40020':
				$str_rtn_msg = '���Ϸ��İ�ťURL����';
			break;	
			case '40021':
				$str_rtn_msg = '���Ϸ��Ĳ˵��汾��';
			break;
			case '40022':
				$str_rtn_msg = '���Ϸ����Ӳ˵�����';
			break;
			case '40023':
				$str_rtn_msg = '���Ϸ����Ӳ˵���ť����';
			break;
			case '40024':
				$str_rtn_msg = '���Ϸ����Ӳ˵���ť����';
			break;			
			case '40025':
				$str_rtn_msg = '���Ϸ����Ӳ˵���ť���ֳ���';
			break;
			case '40026':
				$str_rtn_msg = '���Ϸ����Ӳ˵���ťKEY����';
			break;	
			case '40027':
				$str_rtn_msg = '���Ϸ����Ӳ˵���ťURL����';
			break;
			case '40028':
				$str_rtn_msg = '���Ϸ����Զ���˵�ʹ���û�';
			break;				
			case '40029':
				$str_rtn_msg = '���Ϸ���oauth_code';
			break;
			case '40030':
				$str_rtn_msg = '���Ϸ���refresh_token';
			break;			
			case '40031':
				$str_rtn_msg = '���Ϸ���openid�б�';
			break;
			case '40032':
				$str_rtn_msg = '���Ϸ���openid�б���';
			break;	
			case '40033':
				$str_rtn_msg = '���Ϸ��������ַ������ܰ���\uxxxx��ʽ���ַ�';
			break;
			case '40035':
				$str_rtn_msg = '���Ϸ��Ĳ���';
			break;
			case '40038':
				$str_rtn_msg = '���Ϸ��������ʽ';
			break;
			case '40039':
				$str_rtn_msg = '���Ϸ���URL����';
			break;			
			case '40050':
				$str_rtn_msg = '���Ϸ��ķ���id';
			break;
			case '40051':
				$str_rtn_msg = '�������ֲ��Ϸ�';
			break;	
			case '41001':
				$str_rtn_msg = 'ȱ��access_token����';
			break;
			case '41002':
				$str_rtn_msg = 'ȱ��appid����';
			break;				
			case '41003':
				$str_rtn_msg = 'ȱ��refresh_token����';
			break;
			case '41004':
				$str_rtn_msg = 'ȱ��secret����';
			break;			
			case '41005':
				$str_rtn_msg = 'ȱ�ٶ�ý���ļ�����';
			break;
			case '41006':
				$str_rtn_msg = 'ȱ��media_id����';
			break;	
			case '41007':
				$str_rtn_msg = 'ȱ���Ӳ˵�����';
			break;
			case '41008':
				$str_rtn_msg = 'ȱ��oauth code';
			break;
			case '41009':
				$str_rtn_msg = 'ȱ��openid';
			break;			
			case '42001':
				$str_rtn_msg = 'access_token��ʱ';
			break;
			case '42002':
				$str_rtn_msg = 'refresh_token��ʱ';
			break;	
			case '42003':
				$str_rtn_msg = 'oauth_code��ʱ';
			break;
			case '43001':
				$str_rtn_msg = '��ҪGET����';
			break;
			case '43002':
				$str_rtn_msg = '��ҪPOST����';
			break;			
			case '43003':
				$str_rtn_msg = '��ҪHTTPS����';
			break;
			case '43004':
				$str_rtn_msg = '��Ҫ�����߹�ע';
			break;	
			case '43005':
				$str_rtn_msg = '��Ҫ���ѹ�ϵ';
			break;
			case '44001':
				$str_rtn_msg = '��ý���ļ�Ϊ��';
			break;				 
			case '44002':
				$str_rtn_msg = 'POST�����ݰ�Ϊ��';
			break;			
			case '44003':
				$str_rtn_msg = 'ͼ����Ϣ����Ϊ��';
			break;
			case '44004':
				$str_rtn_msg = '�ı���Ϣ����Ϊ��';
			break;	
			case '45001':
				$str_rtn_msg = '��ý���ļ���С��������';
			break;
			case '45002':
				$str_rtn_msg = '��Ϣ���ݳ�������';
			break;				 
			case '45003':
				$str_rtn_msg = '�����ֶγ�������';
			break;			
			case '45004':
				$str_rtn_msg = '�����ֶγ�������';
			break;
			case '45005':
				$str_rtn_msg = '�����ֶγ�������';
			break;	
			case '45006':
				$str_rtn_msg = 'ͼƬ�����ֶγ�������';
			break;
			case '45007':
				$str_rtn_msg = '��������ʱ�䳬������';
			break;		
			case '45008':
				$str_rtn_msg = 'ͼ����Ϣ��������';
			break;			
			case '45009':
				$str_rtn_msg = '�ӿڵ��ó�������';
			break;
			case '45010':
				$str_rtn_msg = '�����˵�������������';
			break;	
			case '45015':
				$str_rtn_msg = '�ظ�ʱ�䳬������';
			break;
			case '45016':
				$str_rtn_msg = 'ϵͳ���飬�������޸�';
			break;
			case '45017':
				$str_rtn_msg = '�������ֹ���';
			break;
			case '45018':
				$str_rtn_msg = '����������������';
			break;	
			case '46001':
				$str_rtn_msg = '������ý������';
			break;
			case '46002':
				$str_rtn_msg = '�����ڵĲ˵��汾';
			break;
			case '46003':
				$str_rtn_msg = '�����ڵĲ˵�����';
			break;
			case '46004':
				$str_rtn_msg = '�����ڵ��û�';
			break;
			case '47001':
				$str_rtn_msg = '����JSON/XML���ݴ���';
			break;
			case '48001':
				$str_rtn_msg = 'api����δ��Ȩ';
			break;			
			case '50001':
				$str_rtn_msg = '�û�δ��Ȩ��api';
			break;	
		}
		return $str_rtn_msg;
	} 

	/**
	 * �����ִ�
	 */
	protected function _encode_data ($paras) {
		foreach($paras as $key => $val) {
			//$val = $this->iconv_charset($val,"UTF-8",'GBK');
			//if ($key == 'province') {
			//	$val = urlencode(base64_encode($val));
			//} 
			$content .= $key.'='.$val.'&';
		}	
		$string = $content;
		$string = substr($string,0,-1);
		return $string;
	}

	/** 
	 * $method       �ύ������post get
	 * $str_bgUrl    �ύ��ַ
	 * $str_qstring  ��������
	 */
	public function curl_request($method,$str_bgUrl,$str_qstring){
	     $ch = curl_init();
	     if(strtolower($method) == 'get'){
	        curl_setopt($ch, CURLOPT_URL, $str_bgUrl.'?'.$str_qstring);
	     }else{
	        curl_setopt($ch, CURLOPT_URL, $str_bgUrl);
	        curl_setopt($ch, CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $str_qstring);
	     }
	     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);       
	     curl_setopt($ch, CURLOPT_HEADER, 0);          
	     $data = curl_exec($ch);
	     if (curl_errno($ch) != 0){
	         $int_err_code = '9999';
	         $str_err_msg = '�ӿ�֪ͨʧ��:�������.'.curl_error($ch);
	     }
	     curl_close($ch);
	     if($int_err_code) return false;
	     return $data;
	}

	/** 
	 * �Զ�ת���ַ��� ֧������ת��
	 * ����˵��
	 * fContents����Ҫת�����������Դ
	 * from������Դ���ݱ���
	 * to:   ת������������ݱ���
	 *************************************************************/
	public function iconv_charset ($fContents, $from, $to) {
	    $from = strtoupper($from);
	    $to   = strtoupper($to);
	    if (strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents))) {
	        //���������ͬ���߷��ַ���������ת��
	        return $fContents;
	    }
	    if (is_string($fContents)) {
	        if (function_exists('mb_convert_encoding')) {
	            return mb_convert_encoding($fContents, $to, $from);
	        } elseif (function_exists('iconv')) {
	            return iconv($from, $to.'//IGNORE', $fContents);
	        } else {
	            return $fContents;
	        }
	    } elseif (is_array($fContents)) {
	        foreach ($fContents as $key => $val) {
	            $_key = $this->iconv_charset($key, $from, $to);
	            $fContents[$_key] = $this->iconv_charset($val, $from, $to);
	            if ($key != $_key)
	                unset($fContents[$key]);
	        }
	        return $fContents;
	    }  else {
	        return $fContents;
	    }
	} 	 

	/**
	 * ����ת��Ϊ����
	 */	
	public function object_to_array($obj){ 
		if( count($obj) == 0 )  return trim((string)$obj);
	    $_arr = is_object($obj) ? get_object_vars($obj) : $obj; 
	    foreach ($_arr as $key => $val) 
	    { 
	        $val = (is_array($val) || is_object($val)) ? $this->object_to_array($val) : $val; 
	        $arr[$key] = $val; 
	    } 
	    return $arr; 
	}

	/**************************************************************
	 * ʹ���ض�function������������Ԫ��������
	 * @param  string  &$array     Ҫ������ַ���
	 * @param  string  $function   Ҫִ�еĺ���
	 * @return boolean $apply_to_keys_also     �Ƿ�ҲӦ�õ�key��
	 * @access public
     *************************************************************/
    public function arrayRecursive(&$array, $function, $apply_to_keys_also = false) {
        static $recursive_counter = 0;
        if (++$recursive_counter > 1000) {
            die('possible deep recursion attack');
        }
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $this->arrayRecursive($array[$key], $function, $apply_to_keys_also);
            } else {
                $array[$key] = $function($value);
            }
     
            if ($apply_to_keys_also && is_string($key)) {
                $new_key = $function($key);
                if ($new_key != $key) {
                    $array[$new_key] = $array[$key];
                    unset($array[$key]);
                }
            }
        }
        $recursive_counter--;
    }
     
    /**************************************************************
     *
     *    ������ת��ΪJSON�ַ������������ģ�
     *    @param  array   $array      Ҫת��������
     *    @return string      ת���õ���json�ַ���
     *    @access public
     *
     *************************************************************/
    public function JSON ($array) {
        $this->arrayRecursive($array, 'urlencode', true);
        $json = json_encode($array);
        return urldecode($json);
    }


}