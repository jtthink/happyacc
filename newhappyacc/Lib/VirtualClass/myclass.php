<?php
require_once(dirname(__FILE__)."/../DataBase/database.php");
class myClass
{
    //虚拟类处理
    var $_confContent;
    var $_classSet=array();
    var $_current=false; //当前虚拟对象
    var $isDebug=false;
    var $isUTF8=false;
    function __construct($conf,$root="",$isutf8=false)
    {
        $this->_confContent=file_get_contents($root.$conf.".xml");
          $this->isUTF8=$isutf8;//如果为true则不转码
        $this->loadConf(); //解析配置文件
    }
    
    private function loadConf()
    {
        $conf=(array)simplexml_load_string($this->_confContent); //加载配置文件内容进行解析
       
        if(!$conf || count($conf["configs"])==0 || count($conf["configs"]->modules)==0) return; 
        //配置文件 必须要有 configs节点 以及configs节点下必须要有modules节点
     
        foreach($conf["configs"]->modules->module as $module)  //遍历modules 下1个或n个 module 子节点
        {
            $tmp=array();
            $tmp["name"]=strval($module->name);
            $tmp["sql"]=$module->sql;
            $tmp["className"]=strval($module->className);
            $tmp["description"]=strval($module->description);
            $tmp["resultType"]=strval($module->resultType);
                   if(isset($module->oracle) && $module->oracle && $module->oracle=="true") //是否是oracle
                  $tmp["oracle"]=true;
                  else
                  $tmp["oracle"]=false;
           if(isset($module->paramModel) && $module->paramModel!="")
		   {
		   	  $tmp["paramModel"]=trim($module->paramModel); //参数是模块
		   }
		   else
		    	$tmp["paramModel"]="";
		   
		   if(isset($module->autoModel) && strval($module->autoModel)=="false")
		   {
		   	  $tmp["autoModel"]=false; //如果 为true 如果结果为一条 则会自动转换为独立Model，否则就是列表 ,默认是true
		   }
		   else
		    	$tmp["autoModel"]=true;
           
            if(isset($this->_classSet[$tmp["className"]]))
            {
                $temp_set=$this->_classSet[$tmp["className"]];
                $temp_set[]=$tmp;
                $this->_classSet[$tmp["className"]]=$temp_set;
                
            }
            else
            {
                $this->_classSet[$tmp["className"]]=array($tmp);
                 
            }
        }
    }
    function __setClass($gname)
    {
        if(array_key_exists($gname,$this->_classSet))
        {
            
            $this->_current=$this->_classSet[$gname]; //设置当前虚拟类对象
        }
    }
    function __get($gname)
    {

   
        if(array_key_exists($gname,$this->_classSet))
        {    
            
            $this->_current=$this->_classSet[$gname]; //设置当前虚拟类对象
        }
    } 
    function makeSql($sql,$parms,$paramModel="") //替换sql语句的参数 
    {
        if(!$parms || count($parms)==0) return $sql; //没参数知直接返回原$sql
        
        if($paramModel=="") //普通参数替换
		{
			 $pindex=0;
	        foreach($parms as $p)
	        {
	            //str_replace  是PHP中的替换函数
	            $sql=str_replace("#{".$pindex."}",$p,$sql);
	            $pindex++;
	        }
		}
		else
		{
		  //参数必须是个对象 且只能有一个
		  if(count($parms)!=1) return $sql;
		  $md=$parms[0];
		  $class_vars = get_class_vars(get_class($md)); 
		  foreach($class_vars as $v_k=>$v_v)
		  {
		  	 $sql=str_replace("#{".$v_k."}",$md->$v_k,$sql);
		  }
		  	
		}
    
        return $sql;
    }
    function saveSqlLog($sql)
    {
        if($this->isDebug)
        file_put_contents("sql_log.txt",date("Y-m-d H:i:s").PHP_EOL.$sql.PHP_EOL.PHP_EOL,FILE_APPEND);
    }
	function genModelResult($ret,$resultType,$autoModel=true)
	{
	
		if(!$ret) return false;
	 
		load_model($resultType);
		 
 
			foreach($ret as $r)
			{
				$md=new $resultType();
				foreach($r as $key=>$value)
				{
					$md->$key=$value;
				}
				$returnArray[]=$md;
			}
			if(count($returnArray)==1 && $autoModel)
			 return $returnArray[0];
			return $returnArray;
		 
		 
	}
    function __call($methodname,$params)
    {
    	  
      
        if(!$this->_current) return;
	
        foreach($this->_current as $c)
        {
             
            if($methodname==$c["name"])
            {
                $sql=$c["sql"];//取出对应的sql
                $sql=str_replace(PHP_EOL,"",$sql);
                
                
                $sqlArray=explode(";",$sql); //edit by shenyi 2014-11-29
                $this->saveSqlLog($sql);
               //echo $sql;
                $myDB=new myDataBase();
                 $myDB->isOrac=$c["oracle"];
                 $myDB->isUTF8=$this->isUTF8; 
                  
                 if(count($sqlArray)==1)
                 {
                 
                    $sql=$this->makeSql(strval($sql),$params,$c["paramModel"]);//替换参数
 					  // echo $sql;
                    if($c["resultType"]=="none")
                    $myDB->execForNothing($sql);//什么都不返回
                    else if($c["resultType"]=="array")
                   		 return $myDB->execForArray($sql); //执行sql
                    else if($c["resultType"]=="int" || $c["resultType"]=="string")
                    	 return $myDB->execForOne($sql); //执行sql
					else//代表返回的是一个model
					 	 return $this->genModelResult($myDB->execForArray($sql),$c["resultType"],$c["autoModel"]);
							
					 
                 }
                 else
                 {
                
              		 $sqlLog="";
                    $sqllist=array();
                    foreach($sqlArray as $str_sql)
                    {
                        $tmp=$this->makeSql(strval($str_sql),$params,$c["paramModel"]);
                         $sqllist[]=$tmp;//替换参数
                         $sqlLog.=$tmp.PHP_EOL;
                    }
                     
                        $this->saveSqlLog($sqlLog);
                    //var_export($sqllist);
                     $ret=$myDB->execForTrac($sqllist,$c["resultType"]);
					 if(!in_array($c["resultType"], array("int","string","array","none")))
					  	return $this->genModelResult($ret,$c["resultType"],$c["autoModel"]);
					  return $ret;
                 }
                
            }
        }
    }
}

?>