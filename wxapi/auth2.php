<?php
/******************************************************************************
Filename       : auth2.php
Author         : SouthBear
Email          : SouthBear819@163.com
Date/time      : 2014-07-11 11:14:10 
Purpose        : ΢�ſ�����API�㼯
Description    : �û���Ȩҳ��
Modify         : 
******************************************************************************/
include('weixin.class.php');

//code˵�� ��
//code��Ϊ��ȡaccess_token��Ʊ�ݣ�ÿ���û���Ȩ���ϵ�code����һ����codeֻ��ʹ��һ�Σ�5����δ��ʹ���Զ����ڡ�
$str_action = 'oauth';
$str_code = strval(trim($_REQUEST['code']));
$str_state = strval(trim($_REQUEST['state']));

$arr_request = array('code' =>$str_code,'state' => $str_state);
echo '<pre>';
print_r($arr_request);
echo '</pre>';

$obj_weixin = new weixin();

/**
 * ��ҳ��Ȩ��ȡ�û�������Ϣ
 */
if ($str_action == 'oauth') {
	/**
	 * code˵�� ��
	 * code��Ϊ��ȡaccess_token��Ʊ�ݣ�ÿ���û���Ȩ���ϵ�code����һ����codeֻ��ʹ��һ�Σ�5����δ��ʹ���Զ����ڡ�
	 */
/**/
	$arr_data = array();
	$arr_data['action'] = 'oauth_access_token';
	$arr_data['code'] = $str_code;	
	$arr_result = $obj_weixin->weixin($arr_data);	
//echo '-oauth2-'.'<br/>';
//echo '<pre>';
//print_r($arr_result);
//echo '</pre>';	
/*
	//��������
	$arr_result = array();
    $arr_result['access_token'] = 'OezXcEiiBSKSxW0eoylIePVeTYBNndr3I0NlzF49udAiHLaGPkZ4CHwntPexYuveImVcNExP4FocwDCa4ZjmsNzl4cEqCht72TbptqLnOmuHdwWe7ecP50GTzUYdM5q0692ySngG1Mg312sQvjMM0Q';
    $arr_result['expires_in'] = '7200';
    $arr_result['refresh_token'] = 'OezXcEiiBSKSxW0eoylIePVeTYBNndr3I0NlzF49udAiHLaGPkZ4CHwntPexYuveFB0pHC4OzYrG4rSERKfqyy380u3mi5oM26E1bEUD2ZB152Euch4OW_S5zV4SwLXmamkJmOs3hRgmjhGGzWXI_Q';
    $arr_result['openid'] = 'oIQ5Vtxp0W4Cb-MIJP2lho-cH82c';
    $arr_result['scope'] = 'snsapi_base';
*/


	if (is_array($arr_result) && $arr_result['errcode'] != '0') {
		//��ȡ���� access_token
		$arr_data = array();
		$arr_data['action'] = 'access_token';
		$arr_result_a = $obj_weixin->weixin($arr_data);
//		echo '-base_access_token-'.'<br/>';
//		echo '<pre>';
//		print_r($arr_result_a);
//		echo '</pre>';
		
/*
		//exit;
		//����access_token
		$arr_result_a = array();
		$arr_result_a['access_token'] = 'NxSyusaADVSnV7JuoxKfsoavol9P-CuABBtyEwtaxvGMVlwstxacizV1uBKbIwUqWHUElTwIyrl6NT1vbrJ3DQ';
		$arr_result_a['expires_in'] = '7200';
*/
		if ($arr_result_a) {
			//������Ϣ������Ϣ HELLO WROLD
			$arr_data = array();
			$arr_data['action'] = 'send_sevice_msg';
			$arr_data['access_token'] = $arr_result_a['access_token'];
			$arr_data['touser'] = $arr_result['openid'];
			//$arr_data['msgtype'] = 'text'; //��Ϣ���� TEXT �ı�����
			//$arr_data['content'] = 'Hello,WelComeToO2O-txd168';
			
			//����ͼ����Ϣ
			$arr_data['msgtype'] = 'news'; //��Ϣ���ͣ�text news
			//����˵����
			//��һ�������Ǵ�ͼ����Ϣ
			//����������������Сͼ����Ϣ
			$arr_articles = array();
			$arr_articles[0]['title'] = '����ͼ����Ϣ1';
			$arr_articles[0]['description'] = '����ͼ����Ϣ ����';
			$arr_articles[0]['url'] = 'http://money.163.com/14/0806/02/A2U9MJNG00253B0H.html?from=news';
			$arr_articles[0]['picurl'] = 'http://img3.cache.netease.com/photo/0005/2014-08-05/900x600_A2SOEHCF4FFC0005.jpg';
			
			$arr_articles[1]['title'] = '�ٱ�����2';
			$arr_articles[1]['description'] = '�ٱ����� �ٱ����� ����';
			$arr_articles[1]['url'] = 'http://news.163.com/14/0806/03/A2UEBBBM000146BE.html';
			$arr_articles[1]['picurl'] = 'http://img5.cache.netease.com/photo/0005/2014-08-05/900x600_A2SOE5N04FFC0005.jpg';
			
			$arr_articles[2]['title'] = '��Ψ3';
			$arr_articles[2]['description'] = '��Ψ�����ȵָ�������Ϸ ��ʮ���˻��� 2 ����2';
			$arr_articles[2]['url'] = 'http://news.163.com/14/0806/02/A2UBORB000014AED.html';
			$arr_articles[2]['picurl'] = 'http://img4.cache.netease.com/photo/0003/2014-08-06/900x600_A2U9541P00AJ0003.jpg';

			$arr_data['articles'] = $arr_articles; 		
			
			$arr_result_b = $obj_weixin->weixin($arr_data);
		echo '--send_sevice_msg--'.'<br/>';
		echo '<pre>';
		print_r($arr_result_b);
		echo '</pre>';	
		exit;
			if ($arr_result_b && $arr_result_b['errcode'] != '0') {
				//�����Ȩƾ֤��access_token���Ƿ���Ч
				$arr_data = array();
		 		$arr_data['action'] = 'check_access_tocken';
				$arr_data['appid'] = $arr_result['access_token'];
				$arr_data['openid'] = $arr_result['openid'];		
				$arr_result_c = $obj_weixin->weixin($arr_data);
				echo '--check_access_tocken--'.'<br/>';
				echo '<pre>';
				print_r($arr_result_c);
				echo '</pre>';		
				if ($arr_result_c['errcode'] != '0') {
					//ˢ��access_token
					$arr_data = array();
			 		$arr_data['action'] = 'refresh_access_token';
					$arr_data['refresh_token'] = $arr_result['access_token'];
		
					$arr_result_d = $obj_weixin->weixin($arr_data);			
					echo '-refresh_token-'.'<br/>';
					echo '<pre>';
					print_r($arr_result_d);
					echo '</pre>';
					exit;			
				
				} else {
					$arr_data = array();
					$arr_data['action'] = 'send_sevice_msg';
					$arr_data['access_token'] = $arr_result_a['access_token'];
					$arr_data['touser'] = $arr_result['openid'];	
					$arr_data['msgtype'] = 'text'; //��Ϣ���� TEXT �ı�����
					$arr_data['content'] = 'Hello,WelCome To O2O-txd168';
			//echo '<pre>';
			//print_r($arr_data);
			//echo '</pre>';
			//exit;		
					$arr_result = $obj_weixin->weixin($arr_data);
					echo '--send_sevice_msg 2--'.'<br/>';	
					echo '<pre>';
					print_r($arr_result);
					echo '</pre>';		
				}
		
		 	} else {
				die('Error-01');
			}	
		} else {
			die('Error-02');
		}		
	} else {
		return false;
	}
}