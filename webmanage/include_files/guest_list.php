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
	$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
	$pageSize = 10;
	$meslist = $mydb->getGuestBookList($page,$pageSize);
	$totalnum = mysql_fetch_object($mydb->getPageOfGuestBook());
	$totalnum = $totalnum->num;
	$pageSize = ceil($totalnum/$pageSize);
	
	if ($meslist==false){
		Response::write("数据不存在",$csspath);
	}	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>留言管理</title>
<link rel="stylesheet" href="<?php echo $csspath;?>" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="../../css/response.css" type="text/css" media="screen" />
</head>
<body>

<ul class="liuyanlist">
	<?php
	$i=0;
	while ($p = mysql_fetch_object($meslist)){
	$i++;
	?>
	<li class="liuyan">
			<h4 class="message_title">
				<strong class="nick"><?php echo $p->nick;?>：</strong><?php echo $p->title;?>
				<span class="del"><a href="../../controller/frontControll.php?action=delmessage&id=<?php echo $p->id;?>">删除</a></span>
			</h4>
			<div class="info">
				<label>电话：</label><?php echo $p->tel;?> 
				<label>邮箱：</label><a href="mailto:<?php echo $p->email;?>"><?php echo $p->email;?></a>
				<label>时间：</label><?php echo date($p->time);?> 
			</div>
			<div class="message_content"><?php echo $p->content;?></div>
	</li>
	<?php 
		}
		if ($i == 0){
			Response::write("还没有人留言",$csspath);
		}
	if ($pageSize>1){
		echo "<div class=\"pagebar\">";
		//echo $page;
		for($i=1;$i<$pageSize;$i++){
			if ($i === intval($page)){
				echo "<span title=\"\">".$i."</span>";
			}else{
				echo "<a href=\"?page=".$i."\">".$i."</a>";
			}
		}
		echo "</div>";
	}
	?>
</ul>
</body>
</html>
	