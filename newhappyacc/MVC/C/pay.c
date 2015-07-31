<?php
 class pay extends _Main
 {
 	function returnpay()
	{
		$this->setView(null);
		  header("Content-type:text/html;charset=utf-8");
	    load_lib("alipay","alipay.config");
	  	load_lib("alipay","alipay_notify.class");
		 $alipay_config=getAlipayConfig();
		 
		 $alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyReturn();
	 
		if($verify_result) {//验证成功
			$out_trade_no = $_GET['out_trade_no'];
			$trade_no = $_GET['trade_no'];
			//交易状态
			$trade_status = $_GET['trade_status'];
		    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//如果有做过处理，不执行商户的业务程序
		     echo "支付成功"; //这里做一些你的处理
		      
		    }
		    else {
		      echo "trade_status=".$_GET['trade_status'];
		    }
				
			echo "验证成功<br />";
		}
		else {
		    
		    echo "验证失败33";
		}
		exit();
	}
 	function submit()
 	{
 	   load_lib("alipay","alipay.config");
	   load_lib("alipay","alipay_submit.class");
	   
	   	 $alipay_config=getAlipayConfig();
		 $parameter = array(
				"service" => "create_direct_pay_by_user",
				"partner" => trim($alipay_config['partner']), //联盟身份ID
				"payment_type"	=> 1, //本课时使用的是即时 到账服务
				"notify_url"	=> "http://shenyi.com/pay/returnpay/",
				"return_url"	=> "http://shenyi.com/pay/returnpay/",
				"seller_email"	=> "shenyi@jtthink.com", //支付宝账号
				"out_trade_no"	=> "test001020304".rand(1, 1000), //我们数据库 由我们自己生成的一个订单编号，必须要唯一
				"subject"	=> "沈逸的测试订单",//订单名称
				"total_fee"	=> 1,//钱
				"body"	=> "测试订单备注",//订单描述
				"show_url"	=> "http://shenyi.com/index/getindex/",//商品详细地址
				"anti_phishing_key"	=> "",   //防钓鱼时间戳
				"exter_invoke_ip"	=> IP(),//客户端的IP地址
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset'])),
				 "paymethod"=>"bankPay",
				 "defaultbank"=>"ICBCB2C"
				
		);
		
	 
		  header("Content-type:text/html;charset=utf-8");
			$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		echo $html_text;
		exit();
 	}
 }

?>