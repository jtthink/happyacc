<?php 

// 通用web函数
function the_user() //获取当前登录用户
{
	if(isset($_COOKIE[User_LoginKey]))
	{
		$getcookie=myDecrypt($_COOKIE[User_LoginKey], UserLogin_CryptKey);
	 
	 	  load_lib("user", "userinfo");
		  $userinfo=new userinfo();
		  $userinfo=unserialize($getcookie);
	 	 // var_export($userinfo);
		  //exit($userinfo->user_name);
		if($userinfo && $userinfo->user_name!="" && $userinfo->user_loginIP==IP())
		{
			//判断cookie的合法性
			return $userinfo;
		}
		return false;
	}
	return false;
}
function safeText($str)
{
	 $getValue=trim($str);
	    $farr = array(
        "/<(\/?)(script|i?frame|style|object|html|body|title|object|link|meta|\?|\%)([^>]*?)>/isU", //过滤 <script 等可能引入恶意内容或恶意改变显示布局的代码,假如不需要插入flash等,还可以加入<object的过滤
        "/(<[^>]*)on[a-zA-Z] \s*=([^>]*>)/isU", //过滤javascript的on事件
        );
	    $tarr = array(
        "", //假如要直接清除不安全的标签，这里可以留空
        "\\1\\2",
        ); 
	  $getValue = preg_replace( $farr,$tarr,$getValue);
	   $getValue=strip_tags($getValue);//去除html和php 标记
	   $getValue=addslashes($getValue);//单双引号、反斜线及NULL加上反斜线转义
	   $getValue=str_replace(array("gcd"),"",$getValue);//过滤敏感字符
	   return $getValue;
}
function GET($pname,$method="get")
{
	$plist=$method=="get"?$_GET:$_POST;
	if(isset($plist[$pname]))
	{
	  $getValue=safeText($plist[$pname]);
	  return $getValue;
	}
	else
		return false;
}

function IP()
{
 
		if(!empty($_SERVER["HTTP_CLIENT_IP"])){
		  $cip = $_SERVER["HTTP_CLIENT_IP"];
		}
		elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
		  $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		elseif(!empty($_SERVER["REMOTE_ADDR"])){
		  $cip = $_SERVER["REMOTE_ADDR"];
		}
		else{
		  $cip = "";
		}
		return $cip;
	 
		 
 
}
function set_cache($key,$value,$expire)
{
	$m=new Memcache();
	$m->connect(Cache_IP,Cache_Port);
	$m->set($key,$value,0,$expire);
	
}
function get_cache($key)
{
	 //获取缓存
	$m=new Memcache();
	$m->connect(Cache_IP,Cache_Port);
	return $m->get($key);
}
function get_CookieCart() //封装方法 获取用户未登陆时的购物车
{
	$getCart=$_COOKIE[User_Cart_CookieKey];
				if($getCart)
				{
					$getCart=myDecrypt($getCart, User_Cart_CryptKey);
					
					if(!$getCart || trim($getCart)=="") return false;
				 
					return unserialize($getCart);
				}
				return false;
}
function load_model($mName)
{
	 $mdPath="MVC/M/".$mName.".m";
 	if(file_exists($mdPath))
 		require_once($mdPath);
 	 
	return new $mName();
}

function load_lib($lib,$libName)
{
	//后缀必须是php
	require_once("Lib/".$lib."/".$libName.".php");
}
 function the_pagebar($allcount,$p,$pagesize,$maxpage)
{
	$pagenum=1;
	 if($allcount>$pagesize)  //计算出 共多少页
    {
        if(($allcount%$pagesize)>0)
        {
            $pagenum=ceil($allcount/$pagesize);
        }
        else
         $pagenum=intval($allcount/$pagesize);
    }
	if($pagenum==1) return;
    //每次最多显示 默认10页 
    $startpage=1;
    $endpage=$maxpage;
    if($pagenum<$maxpage) $endpage=$pagenum;
    if($p>$pagenum) $p=1; //当前页码 大于总页码数 是不允许的，直接令其为1
    if($p>$maxpage)
    {
        $countpage=(($p/$maxpage)+1)*$maxpage; //计算当前页所属 页码段的最大值
        if($countpage>$pagenum)
          $countpage=$pagenum;
          
         $halfmaxpage=$maxpage/2;
         
         if($p+$halfmaxpage>$countpage)
         {
            $endpage=$countpage;
         }
         else 
           $endpage=$p+$halfmaxpage;
         $startpage= $p-$halfmaxpage;  
    }
    if($p>1)
      $pagebar_result.='<a class="a1" href="'.UpdateParams($p-1).'">'
					.'<img   src="/img/icon/ico_jt-2.png">'
					.'</a>'; //上一页
    for($i=$startpage;$i<=$endpage;$i++)
    {
        if($i==$p)
         $pagebar_result.= "<a class='on'  href='".UpdateParams($i)."'>".$i."</a>";
        else
        $pagebar_result.= "<a href='".UpdateParams($i)."'>".$i."</a>";
    }
    if($p<$pagenum)
	{
		$pagebar_result.= '<a class="a1" href="'.UpdateParams($p+1).'">'
					.'<img src="/img/icon/ico_jt-3.png">'
					.'</a>'; //下一页
   		// $pagebar_result.= "<li><a href='".UpdateParams($pagenum)."'>末 页</a></li>";
	}
	//加入跳转到代码
	if($pagenum>=$maxpage) //小于最大页数显示跳转到没有意义
	{
		$pagebar_result.='跳转到  : <input type="text" id="pagebartxt">  <a id="pagebargo" class="a1 " href="#" > GO </a>';
	}
    echo  $pagebar_result;
}
 function UpdateParams($paramValue,$paramName="page")
 {
 	$url=$_SERVER["REQUEST_URI"];
    if(strpos($url,$paramName."=")) 
        {
            $i=strpos($url,$paramName."=");
            $start=substr($url,0,$i).$paramName."=".urlencode($paramValue);//前面部分截取完毕
            $end=substr($url,$i+strlen($paramName."="));//后面部分
            if(strpos($end,"&") && strpos($end,"&")>0)
               $end=substr($end,strpos($end,"&"));
             else
               $end="";
            
            
            $url=$start.$end;
        }
        else
        {
             if(strpos($url,"?"))  //代表 有问号
                $url=$url."&".$paramName."=".urlencode($paramValue); //加入参数
                else
                 $url=$url."?".$paramName."=".urlencode($paramValue); //加入参数
        }
    
     
    return $url;
 }
//加载 外部函数
require("crypt.php");//加密函数

?>