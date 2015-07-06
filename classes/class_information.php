<?php
/**
 *  ��������index.php��ʾ��Ѷ��Ϣ
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �����·����������޹�˾������������Ȩ����
 * ��վ��ַ: http://www..com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: zenghd $
 * $Id: class_information.php 17217 2014-09-18 20:01:08Z zenghd $
*/
class class_information{
	
	private $db = '';
	
	private $ecs = '';
	
	function __construct($admin_agency_id=0)
	{
		$this->admin_agency_id = $admin_agency_id;
		$this->db = $GLOBALS['db'];
		$this->ecs = $GLOBALS['ecs'];
	}
	
	/**
	* ��ȡ��Ѷ��������
	**/
	public function get_info_cats()
	{
		$info_cats = array();
		$sql_info_cats = "SELECT info_cat_id,info_cat_name FROM ".$this->ecs->table('information_category')." WHERE admin_agency_id = $this->admin_agency_id AND is_show = 1 ORDER BY show_order ASC";
		$rows=$this->db->getAll($sql_info_cats);
		foreach($rows as $r_k => $r_v){
			$info_cats[$r_v['info_cat_id']] = $r_v['info_cat_name'];
		}
		return $info_cats;
		
	}
	
	/**
	* ��ȡ��Ѷ��Ϣ
	**/
	public function get_infos_list()
	{
		$info_cats = $this->get_info_cats();
		//print_r($info_cats);
		$infos_list = array();
		$i = 0;
		foreach($info_cats as $i_k=>$i_v){
			$sql_infos_list = "SELECT info_cat_id,img_spec,img_file,title_describe,content_describe,link_url,is_start FROM ".$this->ecs->table('information')." WHERE info_cat_id = $i_k  AND is_start = 1 ORDER BY info_id DESC LIMIT 5 ";
			$rows = $this->db->getAll($sql_infos_list);
			//print_r($rows);
			if(!empty($rows)){
				foreach($rows as $r_k => $r_v){
					$infos_list[$i]['info_article']= $i_v;
					if($r_v['img_spec'] == '240x160'){
						$infos_list[$i][$r_v['img_spec']][]= $r_v;
					}else{
						$infos_list[$i][$r_v['img_spec']]= $r_v;
					}
				}
			}else{
				$infos_list[$i]['info_article']= $i_v;
				$infos_list[$i][]= array();
				
			}
			
			$i++;
		
		}
		//dump($infos_list);
		return $infos_list;
	
	}
	
	
	
}
?>