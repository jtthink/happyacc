<?php
 class myRequest {
 	var $is_ssl=false;
	var $requestUrl="";
	var $requestSecKey="";
	var $requestParam="";//参数
 	function myRequest($url,$seckey)
	{
		 $this->requestUrl=$url;
		 $this->requestSecKey=$seckey;
	}
	function makeParam($param,$ispost=false)
	{
		
	    $ispost && $this->requestParam="_seckey=".$this->requestSecKey;//初始化请求参数，post必须有一个_seckey,否则可能会失败
		if(!$param) return ;
		
		if(is_string($param))
		{
			trim($this->requestParam)!="" && $this->requestParam.='&';
			$this->requestParam.=$param;
		} 
		if(is_array($param) && count($param)>0)
		{
			foreach($param as $k=>$v)
			{
				trim($this->requestParam)!="" && $this->requestParam.='&';
				$this->requestParam.=$k.'='.urlencode(safeText($v));
			}
		}
		 
	}
 	function makeRequestGet($param=false)
	{
		$this->makeParam($param);
		$url=$this->requestUrl;
		if($this->requestParam!="") $url=$this->requestUrl.'?'.$this->requestParam;
		 
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
		$responseText = curl_exec($curl);
		//var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
		curl_close($curl);
		return $responseText;
	}
	function makeRequestPost($param=false)
	{
		$this->makeParam($param,true);
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->requestUrl);
		curl_setopt($curl, CURLOPT_POST, 1 ); 
		curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
		 curl_setopt($curl,CURLOPT_POSTFIELDS,$this->requestParam);// post传输数据
		$responseText = curl_exec($curl);
		//var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
		curl_close($curl);
		return $responseText;
	}
 }


?>