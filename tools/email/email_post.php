<?
date_default_timezone_set("Etc/GMT-8"); //����ʱ���������ͺ���˿������Ǳ�׼ʱ��
include "smtp.class.php";
$smtpserver = "smtp.qq.com";//smtp������  �㶮��
$port=25; //�˿�
$smtpuser = "421632997@qq.com";
$smtppwd = "********"; //����¼smtp������������
$mailtype = "HTML"; //�ʼ������ͣ���ѡֵ�� TXT �� HTML ,TXT ��ʾ�Ǵ��ı����ʼ�,HTML ��ʾ�� html��ʽ���ʼ�
$sendername = "421632997";//����������
$sender = "421632997@qq.com"; //������,һ��Ҫ������¼smtp���������û���($smtpuser)��ͬ,������ܻ���Ϊsmtp�����������õ��·���ʧ��
$smtp =   new smtp($smtpserver,$port,true,$smtpuser,$smtppwd,$sender); 
$smtp->debug = false; //�Ƿ�������,ֻ�ڲ��Գ���ʱʹ�ã���ʽʹ��ʱ�뽫����ע��
$to = $_POST["to"]; //�ռ���
$subject = $_POST["subject"];
$body = $_POST["body"];
$send=$smtp->sendmail($to,$sender,$sendername,$subject,$body,$mailtype);
if($send==1){
   echo "�ʼ����ͳɹ�";
}else{
   echo "�ʼ�����ʧ��<br>";
   //echo "ԭ��".$this->smtp->logs;
}
?>