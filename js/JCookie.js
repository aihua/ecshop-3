/*�������ѡ��ҳ��������ʴ���JS  add by zenghd for date 2014-09-01 */ 

function jQuery_cookie(name, value, ptions) {
	//alert(typeof value);//'undefined'
	if (typeof value != 'undefined') { // name and value given, set cookie
		options = ptions || {};
		if (value === null) {
			value = '';
			options.expires = -1;
		}
		var expires = '';
		if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
			var date;
			if (typeof options.expires == 'number') {
				date = new Date();//alert(date.getTime());
				date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));//* 24 * 60 * 60 * 1000
			} else {
				date = options.expires;
			}
			 // use expires attribute, max-age is not supported by IE
			expires = '; expires=' + date.toUTCString();//alert('; expires=' + date.toUTCString());
		}
	
		var path = options.path ? '; path=' + options.path : '';
		var domain = options.domain ? '; domain=' + options.domain : '';
		var secure = options.secure ? '; secure' : '';
		document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
	} else { // only name given, get cookie
		var cookieValue = null;
		if (document.cookie && document.cookie != '') {
			var cookies = document.cookie.split(';');
			for (var i = 0; i < cookies.length; i++) {
				var cookie = jQuery.trim(cookies[i]);
				// Does this cookie string begin with the name we want?
				if (cookie.substring(0, name.length + 1) == (name + '=')) {
					cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
					break;
				}
			}
		}
    	return cookieValue;
    }

};
//��¼������ʾ���·��ʵĳ��б��ID
function jq_cookie(city_id){
	
	save_accessed_cookie(city_id);
	get_accessed_cookie();
	
}

function save_accessed_cookie(city_id){
	
	var access_history;
	//���·��ʵĳ��б��ID
	if(typeof(city_id) != 'undefined' && city_id != ''){
		var cid=city_id;
	}
	
	//����cookie����������¼������
	var N=10;
	var count=0;
	//�ж��Ƿ����cookie
	if(jQuery_cookie('lately_accessing')==null) //cookie ������
	{
		//�����µ�cookie,���������¼
		jQuery_cookie('lately_accessing',cid,{expires:1,path:'/'});
		//$.cookie('smile1314h',nid,{expires:7,path:'/',domain:'smile1314.com',secure:true});
	}
	else //cookies�Ѿ�����
	{
		//��ȡ������ĳ��б��ID
		access_history=jQuery_cookie('lately_accessing');
		
		//�ֽ��ַ���Ϊ����
		var pArray=access_history.split(',');
		//���·��ʵ���Ʒ��ŷ�������ǰ��
		access_history=cid;
		//�ж��Ǹ���Ʒ����Ƿ������������ʵļ�¼����
		for(var i=0;i<pArray.length;i++)
		{
			if(pArray[i]!=cid)
			{
				access_history=access_history+","+pArray[i];
				count++;
				if(count==N-1)
				{
					break;
				}
			}
		}
		//�޸�cookie��ֵ
		jQuery_cookie('lately_accessing',access_history,{expires:1});
	}

}

//ajax ���ݳ��б�Ż�ȡ��Ϣ�б�
function get_accessed_cookie(){
	var cookie_value =jQuery_cookie('lately_accessing');
	if(cookie_value){
		var cookie_arr = cookie_value.split(',');
		$.ajax({
				url:'region.php',
				type:'POST',
				data:{act:'query_lately_accessing',lately_accessing_id:cookie_arr},
				beforeSend:function(){
					//alert('׼������...');
				},
				dataType:'json',
				success:function(lately_accessing_result){
					var lately_accessing_len = lately_accessing_result.length;
					var lately_accessing_str = '';
					for(var j=0;j<lately_accessing_len;j++){
						lately_accessing_str += "<a href='region.php?act=change_city&city_name="
												+lately_accessing_result[j].region_name
												+"&city_id="+lately_accessing_result[j].region_id
												+"' onclick='jq_cookie("+lately_accessing_result[j].region_id+")'>"
												+lately_accessing_result[j].region_name
												+"</a>";
					}
					$('#lately_visit').html('').append(lately_accessing_str);
				}
				
		});
	}
}









