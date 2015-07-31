<?php

 class _Model
 {
 	 var $dbORM=false;
 	 function _Model()
 	 {
 	 	load_lib("db","NotORM");
		$structure = new NotORM_Structure_Convention(
		    $primary = 'id',  //这里告诉notorm 我们的主键都是id 这种英文单词
		    $foreign = '%sid',  //同理，外键都是 外表名+id    这个很重要，否则notorm拼接sql的时候会拼错。
		    $table = '%s',
		    $prefix =''
		);
		$pdo = new PDO(DB_DSN,DB_User,DB_UserPass);
	 	$pdo->query("set names utf8");
		$this->dbORM=new NotORM($pdo,$structure); //初始化
 	 }
 	 function __get($conf)
	{
		//数据层专用方法
		load_lib("VirtualClass", "myclass");
		$mc=new myClass($conf,FOXPHP_VIRTUALCLASS_CONFIGPATH);
		$mc->$conf;
	    return $mc;
	 
	}
 	 
 }

?>