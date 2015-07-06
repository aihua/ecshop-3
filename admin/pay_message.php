<?php

/*
* ֧������ģ����������
* add by hg for date 2014-03-19 
*
*
*/


define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');


//֧�����б�
if($_REQUEST['act'] =='message')
{
	$message_list = pay_message_list();
	$smarty->assign('message_list', $message_list['pzd_list']);
	$smarty->assign('filter',       $message_list['filter']);
	$smarty->assign('record_count', $message_list['record_count']);
	$smarty->assign('page_count',   $message_list['page_count']);
	$smarty->assign('full_page',    1);

	assign_query_info();
	
	//֧����
	$payment_list = payment_list();
	$smarty->assign('payment_list',$payment_list);
	//֧����ʽ
	$typ_list = typ_lis();
	$smarty->assign('typ_list',$typ_list); 
	$smarty->display('pay_message.htm');

}elseif($_REQUEST['act'] =='query'){
	//��ȡ��Ϣ�б�
	$message_list = pay_message_list();
	$smarty->assign('message_list', $message_list['pzd_list']);
	$smarty->assign('filter',       $message_list['filter']);
	$smarty->assign('record_count', $message_list['record_count']);
	$smarty->assign('page_count',   $message_list['page_count']);
	//֧����
	$payment_list = payment_list();
	$smarty->assign('payment_list',$payment_list);
	
	//֧����ʽ
	$typ_list = typ_lis();
	$smarty->assign('typ_list',$typ_list); 
	//��תҳ��
	make_json_result($smarty->fetch('pay_message.htm'),'',
	array('filter' => $message_list['filter'], 'page_count' => $message_list['page_count']));
}

if($_REQUEST['act'] =='message_seach')
{
	$message_list = pay_message_list($_REQUEST);
	//print_r($message_list);die;
	$smarty->assign('message_list', $message_list['pzd_list']);
	$smarty->assign('filter',       $message_list['filter']);
	$smarty->assign('record_count', $message_list['record_count']);
	$smarty->assign('page_count',   $message_list['page_count']);
	$smarty->assign('full_page',    1);
	$smarty->assign('message_page',    1);
	if($_REQUEST['status'] != null && $_REQUEST['status'] ==0)
	{
		$_REQUEST['status'] = 2;
	}
	$smarty->assign('message_seach',$_REQUEST);
	assign_query_info();
	
	//֧����
	$payment_list = payment_list();
	$smarty->assign('payment_list',$payment_list);
	//֧����ʽ
	$typ_list = typ_lis();
	$smarty->assign('typ_list',$typ_list); 
	
	$smarty->display('pay_message.htm');
}elseif($_REQUEST['act'] =='pay_message_query'){

	$message_list = pay_message_list($_REQUEST);
	$smarty->assign('message_list', $message_list['pzd_list']);
	$smarty->assign('filter',       $message_list['filter']);
	$smarty->assign('record_count', $message_list['record_count']);
	$smarty->assign('page_count',   $message_list['page_count']);
	$smarty->assign('message_seach',$_REQUEST);
	//֧����
	$payment_list = payment_list();
	$smarty->assign('payment_list',$payment_list);
	
	//֧����ʽ
	$typ_list = typ_lis();
	$smarty->assign('typ_list',$typ_list); 
	//��תҳ��
	make_json_result($smarty->fetch('pay_message.htm'),'',
	array('filter' => $message_list['filter'], 'page_count' => $message_list['page_count']));
}
//�޸���Ϣ��ʾ
if($_REQUEST['act'] =='message_edit')
{
	$sql = "SELECT b.Is_delete,b.enabled,b.pay_type,b.Local_bank_code,b.bank_pay_num,b.bank_name,b.bank_code,b.pay_id,b.paybank_id,p.pay_name,t.type_name FROM " . $ecs->table('pay_bank'). " AS b left join " .$ecs->table('payment'). " As p on b.pay_id = p.pay_id left join ".$ecs->table('pay_type') ."As t on b.pay_type = t.paytype_id where paybank_id=$_REQUEST[paybank_id]";
	$message_list = $db->getRow($sql);
	$smarty->assign('message',$message_list);
	
	//֧����
	$payment_list = payment_list();
	$smarty->assign('payment_list',$payment_list);
	
	//֧����ʽ
	$typ_list = typ_lis();
	$smarty->assign('typ_list',$typ_list); 
	
	$smarty->display('pay_message_edit.htm');
}
//�޸Ĺ���
if($_REQUEST['act'] =='message_edit_end')
{
	$sql = "UPDATE " . $ecs->table('pay_bank') . "SET pay_id = $_REQUEST[pay_way_id],bank_code = '$_REQUEST[query_pay_num]',bank_name = '$_REQUEST[query_pay_bank_name]',bank_pay_num = '$_REQUEST[bank_pay_num]',pay_type = '$_REQUEST[pay_mode]',enabled = '$_REQUEST[status]' WHERE 	paybank_id = $_REQUEST[paybank_id]";
	$db->query($sql);
	header('location:pay_message.php?act=message');
}

