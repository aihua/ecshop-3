<?php
/******************************************
* ˵��:APP�ӿ�
* author:hg
* time��2014-09-22
*******************************************/
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
//��������

$data = file_get_contents("php://input");

$json_arr = json_decode($data,true);

//�ж�����
if($json_arr['os'] && $json_arr['system_version'] && $json_arr['app_version'] && $json_arr['time'] && $json_arr['token_id'] && $json_arr['sign'] )
{
	$obj = new class_capp();
	$obj->verify($json_arr);//Ч������
	echo $obj->return_data();//��������
}


?>