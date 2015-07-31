<?php
include("my.conf");
  
  
 /* include "Lib/db/NotORM.php";
$pdo = new PDO(DB_DSN,DB_User,DB_UserPass);
$pdo->exec("set names utf8");
$db = new NotORM($pdo);

echo $db->shop_news()->select("id, news_title")->order("id desc")->limit(10);
  * */

/*
foreach($db->shop_news() as $news)
{
	echo $news["news_title"]."_".$news["news_intr"]."<br/>";
}
*/
require("Common/functions.php"); //加载全站 函数文件
require("MVC/C/_Main.c");//加载control主文件
require("MVC/M/_Model.m");//加载Model主文件


$get_control=isset($_GET["control"])?trim($_GET["control"]):"index";
$get_action=isset($_GET["action"])?trim($_GET["action"]):"index";
$prefix="";
$admin_user="shenyi"; //测试后台用户名
$admin_role=array("editor","admin"); //测试后台用户角色 
isset($_GET['isservice']) && $prefix='service/';//引导进入service文件夹
if(file_exists("MVC/C/".$prefix.$get_control.".c"))
{
	require("MVC/C/".$prefix.$get_control.".c");
	$control=new $get_control();
	if( method_exists ($control,$get_action))
	{
		$getClass=new ReflectionClass($control);
		$getMethod=$getClass->getMethod($get_action);
		if($getMethod)
		{
			$comments=$getMethod->getDocComment();//获取该方法的注释
			if(preg_match("/permission:{(.*?)}/i", $comments,$match_result)) //代表需要进行权限处理
			{
				$permission=$match_result[1];
				$permission=json_decode("{".$permission."}");
				if($admin_user!="" && in_array($permission->role, $admin_role))
				 {
				 	$control->$get_action();
					$control->run();
				 }
				else
				{
					exit("您没有权限");
				}
			}
			else
			{
			 $control->$get_action();
			$control->run();
			}
			
		}
		else
		{
			exit("找不到该页");
		}
		
	}
}
 
?>