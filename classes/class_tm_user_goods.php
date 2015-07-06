<?php
/*********
* ���ã�������èƽ̨�û�����������Ʒ��Ϣ��������������������������Ʒ��Ϣ��
* 
* author��hg
**********/

class class_tm_user_goods{

	/*
	* ��¼������־
	* @$zn ��¼����
	* @$item_id ��Ʒitem_id
	*/
	public function tm_log($zn,$item_id='')
	{
		if($item_id)
		{
			$data = date('Y-m-d H-i-s',time()).'----'.$zn.',item_id:'.$item_id."\r\n";
		}else{
			$data = date('Y-m-d H-i-s',time()).'----'.$zn."\r\n";
		}
		error_log($data,3,'tm_goods.txt');
	}
	
	/**
	* ������Ʒ����
	* @$cat_name string ��Ʒ����
	* @return $goods_type_id int ��Ʒ����ID
	**/
	public function di_goods_type($cat_name)
	{
		$goods_type_id = $GLOBALS['db']->getOne("select cat_id from ".$GLOBALS['ecs']->table('goods_type')." where cat_name = '$cat_name'");
		if(!$goods_type_id)
		{
			$arr_goods_type = array('cat_name'=>$cat_name);
			$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_type'), $arr_goods_type, 'INSERT');
			$goods_type_id = $GLOBALS['db']->insert_id();
		}
		return $goods_type_id;
	}
	
	/**
	* ������Ʒ��ѡ���� 
	* @$sort string serialize�����Ʒ��ѡ����
	* @$goods_type_id ��Ʒ����id
	**/
	public function di_goods_pro($goods_sn,$goods_id,$goods_type_id,$sort)
	{
		$state = array_filter($sort);
		if(!empty($state))
		foreach($sort as $key=>$value)
		{
			$attr_id = $this->di_attribute($key,$goods_type_id,1);
			//goods_attr��
			foreach($value as $k=>$v){
				$sta = strstr($v,'http://');
				if($sta)
				{
					$pro_value_arr = explode('|',$v);
					$v = $pro_value_arr[0].'|'.'<img src='.$pro_value_arr[1].' />';
				}
				$arr_attrs = array(
								'goods_id'    => $goods_id,
								'attr_id'     => $attr_id,
								'attr_value'  => $v
							);
				$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_attr'), $arr_attrs, 'INSERT');
				$goods_attr = $GLOBALS['db']->insert_id();
				//����products��
				/*$arr_pro = array(
								'goods_id'       => $goods_id,
								'goods_attr'     => $goods_attr,
								'product_number' => '999'
							);
				$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('products'), $arr_pro, 'INSERT');
				$sql = "UPDATE " . $GLOBALS['ecs']->table('products') . "
							SET product_sn = '" . $goods_sn . "g_p" . $GLOBALS['db']->insert_id() . "'
							WHERE product_id = '" . $GLOBALS['db']->insert_id() . "'";
				$GLOBALS['db']->query($sql);*/
			}
		}
	}
	
	/**
	* ��Ʒ����attribute��
	* @$attr_name ������
	* @$goods_type_id ����ID
	* @$attr_type     ���� ��ѡ�ǿ�ѡ
	**/
	public function di_attribute($attr_name,$goods_type_id,$attr_type)
	{
		//��Ʒ����ID
		$attr_id = $GLOBALS['db']->getOne("select attr_id from " .$GLOBALS['ecs']->table('attribute').
		"where attr_name = '$attr_name' AND attr_type='$attr_type' AND cat_id = $goods_type_id");
		if(!$attr_id)
		{
			//attribute��
			$arr_attribute = array(
							'attr_name' 	  => $attr_name,
							'attr_input_type' => '0',
							'attr_type'       => $attr_type,
							'cat_id'     	  => $goods_type_id
						);
			$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('attribute'), $arr_attribute, 'INSERT');
			$attr_id = $GLOBALS['db']->insert_id();
		}
		return $attr_id;
	}
	/**
	* ��Ʒ�ǿ�ѡ����
	* 
	**/
	public function di_goods_attr($goods_sn,$goods_id,$goods_type_id,$sort)
	{
		$sort = array_filter($sort);
		if(!empty($sort))
		foreach($sort as $key=>$value){
			$arr_attr = explode(': ',$value);
			$attr_id = $this->di_attribute($arr_attr[0],$goods_type_id,0);
			$arr_attrs = array(
							'goods_id'    => $goods_id,
							'attr_id'     => $attr_id,
							'attr_value'  => $arr_attr[1]
						);
			$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_attr'), $arr_attrs, 'INSERT');
		}
	}
	/**
	* ������ƷͼƬ
	* @$goods_img array ��ƷͼƬ����
	* 
	**/
	public function di_goods_gallery($goods_id,$goods_img)
	{
		//dump($goods_img);
		unset($goods_img[0]);
		$num_arr = count($goods_img);
		if(!empty($num_arr))
			foreach($goods_img as $key=>$value){
				$arr_img = array(
							'goods_id' 		=> $goods_id,
							'img_url' 		=> $value,
							'thumb_url' 	=> $value,
							'img_original'  => $value
						);
				$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_gallery'), $arr_img, 'INSERT');
			}
	}
	
	/*������Ʒ����*/
	public function di_goods_desc($goods_desc_img)
	{
		
		$new_goods_desc = array();
		foreach($goods_desc_img as $key=>$value){
			$sta = strstr($value,'http://');
			if($sta)
			{
				$new_goods_desc[] = '<img src='.$value.' />';
			}
		}
		//dump(implode('',$new_goods_desc));
		return implode('',$new_goods_desc);
	}
}
?>