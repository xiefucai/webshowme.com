<?php 
	if (isset($_GET["action"])){
		$e = $_GET["action"];
		if ($e==="exit"){
			session_start();
			session_destroy();
		}
	}	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员登陆</title>
<style type="text/css">
<!--
html{height:100%;}
body,td,th {
	font-size: 13px;
}
a:link,a:visited{color:#FFF;text-decoration:none;}
body{margin:0px;padding:0px;text-align:center;
background:url(../images/bg_admin.jpg) left center repeat-x #2D4F56;}
#form1{width:394px;height:244px;position:absolute; top:50%; left:50%;
       margin-left:-197px; margin-top:-122px; background:url(../images/bg0.jpg) no-repeat;}
#form1 h2{height:33px;line-height:33px;font-size:12px;margin:0;padding:0;text-align:left;text-indent:20px;}      
#form1 .A{margin-top:0px;margin-left:148px; text-align:left;color:#666;}
#form1 .A div {height:40px;}
#form1 .A div input{width:128px;height:20px;padding:0px;margin:0px;
                    vertical-align:middle; line-height:20px;
                    border-top:1px solid #6D6F70;
					border-left:1px solid #C9CBCC;
					border-right:1px solid #C9CBCC;
					border-bottom:1px solid #D3D5D6;
					color:#666;text-indent:5px;
					}
#form1 .A div input.varicode{width:85px;}
#form1 .A div label{display:inline-block; width:50px; text-align:center;}
#form1 .A center{width:250px;margin:0px;}
#form1 .A .B{ display:block; width:100%; height:30px;text-align:left; padding:0px;}
#form1 .A .B input{width:79px; height:22px; border:0px; background:url(../images/buttonBg.jpg) no-repeat; display:inline-block; margin-left:0px; margin-right:10px;}
#copyright{position:fixed;_ position:absolute; bottom:0px;height:65px; line-height:45px; width:100%;left:0px; color:#9C3;}
#errmsg{height:30px;line-height:30px;text-align:left;color:#F00;}
-->
</style>
<script type="text/javascript">
function getParameter(varName)
{
var o={};
	(location.search||"?").slice(1).replace(/&?([^&=]+)=([^&=]*)/g,function(){
		o[arguments[1]] = arguments[2];return"";
	});
	if (window.console){console.log(o);}
	return o[varName];
} 
function login_formcheck() {
	var f = document.form1;
	var a = f.admin;
	var b = f.pasw;
	var c = f.varicode;
	$("errmsg").innerHTML = "";
	if (a.value == "") {
		$("errmsg").innerHTML = "请输入用户名!";
		return false;
	}
	if (b.value == "") {
		$("errmsg").innerHTML = "请输入密码!";
		return false;
	}
	if (c.value == "") {
		$("errmsg").innerHTML = "请输入验证码!";
		return false;
	}
	return true;
	f.method = "post";
	f.action = "../controller/frontControll.php?action=login";
	f.submit();
}
 function $(a){return document.getElementById(a);}
window.onload = function() {
	var e = getParameter("error");
	if (e == 1) {
		$("errmsg").innerHTML = "用户名或密码错误!";
	}
	else if (e == 2) {
		$("errmsg").innerHTML = "验证码错误!";
	}
	else if (e == 3) {
		$("errmsg").innerHTML = "成功退出!";
	}
	else if (e == 0) {
		$("errmsg").innerHTML = "对不起您没有权限!";
	}
	var adminName = getCookie("admin");
	if (adminName != null || adminName != "") {
		$("form1").admin.value = adminName;
	}
	
	$("saveframe").callback = function(e){
		if (e == 1) {
			$("errmsg").innerHTML = "用户名或密码错误!";
		}
		else if (e == 2) {
			$("errmsg").innerHTML = "验证码错误!";
		}
		else if (e == 3) {
			$("errmsg").innerHTML = "成功退出!";
		}
		else if (e == 0) {
			//alert("登录成功!");
			location.href="../webmanage/manage.php";
		}
	}
}

function getCookie(n)
{var r=new RegExp("(\\b)"+n+"=([^;]*)(;|$)");var m=document.cookie.match(r);return(!m?"":m[2]);}
</script>
</head>

<body>
<iframe id="saveframe" name="saveframe" width="1" height="1"></iframe>
<form id="form1" target="saveframe" action="../controller/frontControll.php?action=login" name="form1" method="post"  onsubmit="return login_formcheck();">
<h2>管理员登录</h2>
<div class="A">
  <div id="errmsg"></div>
  <div class="A1"><label>用户名</label><input type="text" value="" name="admin"/></div>
  <div class="A2"> <label>密 &nbsp;码</label><input type="password" value="" name="pasw"/></div>
  <div class="A2"> <label>验证码</label><input type="text" name="varicode" id="varicode" class="varicode"/>
  <img src="include_files/create_code.php" border="0" onclick="this.src='include_files/create_code.php';" valign="middle"/></div>
  <span class="B">&nbsp;&nbsp;&nbsp;
  <input type="submit" value="登陆" />
  <input type="reset" value="重置" />
  </span>
</div>
</form>
<div id="copyright">国梁网站后台管理系统</div>
</body>
</html>
