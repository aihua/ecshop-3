<?php
/**
* �ҳ��
* by hg
**/
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
/* ���������ļ� */
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/shopping_flow.php');
$smarty->assign('lang',             $_LANG);
/* �±�� �������ߣ�*/
if($_REQUEST['act'] == 'mooncake')
{
	$smarty->assign('shop_province_list', get_regions(1, $_CFG['shop_country']));
	$smarty->display('mooncake/index.dwt');
}
elseif($_REQUEST['act'] == 'mooncake_site')
{
	$parent_id   = intval($_GET['parent_id']);
	$region_type = intval($_GET['region_type']);
	$site = get_regions($region_type, $parent_id);
	$site = $site?$site:'';
	die(json_encode($site));
}
?>