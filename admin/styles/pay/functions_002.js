//common javascript functions
/*Haisong Zheng 20050324
<meta http-equiv="Content-Type" content="text/html; charset=GB2312">
*/
//additional define method of String object.
/******************************************************************************
Filename       : www.91ka.com/function.js
Author         : SouthBear
Email          : SouthBear819@163.com
Date/time      : 2008-09-11 16:05:05
Purpose        : ��վ���õ������JS�ű�
Mantis ID      : 
Description    : 
Revisions      : 
Modify         : 
m1   SouthBear  2008-09-11   ���Ӷ�������ר���Ĵ���
Inspect        :
******************************************************************************/

//strip blank characters at the beginning and end.
String.prototype.trim = function()
{
    return this.replace(/(^\s*)|(\s*$)/g, "");
}

//�����ַ����Ƿ����������ʽreg
String.prototype.regCheck = function(reg)
{
	return reg.test(this);
}

//�����ַ����Ƿ�������
String.prototype.isNumber = function()
{
	return /^-?[0-9]+\.?[0-9]*$/.test(this);
}

//�����ַ����Ƿ���Email��ַ
String.prototype.isEmail = function()
{
	return /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9])+$/.test(this);
}

//�����ַ����Ƿ���URL
String.prototype.isURL = function()
{
	return /^[hf]t{1,2}p:\/\/(\w+:\w+\@)?(?:[0-9a-z-]+\.)+[a-z]{2,4}(?:(\/?)|(\/.*))$/i.test(this);
}

String.prototype.byteLength = function()
{
	var len = 0;
	for(var i = 0; i < this.length; i ++){
		if(this.charCodeAt(i) >= 0x80) len += 2;
		else len += 1;
	}
	return len;
}

/*
highlight display obj on mouse event eventName,
also accept the third param which is an array has 
three elements. value is RGB or predefined color.
*/
function hightlightOnEvent(obj,eventName, org)
{
	var orgColor = "#FFFFFF";
	var actColor = "#FFFF99";
	var sltColor = "#EDCD78";
	if(org != "") orgColor = org;
	if(arguments.length == 3){
		if(typeof(arguments[2]) == "object"){
			orgColor = arguments[2][0] ? arguments[2][0] : orgColor;
			actColor = arguments[2][1] ? arguments[2][1] : actColor;
			sltColor = arguments[2][2] ? arguments[2][2] : sltColor;
		}
	}
	
	if(eventName == 'OVER'){
	    if(obj.bgColor.toUpperCase() != sltColor) obj.bgColor = actColor;
	}
	if(eventName == 'OUT'){
		if(obj.bgColor.toUpperCase() != sltColor) obj.bgColor = orgColor;
	}
	if(eventName == 'CLICK'){
		if(obj.bgColor.toUpperCase() == sltColor) obj.bgColor = actColor;
		else obj.bgColor = sltColor;
	}
}

//ͼƬ�滻��������Dreamweaver����
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

//�޸�ǰ��
/*
function buy(id){
	if(id == '') return;
	window.location = 'buy.php?id='+id;
}
*/

//m1 ����������֧�����ͱ��
function buy(id,type){
	if(id == '') return;
	if(type == '1'){//1 ������
		 window.location = 'buy_szx.php?id='+id;
  }else{
     window.location = 'buy.php?id='+id;
  }
}


//�ͽ�����
function vicBuy(id)
{
	alert("Product ID is "+id);
}

//����Ƿ��ǺϷ�������
function checkdate(month, day, year)
{
	if(!(/^[1-9][0-9]{3,3}$/.test(year))){
		alert("��ݴ������ֻ����4��������ɣ���");
		return false;
	}
	if(!(/^[0-9]{1,2}$/.test(month))){
		alert("�·�ֻ��1-2����������ɡ�");
		return false;
	}
	if(!(/^[0-9]{1,2}$/.test(day))){
		alert("�µ�����ֻ����1��2��������ɡ�");
		return false;
	}
	var imonth = parseInt(month);
	var iday = parseInt(day);
	var iyear = parseInt(year);
	if(iyear < 1000 || iyear > 9999){
		alert("��ݱ�����1000-9999֮�䡣");
		return false;
	}
	if(imonth < 1 || imonth > 12){
		alert("�·ݱ�����1-12֮�䡣");
		return false;
	}
	var maxDay;
	switch(imonth){
		case 4:
		case 6:
		case 9:
		case 11:
			maxDay = 30;
			break;
		case 2:
			if(year % 4 == 0){
				maxDay = 29;
			}else{
				if(iyear % 100 ==0 && iyear % 400 == 0) maxDay = 29;
				else maxDay = 28;
			}
			break;
		default:
			maxDay = 31;
	}
	if(iday > maxDay){
		alert(year + "-" + month +  "-" + day + "���ǺϷ������ڡ�");
		return false;
	}
	return true;
}

/*Ԥ��ͼƬ
������ڣ�2005-6-8
��ҳ��װ��ʱ���ã����õ���header.tpl��body ��onload
*/
function preLoadImages()
{
	var imagesArray = new Array();
	imagesArray[0] = 'images/menu_1r.gif';
	imagesArray[1] = 'images/menu_2r.gif';
	imagesArray[2] = 'images/menu_3r.gif';
	imagesArray[3] = 'images/menu_4r.gif';
	imagesArray[4] = 'images/menu_5r.gif';
	imagesArray[5] = 'images/menu_6r.gif';
	imagesArray[6] = 'images/menu_7r.gif';
	imagesArray[7] = 'images/menu_8r.gif';
	
	for(var i = 0; i < imagesArray.length; i ++) 	MM_preloadImages(imagesArray[i]);
}

