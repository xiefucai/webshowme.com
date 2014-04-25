<?php
header('Content-Type: text/html; charset=utf-8');
header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', strtotime("+1000")));
require_once 'ini.php';
require_once ROOT_PATH.'/controller/response.php';
require_once ROOT_PATH.'/core/db.php';
$csspath = "css/base.css";
$category = include ROOT_PATH.'/core/config_article_category.php';
$mydb = new DB();
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
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf8">
<title><?php echo $category[$categoryid];?></title>
<meta name="keywords" content="html,标签，属性，语义化"/>
<meta name="description" content="详细介绍了html标签与属性的一些基础知识，让您了解什么是标签语义化"/>
<meta name="viewport" content="minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0, width=device-width, user-scalable=no"/>
<link rel="stylesheet" href="css/base.css" type="text/css"/>
<link rel="alternate" type="application/rss+xml" title="rss订阅" href="../rss.xml" />
<base target="_blank" />
<script type="text/javascript">
<!--[[   ]]>
</script>
<noscript>您的浏览器不支持javscript</noscript>
</head>

<body>
<header class="header">
 	<a class="logo">webshowme</a>
 	<a href="./" class="button" target="_self">返回</a>
</header>
<aside>
    <ul class="list">
	<?php 
	$i=0;
	while ($p = mysql_fetch_object($article_list)){
		$i++;
	?>
	<li class="article_list_li">
		<span class="title">
			<a href="article.php?id=<?php echo $p->article_id;?>" target="_self"><?php echo $p->article_title;?></a>
			<label class="icon_news_new"></label>
		</span>
		<?php 
		if ($categoryid <= 0){
		?>
		<span class="category"><a href="?categoryid=<?php echo $p->article_category;?>" class="c_green" target="_self"><?php echo $category[$p->article_category];?></a></span>
		<?php 
		}
		?>
		<cite class="time"><?php echo date("Y-m-d",$p->article_time);?></cite>
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
			echo "<a href=\"?categoryid=".$categoryid."&page=1\" target=\"_self\">1</a>";
			if ($p0 >2 ){
				echo "... ";
			}
		}
		for($i=$p0;$i<=$p1;$i++){
			if ($i == intval($page)){
				echo "<span>".$i."</span>";
			}else{
				echo "<a href=\"?categoryid=".$categoryid."&page=".$i."\" target=\"_self\">".$i."</a>";
			}
		}
		if($p1<$pageSize){
			if ($p1 < $pageSize-1){
				echo "... ";
			}
			echo "<a href=\"?categoryid=".$categoryid."&page=".$pageSize."\" target=\"_self\">".$pageSize."</a>";
		}
		echo "</div>";
	}
	?>
	</ul>
</aside>
<footer> &copy; webshowme.com <script type="text/javascript" src="http://tajs.qq.com/stats?sId=9133643" charset="UTF-8"></script></footer>
</body>
