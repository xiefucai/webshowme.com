<?php
header('Content-Type: text/html; charset=utf-8');
header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', strtotime("+1000")));
require_once 'ini.php';
require_once ROOT_PATH.'/controller/response.php';
require_once ROOT_PATH.'/core/db.php';
$category = include ROOT_PATH.'/core/config_article_category.php';
$mydb = new DB();
if (isset($_GET["id"])){
$article_id = intval($_GET["id"]);
}else{
exit();
}

$article = (array)($mydb->getArticleById($article_id));
if (!$article){
	echo "文章不存在";
	exit();
}
if (!isset($article["article_tags"])){
	$article["article_tags"] = "";
}
if (!isset($article["article_desc"])){
	$article["article_desc"] = "";
}
if (isset($article["article_htmlencode"]) && 1 === intval($article["article_htmlencode"])){
	$article["article_content"] = $article["article_content"];
	$article["article_content_class"] = '';
}else{
	$article["article_title"] = Response::decodeSpecialChar($article["article_title"]);
	$article["article_content"] = htmlspecialchars($article["article_content"]);
	$article["article_content_class"] = ' pre';
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf8">
<title><?php echo $article["article_title"];?> - <?php echo $category[$article["article_category"]];?></title>
<meta name="keywords" content="<?php echo $article["article_tags"];?>"/>
<meta name="description" content="<?php echo $article["article_desc"];?>"/>
<meta name="viewport" content="minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0, width=device-width, user-scalable=no"/>
<meta http-equiv="expires" content=""/>
<link rel="stylesheet" href="css/base.css" type="text/css"/>
<link rel="alternate" type="application/rss+xml" title="rss订阅" href="../rss.xml" /> 
<base target="_blank" />
</head>
<body>
<noscript>您的浏览器不支持javscript</noscript>
<header class="header">
 	<a class="logo">webshowme</a>
 	<a href="./category.php?categoryid=<?php echo $article["article_category"]?>" class="button" target="_self" id="backBtn">返回</a>
</header>
<h1 class="title"><?php echo $article["article_title"];?></h1>
<p class="subtitle"><span>时间：<?php echo date('Y-m-d H:i:s',$article["article_time"]);?></span>	<span class="subtitle_cate">分类：<a href="./category.php?categoryid=<?php echo $article["article_category"]?>" target="_self" class="gray"><?php echo $category[$article["article_category"]];?></a></span></p>
<article class="content<?php echo $article["article_content_class"];?>"><?php echo $article["article_content"];?></article>
<div class="footer"><?php echo $category[$article["article_category"]];?></div>
<footer> &copy; webshowme.com <script type="text/javascript" src="http://tajs.qq.com/stats?sId=9133643" charset="UTF-8"></script></footer>
<script type="text/javascript" src="js/article.js"></script>
</body>