/*������������
 ������ڣ�2005-6-9, Haisong Zheng
 �����������ƣ����IE��������� MSIE��
*/
function getBrowser()
{
	var bString = navigator.appName + navigator.appVersion;
	if(/MSIE/i.test(bString)) return 'MSIE';
	if(/FireFox/i.test(bString)) return 'FireFox';
	if(/NetScape/i.test(bString)) return 'NetScape';
	if(/Opera/i.test(bString)) return 'Opera';
	
}

/*--------------------------------------------------------------------------------------
��������Ϣģ����ʾ���ܺ�������ʼ��������
ͨ���ռ�ҳ�������Ϣ�����ض���������ʾ�ض�������
Haisong Zheng
hszheng@gmail.com
2005-06-15
---------------------------------------------------------------------------------------*/
//���Ի���Ϣ����ű���ַ
var individuationInfoURL = '/individuation.php?';

/*��ʾ�������
����˳��Ϊ��width, height, type, keyword, style
width : ���ݿ�Ŀ�������Ϊ��λ
height:�����ݿ�ĸߣ�������Ϊ��λ
type:��������
qkey : Query string�ؼ���
style : Ϊ���ݿ�ķ�񣬿���Ϊ�ա�Ŀǰ��Чֵ���£�
bulletin_default
customer_service_default
provider_customer_service_default
*/
function showIndividuationInfo()
{
	var a = showIndividuationInfo.arguments;
	 
	var params = new Array();
	var width = a[0]?a[0]:0;
	var height = a[1]?a[1]:0;
	var type = a[2]?a[2]:'';
	var keyword = a[3]?a[3]:'';
	var style = a[4]?a[4]:'';
	params[0] = 'width=' + width;
	params[1] = 'height=' + height;
	params[2] = 'type='+type;
	params[3] = 'keyword='+keyword;
	params[4] = 'style='+style;
	var info_src = individuationInfoURL + params.join('&');
	outputIndividuationInfo(width, height, info_src);
}


function outputIndividuationInfo(width, height, src)
{
	document.write( '<iframe' +
				   ' name="individuationInfo"' +
				   ' frameborder="0"' +
				   ' marginwidth="0"' +
				   ' marginheight="0"' +
				   ' vspace="0"' +
				   ' hspace="0"' +
				   ' allowtransparency="true"' +
				   ' scrolling="no"' +
				   ' width=' + quote(width) +
				   ' height=' + quote(height) + 
				   ' src=' + quote(src) +
				   '></iframe>'
				   );
}

/*ȡ��ҳ����Ϣ���ļ���
*/
function getKeyword()
{
	var info = this.location.toString();
	var kstr = info.substr(info.lastIndexOf('/') + 1);
	return (encodeURIComponent(kstr));
}
/*���ַ������������Ա����HTML
*/
function quote(str) {
  return (str != null) ? '"' + str + '"' : '""';
}

function popWin(url, width, height)
{
	window.open(url, "popWindow", "menubar=no, location=no, resizable=no,scrollbars=no, tollbar=no, status=no, width="+ width +", height="+ height +", left=80, top=80");
}

/*
�ֻ���溯��,����image�����onload����
����������,
args[0]: �ֻ�ʱ��,��λ��, Ĭ��5��
args[1]: ��ǰͼƬ����,��0��ʼ
args[2]: ͼƬ��������
args[3]: ��һ��ͼƬ��URL,Ĭ��Ϊ this.src
args[4]: ��һ��ͼƬ������
args[5]: �ڶ���ͼƬ��URL
args[6]: �ڶ���ͼƬ������
*/
var arr_obj_rotate_images = new Array();
function rotate_images()
{
    var args = rotate_images.arguments;
    //��������5��,�����ֻ��һ��ͼƬ,����Ҫ�ֻ�
    if(args.length < 6) return;
    var delay = args[0];
    var idx = args[1];
    var obj = args[2];
    var img_count = Math.ceil((args.length - 3) / 2);
    var obj_idx = -1;
    for(var i = 0; i < arr_obj_rotate_images.length; i ++){
        if(arr_obj_rotate_images[i] == obj){
            obj_idx = i;
            break;
        }
    }
    if(obj_idx < 0){
        obj_idx = arr_obj_rotate_images.length;
        arr_obj_rotate_images[obj_idx] = obj;
    }
    //�Ƴ�ͼƬ�ֻ�����ñ��������¼�
    obj.onload = new Function ("return false");
    obj.src = args[3 + idx * 2];
    obj.onclick = new Function("window.open('"+args[4 + idx * 2]+"', '_blank', '');");
    idx ++;
    if(idx >= img_count) idx = 0;
    var imgs = "";
    for(var i = 3; i < args.length; i ++) imgs += ", '" + args[i]+"'";
    setTimeout("rotate_images("+delay+", "+idx+", arr_obj_rotate_images["+obj_idx+"]"+ imgs +");", delay * 1000);
}
//�ͷ�����
function openTXKF(val){
	var surl = "http://cs.untx.com/txkf_index.php?s=3";
	if(val) surl += "&k="+val; 
	window.open(surl,"_blank","menubar=no, location=no, resizable=no, tollbar=no, status=no, scrollbars=no, width=700, height=475, left=260, top=260");
}