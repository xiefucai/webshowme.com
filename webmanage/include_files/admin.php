<?php
	session_start();
	if (!isset($_SESSION['admin'])){
		die("<script>top.location.href='../login.php?error=0';</script>");
	}
	require_once 'ini.php';
	require_once ROOT_PATH.'/controller/response.php';
	require_once ROOT_PATH.'/core/db.php';
	$mydb = new DB();
	$csspath = "../../css/admin.css";
	if (!isset($_GET["for"])){
		exit();
	}
	$f = $_GET["for"];
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>留言管理</title>
<link rel="stylesheet" href="<?php echo $csspath;?>" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="../../css/response.css" type="text/css" media="screen" />
</head>
<body>
<?php
	if ($f === "list"){
	$admin_list = $mydb->getAdminList();
	$i = 0;
?>
<div class="menubar"><span class="fleft">当前系统的所有管理员：</span><span class="fright"><a href="?for=add">添加管理员</a></span></div>
<ul class="article_list">
	<?php
	while ($p = mysql_fetch_object($admin_list)){
		$i++;
	?>
	<li class="article_list_li">
		<span class="title">
			<a href="?for=pasw&admin=<?php echo $p->adminName?>"><?php echo $p->adminName;?></a>
			<label class="icon_news_new"></label>
		</span>
		<span class="del">
			<a href="?for=edit&id=<?php echo $p->adminId;?>" class="edit_icon" title="修改"></a> &nbsp;
			<a href="?for=del&id=<?php echo $p->adminId;?>" class="del_icon"  title="删除" onclick="return beforeDeleteAdmin(this);"></a>
		</span>
		</li>
	<?php }?>
</ul>
<?php
	}elseif($f === "edit" || $f === "add"){
	if (isset($_GET["id"]))
	{
		$id = intval($_GET["id"]);
		$p = mysql_fetch_object($mydb->getAdmin($id));
	}else{
		Class o{};
		$p = new o();
		$p->adminName = $p->adminId = "";
	}
?>
<div class="menubar"><span class="fleft">修改管理员帐号：<?php echo $p->adminName;?></span><span class="fright"><a href="?for=add">添加管理员</a></span></div>
<iframe id="saveframe" name="saveframe" width="1" height="1"></iframe>
<form action="../../controller/frontControll.php?action=saveadmin&id=<?php echo $p->adminId;?>" method="post" target="saveframe" class="postform" id="admin_form" name="admin_form" onsubmit="return checkPasw(this);">
	<ul class="admin">
		<li>&nbsp;</li>
		<li><label>新的帐号：</label><input type="text" value="<?php echo $p->adminName;?>" name="adminName" class="text_input"/></li>
		<li><label>新的密码：</label><input type="password" name="adminPasw" class="text_input"/></li>
		<li><label>确认密码：</label><input type="password" name="adminPasw2" class="text_input"/></li>
		<li align="center">
				<input type="reset" value="取消" name="cancel" class="cancel"/>
				<input type="submit" value="保存" name="submit" class="submit"/>
		</li>
	</ul>	
</form>
<?php
	}elseif($f === "del"){
		if (!isset($_GET["id"])){
			exit();
		}
	}
?>
<script>
function checkPasw(f){
	var p1 = f["adminPasw"]
	   ,p2 = f["adminPasw2"]
	   ,p3 = f["adminName"];
	if (/^\s*$/.test(p3.value)){
		alert("请输入管理员帐号");return false;
	}
	else if(/^\s*$/.test(p1.value)){
		alert("请输入新密码");return false;
	}else if(/^\s*$/.test(p2.value)){
		alert("请输入确认密码");return false;
	}else if (p1.value != p2.value){
		alert("确认密码输入错误");return false;
	}else{
		return true;
	}
}

function beforeDeleteAdmin(o){
	var ul = o.parentNode.parentNode.parentNode;
		if (ul.getElementsByTagName("li").length>1){
			return confirm('是否确定删除？')
		}else{
			alert("您当前只有一个管理员帐号，不能删除！");
			return false;
		}
}

if (document.getElementById("saveframe")){
	document.getElementById("saveframe").callback=function(ret){
		if (ret === 1){
			alert("保存成功");
			this.ownerDocument.location.href = this.ownerDocument.location.href.replace(/\?.*/g,"?for=list");
		}else{
			alert("保存失败");
		}
	}
}	
</script>
</body>
</html>
	