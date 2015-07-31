<?php
  require_once(dirname(__FILE__)."/class.phpmailer.php");
require_once(dirname(__FILE__)."/class.smtp.php");

class MailUtil
{
    public static function SendMail($to,$authorname,$title,$body)
    {
         if(trim($to)=="") return ;
         
  		date_default_timezone_set("Asia/Shanghai");//设定时区东八区
        $mail = new PHPMailer();
        $mail->CharSet ="utf-8";
        $mail->Encoding = 'base64';
      //  $mail->SMTPSecure = "ssl";
        $mail->IsSMTP(); // send via SMTP
        //$mail->Port=465;
   
        $mail->Host = "smtp.jtthink.com"; // SMTP servers
     
        $mail->SMTPAuth = true; // turn on SMTP authentication
       
        $mail->SMTPDebug  = false;  
        $mail->Username = "webmaster@jtthink.com"; // SMTP username
        
        $mail->Password = "7741877418cC"; // SMTP password
        
         
        $mail->From="webmaster@jtthink.com";
        
     $mail->FromName='程序员在囧途系统邮件';
        
        $mail->AddAddress($to,$authorname);
        $mail->WordWrap = 50; // set word wrap       
         $mail->IsHTML(true); // send as HTML
        
        $mail->Subject = $title;
        $mail->Body=$body;
    $mail->Send();
     
    }
}
?>