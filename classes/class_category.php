<?php
/*********************************
* ˵������������̷������
* date:2014-8-8
* author:hg
* 
*
*********************************/

class class_category
{
    
    /**
    * ˵��:�����Ѵ��ڵ��������ӷ���
    * @$exist_cat_id ����ID
    * @$admin_agency_id ������ID
    * @$agency_attr    ��Ҫ���ִ������վ������
    **/
    public function exist_add_cat($exist_cat_id,$admin_agency_id,$agency_attr)
    {
        $res = $GLOBALS['db']->getRow("SELECT agency_cat,host_cat FROM ".$GLOBALS['ecs']->table('category').
        " WHERE cat_id = $exist_cat_id");
        #��վ��ӷ���
        if(!$admin_agency_id)
        {
            if($res['host_cat']) return true;//�Ѿ����
            $set = ',';
            foreach($agency_attr as $key=>$value){
                $set .= $key.'='."'$value',";
            }
            $set = substr($set,0,-1);
            $sql = "UPDATE ".$GLOBALS['ecs']->table('category').
            " SET host_cat = 1 $set WHERE cat_id = $exist_cat_id";
            if($GLOBALS['db']->query($sql)) return false;//��ӳɹ�
        }
        else
        {
            #���������
            $return = $this->agency_exist_add_cat($res['agency_cat'],$exist_cat_id,$admin_agency_id,$agency_attr);
			return $return == true?true:false;
        }
        return false;
    }
	/**
	* ˵���������Ѵ��ڵ�����£���������ӷ���
	* add by hg for date 2014-09-02
	**/
	public function agency_exist_add_cat($agency_cat,$exist_cat_id,$admin_agency_id,$agency_attr)
	{
		if(strpos($agency_cat,','.$admin_agency_id.',') !== false) return true;//�Ѵ���
		if(empty($agency_cat)) $agency_cat = ',';
		$agency_cat .= $admin_agency_id.',';
		$GLOBALS['db']->query("UPDATE ".$GLOBALS['ecs']->table('category').
		" SET agency_cat = '$agency_cat' WHERE cat_id = $exist_cat_id");
		$agency_attr['admin_agency_id'] = $admin_agency_id;
		$agency_attr['cat_id'] = $exist_cat_id;
		if($GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('category_attribute'), $agency_attr, 'INSERT')) return false;
	}
	
    /**
    * ˵���������µ�һ����������
    * @$cat array ��������
    **/
    public function add_cat($cat)
    {
        $admin_agency_id = admin_agency_id();
        if($admin_agency_id)
        {
			if(empty($cat['agency_cat'])) $cat['agency_cat'] = ','.$admin_agency_id.',';
			if(!isset($cat['host_cat']))  $cat['host_cat'] = 0;
			$cat_id = $this->agency_add_cat($cat,$admin_agency_id);
			
        }
        else
        {
            $state = $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('category'), $cat);
            $cat_id = $GLOBALS['db']->insert_id();
        }
        return $cat_id;
    }
	
	/**
	* ˵��:��������ӷ���
	* add by hg for date 2014-09-01
	**/
	public function agency_add_cat($cat,$admin_agency_id)
	{
		$cat['grade'] = '0';
		$cat['filter_attr'] = '';
		$cat['show_in_nav'] = '0';
		//$cat['is_show'] = '0';  //ע��2015-03-20 ��������ӵķ���Ҫ������ѡ��(�Ƿ���ʾ)ʵ�ʣ�����Ĭ��Ϊ0
		$state = $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('category'), $cat);
		$cat_id = $GLOBALS['db']->insert_id();
		$agency_attr = array(
					'grade'       => $cat['grade'],
					'filter_attr' => $cat['filter_attr'],
					'show_in_nav' => $cat['show_in_nav'],
					'is_show'     => $cat['is_show'],
					'admin_agency_id'     => $admin_agency_id,
					'cat_id'      => $cat_id,
					'sort_order'    => $cat['sort_order'],
					'measure_unit'  => $cat['measure_unit']
				);
		$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('category_attribute'), $agency_attr, 'INSERT');
		return $cat_id;
	}
    /** 
    * ˵��:ɾ������
    * @$cat_id ����ID;
    *
    **/
    public function del_cat($cat_id)
    {
        $admin_agency_id = admin_agency_id();
        $cat_res = $GLOBALS['db']->getRow("SELECT agency_cat,host_cat FROM ".$GLOBALS['ecs']->table('category').
        " WHERE cat_id = $cat_id");
        if($admin_agency_id)//������ɾ������
        {
            if(($cat_res['agency_cat'] == ','.$admin_agency_id.',') && empty($cat_res['host_cat']))
            {
                //ɾ�������̷�������
                $GLOBALS['db']->query("DELETE FROM".$GLOBALS['ecs']->table('category_attribute').
                " WHERE cat_id=$cat_id AND admin_agency_id=$admin_agency_id");
                return true;
            }
            else
            {
                //ɾ�������̷����ʶ�ͷ�������
                $this->agency_del_cat($cat_res['agency_cat'],$cat_id,$admin_agency_id);
                return false;
            }
        }
        else
        {
            if(empty($cat_res['agency_cat']))
            {
                return true;
            }
            else
            {
                $GLOBALS['db']->query("UPDATE ".$GLOBALS['ecs']->table('category').
                " SET host_cat = 0 WHERE cat_id = $cat_id ");
                return false;
            }
        }
    }
    /**
    * ������ɾ������
    * $agency_cat �����������ĸ�������
    * $cat_id       ����ID
    * $admin_agency_id ������ID
    * add by hg for date 2014-09-01
    **/
    public function agency_del_cat($agency_cat,$cat_id,$admin_agency_id)
    {
        $new_agency_cat = preg_replace("|,$admin_agency_id,|",',',$agency_cat);
        if($new_agency_cat == ',') $new_agency_cat = null;
        $GLOBALS['db']->query("UPDATE ".$GLOBALS['ecs']->table('category').
        " SET agency_cat = '$new_agency_cat' WHERE cat_id = $cat_id ");
        //ɾ�������̷�������
        $GLOBALS['db']->query("DELETE FROM".$GLOBALS['ecs']->table('category_attribute').
        " WHERE cat_id=$cat_id AND admin_agency_id=$admin_agency_id");
        return true;
    }
	/**
	* ɾ�������Ƽ�
	* 
	**/
	public function del_cat_recommend($cat_id ,$admin_agency_id)
	{
		
	}
}





?>