/******************************************************************************
Filename       : admin/jscript/batch_delete.js
Author         : WeiChen
Email          : chengjiawei2000@163.com
Date/time      : 2009-07-27 14:22:10
Purpose        : ������ɾ����������
Mantis ID      : 
Description    : 
Revisions      : 
Modify         : 
Inspect        :
******************************************************************************/
<!--
 //ȫѡ/��ѡ
  function CheckAll(para1,para2){
    var objForm = document.forms[para1];
    var objLen  = objForm.length;
 
    for (var i = 0; i < objLen; i++){
        if (para2.checked == true){
            if (objForm.elements[i].type == "checkbox"){
                objForm.elements[i].checked = true;
            }
        }else{
            if (objForm.elements[i].type == "checkbox"){
                objForm.elements[i].checked = false;
            }
        }
    }
  } 

  //ɾ��ѡ����Ʒ
  function del_chk(para1,handle){
    var obj_form = document.forms[para1];
    var chkflag  = false;
    var num = obj_form.elements.length;
    var intCount = 0;
    
    for(var i = 0; i < num; i++){
    	  if(obj_form.elements[i].checked){
    		   chkflag = true;
    		   intCount = intCount+1;
    			 break;
    	  }
    }

    if(intCount < 1){
       window.alert("��ѡ�����账��ļ�¼��");
       return false;
    }
    

    var isAlert = window.confirm("ȷ�ϲ���ѡ���ļ�¼?");
    if(!isAlert) return false;

     obj_form.action = handle;  
    //obj_form.action = handle+"?actions=del";
    obj_form.submit();
  } 

      
-->
