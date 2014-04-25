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
	$categoryid = isset($_GET["categoryid"]) ? intval($_GET["categoryid"]) : 1;
	$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
	$pageSize = 20;
	$article_list = $mydb->getArticlesByCategoryId($categoryid,$page,$pageSize);
	
	$totalnum = $mydb->getPageOfArticleList($categoryid);
	if (!$totalnum){
		Response::write("还没有相关文章存在，<a href=\"article.php?categoryid=".$categoryid."\">添加文章</a>",$csspath);
	}
	$totalnum = mysql_fetch_object($totalnum);
	$totalnum = $totalnum->num;
	$pageSize = ceil($totalnum/$pageSize);
	
	if ($article_list==false){
		Response::write("还没有相关文章存在，<a href=\"article.php?categoryid=".$categoryid."\">添加文章</a>",$csspath);
	}
	$category = include ROOT_PATH.'/core/config_article_category.php';
//	var_dump($meslist);
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>留言管理</title>
<link rel="stylesheet" href="<?php echo $csspath;?>" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="../../css/response.css" type="text/css" media="screen" />
</head>
<body>
<div class="menubar"><span class="fleft">您正在查看的是：<?php echo $category[$categoryid];?></span></div>
<ul class="article_list">
	<?php 
	$i=0;
	while ($p = mysql_fetch_object($article_list)){
		$i++;
	?>
	<li class="article_list_li">
		<span class="title">
			<a href="javascript:;"><?php echo $p->article_title;?></a>
			<label class="icon_news_new"></label>
		</span>
		<cite class="time"><?php echo date("Y-m-d",$p->article_time);?></cite>
		<span class="del">
			<a href="article.php?id=<?php echo $p->article_id;?>" class="edit_icon" title="修改"></a> &nbsp;
			<a href="../../controller/frontControll.php?action=delarticle&id=<?php echo $p->article_id;?>" class="del_icon"  title="删除" onclick="return confirm('是否确定删除？')"></a>
		</span>
		</li>
	<?php 
	}
	
	if ($i==0){
		Response::write("还没有相关文章存在，<a href=\"article.php?categoryid=".$categoryid."\">添加文章</a>",$csspath);
	}
	
	if ($pageSize>1){
		echo "<div class=\"pagebar\">";
		//echo $page;
		for($i=1;$i<$pageSize;$i++){
			if ($i === intval($page)){
				echo "<span title=\"\">".$i."</span>";
			}else{
				echo "<a href=\"?categoryid=".$categoryid."&page=".$i."\">".$i."</a>";
			}
		}
		echo "</div>";
	}
	?>
</ul>
</body>
</html>
	