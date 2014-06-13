<?
date_default_timezone_set("Etc/GMT-8"); //设置时区，否则发送后别人看到的是标准时间
include "smtp.class.php";
$smtpserver = "smtp.qq.com";//smtp服务器  你懂的
$port=25; //端口
$smtpuser = "421632997@qq.com";
$smtppwd = "********"; //您登录smtp服务器的密码
$mailtype = "HTML"; //邮件的类型，可选值是 TXT 或 HTML ,TXT 表示是纯文本的邮件,HTML 表示是 html格式的邮件
$sendername = "421632997";//发件人名称
$sender = "421632997@qq.com"; //发件人,一般要与您登录smtp服务器的用户名($smtpuser)相同,否则可能会因为smtp服务器的设置导致发送失败
$smtp =   new smtp($smtpserver,$port,true,$smtpuser,$smtppwd,$sender); 
$smtp->debug = false; //是否开启调试,只在测试程序时使用，正式使用时请将此行注释
$to = $_POST["to"]; //收件人
$subject = $_POST["subject"];
$body = $_POST["body"];
$send=$smtp->sendmail($to,$sender,$sendername,$subject,$body,$mailtype);
if($send==1){
   echo "邮件发送成功";
}else{
   echo "邮件发送失败<br>";
   //echo "原因：".$this->smtp->logs;
}
?>