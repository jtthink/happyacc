<?php
 class NewsService extends _Main
 {
 	var $news_cachekey=array(
	 "newsclass"=>"cache_newsclass",
	 "newsdetail"=>"cache_newsdetail"
	); 
	function getNews()
	{
	   $m=load_model("NewsModel");//加载model
		$news=  $m->load(1,10,32,0,true);
		$a=array_map('iterator_to_array', iterator_to_array($news));//吧NotORM的结果变成array
	    echo json_encode($a);//转换成json格式输出,这步是必须的
		exit();
	}
	function getNews2()
	{
		//演示使用 非NotOrm来取数据
		 $m=load_model("NewsModel");//加载model
		$news=  $m->load(1,5,32,0,false);
		echo json_encode($news);
		exit();
	}
	function getNewsDetail()
	{
		$id=intval(GET("newsid"));
	 
		$id<=0 && exit("");
		$newsdetail=get_cache($this->news_cachekey["newsdetail"].$id);
		if(!$newsdetail)
		{
			 $m=load_model("NewsModel");//加载model
			 $newsdetail=$m->NewsDetail($id);	
			$newsdetail= array_map('iterator_to_array', iterator_to_array($newsdetail));
			 set_cache($this->news_cachekey["newsdetail"].$id, $newsdetail, 3600*5);//保存5小时缓存
		}
		exit(json_encode($newsdetail));
		
		
	}
	function getNewsClass()
	{
		//新闻类别，注意。新闻类别是一下子取出放到缓存里的，一共没几条，所以没必要次次访问数据库
		 
		$m=load_model("NewsModel");//加载model
		$newsclass=get_cache($this->news_cachekey["newsclass"]);
		if(!$newsclass)
		{
			$newsclass=array_map('iterator_to_array', iterator_to_array($m->NewsClass()));
			set_cache($this->news_cachekey["newsclass"], $newsclass, 3600*5);//保存5个小时的缓存
		}
		echo json_encode($newsclass);
		exit();
		
	}
 }

?>