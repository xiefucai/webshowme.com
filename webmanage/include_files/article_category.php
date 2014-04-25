<?php
	require_once 'ini.php';
	require_once ROOT_PATH.'/core/db.php';
	$category = include ROOT_PATH.'/core/config_article_category.php';
	$csspath = "../../css/admin.css";
	$arr = array();
	$mydb = new DB();
	foreach($category as $key=>$item){
		$num = $mydb->getPageOfArticleList($key);
		if ($num){
			$num = mysql_fetch_object($num)->num;
		}else{
			$num = 0;
		}
		$arr[] = array("category_id"=>$key,"category_name"=>$item,"category_num"=>$num);
	}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>文章分类管理</title>
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
	</span>
	<span class="fright"><a href="">添加分类</a></span>
</div>
<ul class="article_list">
	<?php 
		foreach($arr as $p){
	?>
	<li class="article_list_li">
		<span class="checkbox">
			<input type="checkbox" value="<?php echo $p["category_id"];?>"/>
		</span>
		<span class="title">
			<a href="article_list.php?categoryid=<?php echo $p["category_id"]; ?>"><?php echo $p["category_name"]; ?></a>
			<label class="icon_news_new"><?php echo $p["category_num"]; ?></label>
		</span>
		<cite class="time"></cite>
		<span class="del">
			<a href="article.php?id=<?php echo $p["category_id"]; ?>" class="edit_icon" title="修改"></a> &nbsp;
			<a href="../../controller/frontControll.php?action=delarticle&id=<?php echo $p["category_id"]; ?>" class="del_icon"  title="删除" onclick="return confirm('是否确定删除？')"></a>
		</span>
		</li>
	<?php 
	}
	?>
</ul>
</body>
</html>
	