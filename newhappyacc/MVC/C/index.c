<?php
 class index extends _Main
 {
 	
	 
	 function getindex()
	 {
	  
	 	//模板加载 在这个函数里
	 	$this->setViewName("index");
		
	/*	$this->setCacheEnabled(60);

		if(!$this->inCache())
		{
			  $this->addObject("prod","我的第一个商品");
		}*/
	 
		 
		$this->addObject("username","我的名字");
		
		//$this->isFileCache=true;//保存到文件中
		 
		 //这里是使用notorm的方式获取数据
		 $depts=$this->dbORM->depts()->select("*");
		 $this->addObject("depts",$depts);
		 
		 //这里使用原始的xml方式获取数据
		 
		 $books=$this->test->getBooks(0,10);
		 
		 $this->addObject("books",$books);
		 
		 
		 
		 
	 }
 }
?>