<?php
 class news extends _Main
 {
 	
	 function newsindex()
	 { 
	 	$newsid=323;
	 	$result=$this->getService("NewsService","getNewsDetail",array("newsid"=>323));
		$newsdetail=json_decode($result);
		var_export($newsdetail->$newsid->news_title); 
		 exit();
	 }
	 function newslist()
	 {
		//使用notorm 做的service
	 	//测试获取新闻 列表
	 	$result=$this->getService("NewsService","getNews",false);
		$news=json_decode($result); //这一步是必须的
 		$this->addObject("newslist",$news);
	 
		//使用普通虚拟类 做的service
		$result2=$this->getService("NewsService","getNews2",false);
		$news2=json_decode($result2); //这一步是必须的
		$this->addObject("newslist2",$news2);
		
		 $this->setViewName("news/list");
	 }
	 function newsdetail()
	 {
	 	//新闻详情处理
	 	$this->setViewName("news/detail");
	 }
	 
  } 
?>