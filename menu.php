<?php

	define("APPID","wxc30b873f7ad323ca");//测试号
	define("APPSECRET","f8b7fc8683913d042ce122c590164620");

	
	//获取access_token（支持自动更新凭证）
	function get_access_token()
	{
		static $start_time = 1440090151;
		$access_token = "6bFyEmE_KsQIFlQUvEZ4R6T_t0XWTV2C7dmRn8Na2orKaCIJHXj1dxx3snwHN2qxMsk3C_ncDPZ9D0AM797_53xBrJyrw0JPXNOneN8HcurNWbugFGRHwT9_avDL3CWcCVGcACAWPA";

		if(time() > ($start_time + 7200))
		{
			//GET请求的地址
			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".APPID."&secret=".APPSECRET;
	 		$access_token_Arr =  https_request($url);
	 		var_dump($access_token_Arr);
	 		echo '$access_token_Arr'.$access_token_Arr['access_token'];
	 		return $access_token_Arr['access_token'];			
		}
		return $access_token;
	}


	//https请求（支持GET和POST）
	function https_request($url,$data = null)
	{
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		if(!empty($data))
		{
			curl_setopt($ch,CURLOPT_POST,1);//模拟POST
			curl_setopt($ch,CURLOPT_POSTFIELDS,$data);//POST内容
		}
		$outopt = curl_exec($ch);
		curl_close($ch);
		$outopt = json_decode($outopt,true);
		return $outopt;
	}

	//创建菜单
	function menu_create($data)
	{
		$access_token = get_access_token();
		$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$access_token}";
		return https_request($url,$data);
	}

	//查询菜单
	function menu_select()
	{
		$access_token = get_access_token();
		$url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$access_token}";
		return https_request($url);
	}

	//删除菜单

	function menu_delete()
	{
		
		$access_token = get_access_token();
		$url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={$access_token}";
		return https_request($url);
	}

	$post = '{
			     "button":[
			     {	  "name":"基本信息",
			      	  "sub_button":[
			           {	
			               "type":"view",
			          	   "name":"餐馆介绍",
			               "url":"http://31142372.applinzi.com/application.php/Home/Description/description"
			            },
			            {	
			               "type":"view",
			          	   "name":"菜品预览",
			               "url":"http://31142372.applinzi.com/application.php/Home/Description/dishesIndex"
			            },
			            {	
			               "type":"view",
			          	   "name":"餐桌动态",
			               "url":"http://31142372.applinzi.com/application.php/Home/Description/deskInfo"
			            },
			            {	
			               "type":"view",
			          	   "name":"扫码上墙",
			               "url":"http://31142372.applinzi.com/application.php/Home/User/user"
			            }]
			      },
			      {
			           "name":"会员中心",
			           "sub_button":[
			            {
			               "type":"click",
			               "name":"查询资料",
			               "key":"M_SELECT"
			            }]
			      },
			      {
			           "name":"点餐系统",
			           "sub_button":[
			           {	
			               "type":"view",
			               "name":"预定",
			               "url":"http://31142372.applinzi.com/application.php/Home/Desk/deskInfo"
			            },
			            {
			               "type":"view",
			               "name":"点餐",
			               "url":"http://31142372.applinzi.com/application.php/Home/Dishes/dishesOrder"
			            },
			            {
			               "type":"view",
			               "name":"取消预定",
			               "url":"http://31142372.applinzi.com/application.php/Home/Reserve/abrogate"
			            },
			            {
			               "type":"click",
			               "name":"评价",
			               "key":"D_JUDGEMENT"
			            }]
			       }]
			 }';

	print_r(menu_create($post));
	//print_r(menu_select());
	//print_r(menu_delete());
	