//֧��������ɾ��
if($_REQUEST['act'] =='message_del')
{
	$sql = "DELETE FROM " . $ecs->table('pay_bank') . " WHERE paybank_id = '$_REQUEST[paybank_id]'";
    $db->query($sql);
	header('location:pay_message.php?act=message');	
}


//��֧��������
function pay_message_list($seach = array())
{
	#��ѯ���� begin
	$where = '';
	//֧����
	if($seach['pay_way_id'] != null)
	{
		$where.= 'and b.pay_id ='.$seach['pay_way_id'];
	}
	//֧����ʽ
	if($seach['pay_mode'] != null)
	{
		$where.= ' and b.pay_type ='.$seach['pay_mode'];
	}
	//����״̬
	if($seach['status'] != null)
	{
		$where.= ' and b.enabled ='.$seach['status'];
	}
	//��������
	if($seach['query_pay_bank_name'] != null)
	{
		$where.= ' and b.bank_name ="'.$seach['query_pay_bank_name'].'"';
	}
	//���д���
	if($seach['query_pay_num'] != null)
	{
		$where.= ' and b.bank_code ="'.$seach['query_pay_num'].'"';
	}
	//���ش���
	if($seach['query_bank_pay_num'] != null)
	{
		$where.= ' and b.bank_pay_num ="'.$seach['query_bank_pay_num'].'"';
	}
	#end
	
	$sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('pay_bank'). " AS b left join " .$GLOBALS['ecs']->table('payment'). " As p on b.pay_id = p.pay_id left join ".$GLOBALS['ecs']->table('pay_type') ."As t on b.pay_type = t.paytype_id where b.Is_delete =0 $where order by paybank_id desc";
	
	$filter['record_count'] = $GLOBALS['db']->getOne($sql);
	$filter = page_and_size($filter);
	
	$sql = "SELECT b.Is_delete,b.enabled,b.pay_type,b.Local_bank_code,b.bank_pay_num,b.bank_name,b.bank_code,b.pay_id,b.paybank_id,p.pay_name,t.type_name FROM " . $GLOBALS['ecs']->table('pay_bank'). " AS b left join " .$GLOBALS['ecs']->table('payment'). " As p on b.pay_id = p.pay_id left join ".$GLOBALS['ecs']->table('pay_type') ."As t on b.pay_type = t.paytype_id where b.Is_delete =0 $where  order by b.paybank_id desc LIMIT ". $filter['start'] .", " . $filter['page_size'];

	$filter['keywords'] = stripslashes($filter['keywords']);
	set_filter($filter, $sql);
	$row = $GLOBALS['db']->getAll($sql);
	$arr = array('pzd_list' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
	return $arr;
}

//֧����ʽ
function typ_lis()
{
	$typ_sql = "SELECT `paytype_id`,`type_name` FROM " . $GLOBALS['ecs']->table('pay_type').' where Is_delete =0';
	return $typ_list = $GLOBALS['db']->getAll($typ_sql);
}
//֧����
function payment_list()
{
	$payment_sql = "SELECT `pay_id`,`pay_name` FROM " . $GLOBALS['ecs']->table('payment').'where Is_delete =0';
	return $payment_list = $GLOBALS['db']->getAll($payment_sql);
}


?>