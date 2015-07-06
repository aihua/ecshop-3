<?php 
/******************************************************************************
Filename       : www.91ka.com/activity/MiaAutumnFestival/lotter_send_award.php
Author         : SouthBear
Email          : SouthBear819@163.com
Date/time      : 2010-9-9 11:56:50
Purpose        : �û��齱�н����ύ�н����Ϻ��Զ����Ϳ��ܽ�Ʒ
Mantis ID      : 
Description    : 
Revisions      : 
Modify         : 
Inspect        : 
******************************************************************************/
include_once("initFront.inc.php");
include_once("setting.inc.php");
include_once("function.php");
include_once('clsDB.php');


$obj_db = new clsDB();

$str_action = strval(trim($_POST['action']));
if($str_action == 'data'){//�û��ύ���콱����Ȼ�����ʼ�
   $str_rec_username = strval(trim($_POST['winner_name']));  //�н�������
   $str_rec_email    = strval(trim($_POST['winner_email']));  //�н���EMAIL
   $bol_chc = CheckUserMail($str_rec_email);
   if(!$bol_chc){
       raiseError("�ջ���EMAIL����������д��ȷ��EMAIL");
   }
   $str_order_no    = strval(trim($_POST['orderno']));        //��������
   
   //��ѯ�н���¼         
   $str_sql = "SELECT a.order_no,a.status,a.ctime,a.is_get_award,a.winner_name,a.winner_email,a.is_pay,a.utime,a.award 
                 FROM lottery a, user_order b 
  		          WHERE a.user_name = b.username 
  		            AND a.order_no  = b.order_no 
  			          AND a.user_name = '".$_SESSION['user_name']."' 
  			          AND a.order_no  = '".$str_order_no."' ";
   $obj_db->query($str_sql);
   $arr_res = $obj_db->fetchArray();	
   if(!is_array($arr_res) || count($arr_res) != 1){
       raiseError("���޸ö���".$str_order_no."�ĳ齱��¼");
   }
   if($arr_res[0]['STATUS'] != 1){
       raiseError("���޸ö���".$str_order_no."���н���¼");
   }
   if($arr_res[0]['IS_PAY '] == 1){
       raiseError("�ö���".$str_order_no."�Ľ�Ʒ�Ѿ����ͣ������");
   }
   
   //��¼���ϲ����߷��Ϳ���
   $str_sql = "UPDATE lottery 
                  SET is_pay = 1,is_get_award = 1,pay_time = SYSDATE,award_time = SYSDATE,
                      winner_name = '".$str_rec_username."', winner_email = '".$str_rec_email."' 
                WHERE order_no  = '".$str_order_no."' 
                  AND user_name = '".$_SESSION['user_name']."'";
   $obj_db->query($str_sql);
   
   switch($arr_res[0]['AWARD']){
       case '0': //�������缪���
          $int_prod_id    = 481;
          $str_award_name = '�������缪���'; 
       break;
       case 1:  //Զ��OL�������ǿ�
          $int_prod_id = 481;
          $str_award_name = 'Զ��OL�������ǿ�';
       break;
       case 2:  //��Ѫ�⴫�׽����ֿ�
          $int_prod_id = 481;
          $str_award_name = '��Ѫ�⴫�׽����ֿ�';
       break;
       case 3:  //ʮ��Ӣ�۴�������
          $int_prod_id = 481;
          $str_award_name = 'ʮ��Ӣ�۴�������';
       break;
       case 4:  //�������ֿ�
          $int_prod_id = 481;
          $str_award_name = '�������ֿ�';
       break;
       case 5:  //�������׽���￨
          $int_prod_id = 481;
          $str_award_name = '�������׽���￨';
       break;
       case 6:  //�λ�����888Ԫ���ֿ�
          $int_prod_id = 481;
          $str_award_name = '�λ�����888Ԫ���ֿ�';
       break;
       case 7:  //��ѶQ��30Ԫ��
          $int_prod_id = 481;
          $str_award_name = '��ѶQ��30Ԫ��';
       break;
   }
      
   //����ȡ��
   include_once('clsActivity.php');
   $obj_active = new clsActivity();
   $arr_cards = $obj_active->get_send_card($int_prod_id);
   $arr_cards['order_no'] = $str_order_no;
   $arr_cards['prod_id']  = $int_prod_id;   
   $bol_succe = $obj_active->write_order_present_log($arr_cards);
   
   //�����ʼ�
   $str_subject = '91KA���ֵ㿨�̳ǳ齱�н���Ʒ�ͻ�֪ͨ��';    
   $str_body  = '�װ��Ļ�Ա'.$_SESSION['user_name'].'��<BR>';
   $str_body .= '&nbsp;&nbsp;&nbsp;&nbsp;���ã�����' .$arr_res[0]['UTIME']. '��91KAϵͳ�ĳ齱���Ӯ�ý�Ʒ'.$str_award_name.'��<BR>';
   $str_body .= '----------------------------------------------------------------<BR>';
   $str_body .= '��Ʒ��Ϣ���£�<BR>';
   $str_body .= '<table width="500" border="0" cellpadding="5" cellspacing="0" bgcolor="#CCCCCC">
                  <tr bgcolor="#EAEAEA">
                    <td width="240">����</td>
                    <td width="240">����</td>
                  </tr>
                  <tr bgcolor="#FFFFFF">
                    <td>'.$arr_cards['no'].'</td>
                    <td>'.$arr_cards['pwd'].'</td>
                  </tr>
                </table>   ';
   $str_body .= '----------------------------------------------------------------<BR>';
   $str_body .= '��Ʒʹ�÷�ʽ��飺<BR>';
   
   if($int_award_id == '0'){//�������缪���
      $str_body .= '�ٷ���վ��http://lt.baiyou100.com/<BR>
                    ʹ�÷�ʽ�����½������ַ��ѡ�������ڵ���Ϸ���������������缪��𿨵ġ����롱���м���:<BR>
                    http://lt.baiyou100.com/ActivityList/A0013/UseRandomCard.aspx';
   }
   if($int_award_id == 1){//Զ��OL�������ǿ�
      $str_body .= '�ٷ���վ��http://yz.szgla.com/main.html<BR>
                    ʹ�÷�ʽ�����½��Ϸ�ڼ����ҿ��Ե������������㳡������ʷ��57,40�����������������м��';
   }
   if($int_award_id == 2){//��Ѫ�⴫�׽����ֿ�
      $str_body .= '�ٷ���վ��http://sx.baiyou100.com/<BR>
                    ʹ�÷����������ڹٷ���վע�����ͨ��֤����½������ַ���У����ѡ������Ҫ����Ĵ��������������ÿ���˺�ֻ�ܼ���һ�Ρ�<BR>
                    http://acc.baiyou100.com/SpeedReg/RegForSxft.aspx?AdID=1071';
   }
   if($int_award_id == 3){//ʮ��Ӣ�۴�������
      $str_body .= '�ٷ���վ��http://10hu.8kdd.com <BR>
                    ʹ�÷�����http://10hu.8kdd.com/byh/code/index.html';
   }
   if($int_award_id == 4){//�������ֿ�
      $str_body .= '�ٷ���վ��http://www.lianyu.com <BR>
                    ʹ�÷�����<BR>
                    	1��ÿ�����ֿ�ֻ��һ���˺���һ����ɫ��һ���������ʹ�ã��޷��ظ�ʹ�á�<BR>
                    	2�������ֿ���ʹ�����̣�<BR>
                          ��1����½������ע���ʺţ��������ʺŵ��Թ��˲���<BR>
                          ��2����¼��Ϸ��������ɫ����������Ϸ�ڴ�����ɫ���Թ��˲���<BR>
                          ��3���ڹٷ���վ�ϵ�¼��������ʺţ�<BR>
                          ��4����¼�ɹ��󣬵�����������ִ��������ť�����뼤��ҳ�档<BR>
                          ��5���������ֿ����룬ѡ�����ڷ������ͽ�ɫ������ȷ�ϡ�<BR>
                          ��6������ɹ�����¼��Ϸ����ҿ���������Ľ�ɫ��Ʒ����鿴ʹ�á�<BR>
                          	ע���������ֿ�ǰ��������������Ϸ�ｨ����ɫ��';
    
   }
   if($int_award_id == 5){//�������׽���￨
      $str_body .= '�ٷ���վ��http://fs.51yx.com/index.html <BR>
                    ʹ��˵�� <BR>
                    1.������󣬽�����Ϸ��NPC����Ʒʹ�ߡ��Ի�����ȡ������<BR>
                    2.�׽𿨽������ݸ��ݼ�����з��ţ�����Խ�߻�õĽ���Խ����������55���� <BR>
                    3.����û���κεȼ����ƣ�ÿ���ʺŽ�����ȡ������һ�Σ������ظ����<BR>
                    4.�����ڵ��߾�Ϊ�󶨵��ߣ����ɽ��ס� <BR>
                    5.�������ս���Ȩ�鱱�����չ��Ƽ����޹�˾���С� <BR>
                    �׽���ϸ��Ʒ���� <BR>
                    	10��  �������ר������һ����ɫɫţ\������\�ɷɵ�\�Թ��ܣ� <BR>
                      25�� ��������1����ƽ�ҿ�2�� <BR>
                      40�� ������ҩ3����40���ƽ���������Ӧְҵ�� <BR>
                      55�� ����˫��ѵ����3�š���Ч˫����1�š���֮����1������֮����1��';
   }   
   if($int_award_id == 6){//�λ�����888Ԫ���ֿ�
      $str_body .= '�ٷ���վ��http://ml.playcool.com/m/sales/index.html <BR>
                    ʹ�÷�����http://ml.playcool.com/xsk/ <BR>
                    ÿ���˺�ֻ����ȡһ�����ֿ����������˺��׸��������Ϸ���е�һ�������Ľ�ɫ�����ʸ�ʹ�ã��������������Ϊ�󶨵��ߣ����ɽ��ס�';
   } 
   if($int_award_id == 7){//��ѶQ��30Ԫ��
      $str_body .= '�ٷ���վ��http://www.qq.com <BR>
                    ʹ�÷�ʽ�����½ http://pay.qq.com ��QQ�Ž��г�ֵ.';
   }

   $str_body .= '----------------------------------------------------------------<BR>';      
   $str_body .= '<p><font color="#FF0000">���ʼ���ϵͳ�Զ����ͣ���һظ�!</font>'; 

   if(!autoSendEmail($str_subject, $str_body, array($arr_res[0]['WINNER_EMAIL']))){
  	   raiseError('�ܱ�Ǹ����Ʒ����ʧ�ܣ�����ϵ���ǵĿͷ�����֪���Ķ������룺'.$str_order_no);
   }else{
  	   raiseMsg('��ϲ������Ʒ�ɹ����ͣ��뵽���ύ������'.$arr_res[0]['WINNER_EMAIL']."���в���!",'../../index.php',5);
   }   
}
?>