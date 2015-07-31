<?php
require("adodb.inc.php");
 class myDataBase 
 {
    //数据库处理类
    
    public $_dbAddr="123.57.64.4"; //数据库服务器IP
    public $_dbName="jtthink"; //数据库名
    public $_dbUser="root"; //用户名
    public $_dbPwd="shenyi.jtthink.com";//密码
     
 
    public $_db=false;
    public $isUTF8=false;
    public $isOrac=false;
    public $isOnTrac=false;//代表是否正在执行事务
    
    function myDataBase() // __construct
    {
        //写一些数据库  connect 过程 
    }
    function __destruct() //析构函数
    {
        
         if($this->_db && $this->_db->IsConnected())
         {
          
            $this->_db->disconnect();
            unset($this->_db);
         }
            
    }
    function initConnect()
    {
        //初始化 数据库链接
        if($this->isOnTrac) //如果在事务中执行 不需也不能初始化 数据库链接  add by shenyi 2014-12-26
        {
           if($this->_db && $this->_db->IsConnected())
             return;  
        }
        
        
             $this->_db=NewADOConnection("mysqli");
            $this->_db->connect(DB_HOST,DB_User,DB_UserPass,DB_Name);
            $this->_db->Query("set names utf8"); //客户端编码
          
        
        $this->_db->SetFetchMode(ADODB_FETCH_ASSOC);  
         
    }
     public   function ConvertDataCharset($data)
    {
      
      
         return $data;
        
       if(!$this->isOrac) 
       {
        return $data;
       }
         
        if(is_array($data))
        {   
            $aa=var_export($data,true);
            
             $gethtml=iconv($this->DBCharset_Orac,"utf-8",$aa);
             return  eval('return '.$gethtml.';');
             
        }
        else if(is_object($data))
         return $data;
        else
        {
            return iconv($this->DBCharset_Orac,"utf-8",$data);//非数组数据直接性转换
        }
    }
    public   function ConvertSqlCharset($sql)
    {
        return $sql;
         
        if(!$this->isOrac)   return $sql;
        
        if(!$sql) return $sql;
         return iconv("utf-8",$this->DBCharset_Orac,$sql); //进入的编码肯定是utf-8 
    }
    function execForNothing($sql)// 执行一个sql语句，不返回任何值
    {
          $this->initConnect();
          $sql=$this->ConvertSqlCharset($sql);
         $this->_db->Execute($sql);
    }
    function execForArray($sql)
    {
        //执行一个sql语句 ，返回类型是数组
        $this->initConnect();
        $sql=$this->ConvertSqlCharset($sql);
        $result=$this->_db->Execute($sql);
      
         
        if($result)
        {
            $returnArray=array();
            while(!$result->EOF)
            {
                $returnArray[]=$result->fields;
                $result->MoveNext();
            }
            return $this->ConvertDataCharset($returnArray);
        }
        else
            return  false;
          
        
    }
    function execForOne($sql)
    {
      //执行一个sql语句 ，返回 单列字符串
       $this->initConnect();
         $sql=$this->ConvertSqlCharset($sql);
       $result=$this->_db->GetOne($sql); //adodb的函数，来获取单个值
      return $this->ConvertDataCharset($result);
    }
    function execForTrac($sqllist,$resulttype) //用事务 来执行
    {
        $this->isOnTrac=true;
        //$sqllist 参数 是sql数组
        $type=array("none","string","array","int"); //返回类型
        if(!in_array($resulttype,$type)) return false;
        if(count($sqllist)==0) return false;
        $this->initConnect();
        $this->_db->BeginTrans(); //开启事务
        $sqlindex=0;
        $ret=false;
        
        
       
        foreach($sqllist as $sql)
        {
              $sql=$this->ConvertSqlCharset($sql);
          
            if($sqlindex==(count($sqllist)-1)) //最后一个语句 需要根据返回类型来做不同的处理
            {
                 if($resulttype=="none")
                 {
                      $this->_db->Execute($sql);
                 }
                  else if($resulttype=="array")
                  {
                    $ret=$this->ConvertDataCharset($this->execForArray($sql));
                  }
                  else if($resulttype=="int" || $resulttype=="string")
                  {
                 
                    $ret=$this->ConvertDataCharset($this->execForOne($sql));
                  }
					else
					{
						 $ret=$this->ConvertDataCharset($this->execForArray($sql));
					}
                   
            }
            else
            $this->_db->Execute($sql);
            $sqlindex++;
        }
        $this->_db->CommitTrans();
           
          return $ret;
    }
    
 }
 


?>