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
	$categoryid = isset($_GET["categoryid"]) ? intval($_GET["categoryid"]) : 0;
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
<script src="../../js/jquery-1.6.4.min.js"></script>
<script>
var categorys = <?php echo json_encode($category);?>;	
</script>
</head>
<body>
<div class="menubar">
	<span class="fleft">文章分类：
		<?php 
			if ($categoryid > 0){
				echo '<a href="?">'.$category[0].'</a> &gt;&gt; ';
			}
			echo '<a href="javascript:;" class="current_category">'.$category[$categoryid].'</a>';
		?>
	</span>
	<span class="fright"><a href="article.php?categoryid=<?php echo $categoryid;?>">添加文章</a></span>
</div>
<ul class="article_list">
	<?php 
	$i=0;
	while ($p = mysql_fetch_object($article_list)){
		$i++;
	?>
	<li class="article_list_li">
		<span class="checkbox">
			<input type="checkbox" value="<?php echo $p->article_id;?>"/>
		</span>
		<span class="title">
			<a href="../../article.php?id=<?php echo $p->article_id;?>" target="_blank"><?php echo $p->article_title;?></a>
			<label class="icon_news_new"></label>
		</span>
		<?php 
		if ($categoryid <= 0){
		?>
		<span class="category"><a href="?categoryid=<?php echo $p->article_category;?>" class="c_green"><?php echo $category[$p->article_category];?></a></span>
		<?php 
		}
		?>
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
		$p0 = max(min($page - 10,$pageSize-21),1);
		$p1 = min($p0 + 21,$pageSize);
		if($p0>1){
			echo "<a href=\"?categoryid=".$categoryid."&page=1\">1</a>";
			if ($p0 >2 ){
				echo "... ";
			}
		}
		for($i=$p0;$i<=$p1;$i++){
			if ($i == intval($page)){
				echo "<span>".$i."</span>";
			}else{
				echo "<a href=\"?categoryid=".$categoryid."&page=".$i."\">".$i."</a>";
			}
		}
		if($p1<$pageSize){
			if ($p1 < $pageSize-1){
				echo "... ";
			}
			echo "<a href=\"?categoryid=".$categoryid."&page=".$pageSize."\">".$pageSize."</a>";
		}
		echo "</div>";
	}
	?>
</ul>
<div class="category_panel none">
	<a href="javascript:;" class="category_panel_closebtn">&times;</a>
	<div class="arrow_up">
		<div class="arrow_shadow"></div>
		<div class="arrow_inner"></div>
	</div>
	<ul class="category_list">
	<?php
		$checkedIndex = 6;
		foreach($category as $i => $name){
			echo '<li><input type="radio" value="'.$i.'"'.($checkedIndex == intval($i) ?" checked" : "").' name="category"/> <a href="?categoryid='.$i.'">'.$name.'</a></li>';
		}
	?>
	</ul>
	<div class="setter"><a href="javascript:;" class="btn btn1" id="category_setter">设置分类</a></div>
</div>
<script src="../../js/admin_article_list.js"></script>
</body>
</html>
	