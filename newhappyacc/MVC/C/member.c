<?php
   class member extends _Main
 {
 	
 	function login()
 	{
 	  $this->setViewName("login");
	  $this->addObject("hideTop",true);
	  $this->addObject("hideFooter",true);
 	}
	function unlogin()
	{
		 $this->setViewName("unlogin");
		 $this->addObject("hideTop",true);
	     $this->addObject("hideFooter",true);
		 $this->addObject("REFERER",$_SERVER["HTTP_REFERER"]);
		 setcookie(User_LoginKey, "", time()-3600,"/",User_LoginDomain);
	}
	 
	 function mergeCart($username)
	 {
	 	$getCart=get_CookieCart();//获取 cookie里的购物车数据
	 	$getCacheCart=get_cache(User_Cart_CacheKey.$username);
		if(!$getCacheCart) $getCacheCart=array();
	 	if($getCart)
		{
			$getCacheCart=array_unique(array_merge($getCart,$getCacheCart));
		}
		//var_export($getCacheCart);
		if(count($getCacheCart)>0)
		{
			set_cache(User_Cart_CacheKey.$username, $getCacheCart, 3600);
			
			setcookie(User_Cart_CookieKey,
					"",
					time()-3600*24,"/",User_LoginDomain);
		}
		
		
		
		
	 }
	function login_action()
	{
		$get_username=GET("username","post");
		$get_userpass=GET("userpass","post");
		$get_remweek=intval($_POST["rem"]);
		if($get_username=="" || $get_userpass=="")
		  exit("用户名或密码不能为空");
		  $m=load_model("user"); //加载用户 表
		  $m->load(" user_name='".$get_username."' ");
		  $get_db_pass=$m->user_pass;
		  
		  if($get_db_pass && myDecrypt($get_db_pass,User_CryptKey)==$get_userpass)
		  {
			  load_lib("user", "userinfo");//加载 用户登录信息 类
			  $userinfo=new userinfo();
			  $userinfo->user_name=$get_username;
			  $userinfo->user_regtime=$m->user_regtime;
			  $userinfo->user_loginIP=IP();
			  $userinfo->user_logintime=strtotime(date('Y-m-d h:i:s'));//登录时间戳
			 
			  $cookie_string=myCrypt(serialize($userinfo), UserLogin_CryptKey) ;
			  $cooktime=$get_remweek>0?time()+3600*24*7:0;
			  setcookie(User_LoginKey, $cookie_string, $cooktime,"/",User_LoginDomain);
			  $this->mergeCart($get_username);
		  	exit("1");
		  }
		  else{
		  	exit("用户名或密码不正确");
		  }
	}
  
 }


?>