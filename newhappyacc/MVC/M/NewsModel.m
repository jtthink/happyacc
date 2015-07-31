<?php

 class NewsModel extends _Model
 {
 	 function NewsClass()
	 { 
	 	//新闻所有类别
	 	$newsclass=$this->dbORM->ha_news_class()
	 	->select("*")->where("isremove=0");
		return $newsclass;
		
	 }
	 function NewsDetail($id)
	 {
	 	//获取新闻详细内容
	 	if(intval($id)<=0) return "";
		 
	 	$news=$this->dbORM->ha_news()->select("*")->where("news_isremove=0 and id=".$id);
		 
		return $news;
	 }
 	 function load($page,$pagesize,$classid1,$classid2,$isnotorm=true)
 	 {
 	 	//page 代表页码 pagesize代表页尺寸 classid1 代表分类id1 classid2代表分类2 
 	 	if($isnotorm)
		{
			 $news=$this->dbORM->ha_news()->select("id,news_title,news_abstract")
			->where("news_isremove=0");
			if($classid1 && $classid1>0)
			$news=$news->where("news_classid1=".$classid1);
			if($classid2 && $classid2>0)
			$news=$news->where("news_classid2=".$classid2);
			$news=$news->order("index_level desc,news_pubtime desc")->limit($pagesize,($page-1)*$pagesize);
			
			return $news;
		}
		else
		{
			$where="";
			if($classid1 && $classid1>0)
				 $where.=" and news_classid1=".$classid1;
			if($classid2 && $classid2>0)
				$where.=" and news_classid2=".$classid2;
			return $this->test->getNews($pagesize,($page-1)*$pagesize,$where);
		}
 	   
		
 	 }
 	 
 }

?>