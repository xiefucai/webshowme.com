<?php
header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', strtotime("+1000")));
require_once 'ini.php';
require_once ROOT_PATH.'/controller/response.php';
require_once ROOT_PATH.'/core/db.php';
$category = include ROOT_PATH.'/core/config_article_category.php';
$mydb = new DB();
$article_list = $mydb->getArticlesByCategoryId(0,1,30);
?>
<!DOCTYPE html>
<html manifest="index.appcache">
<head>
<meta charset="utf8">
<title></title>
<meta name="keywords" content="html,标签，属性，语义化"/>
<meta name="description" content="详细介绍了html标签与属性的一些基础知识，让您了解什么是标签语义化"/>
<meta name="viewport" content="minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0, width=device-width, user-scalable=no"/>
<meta http-equiv="expires" content=""/>
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
 	<a href="javascript:;" class="button">分类</a>
 	<ul class="category_list">
 		<?php
	    	foreach($category as $i => $name){
		?>
		<li>
			<a href="category.php?categoryid=<?php echo $i?>" title="<?php echo $name;?>" target="_self"><?php echo $name;?></a>
		</li>
		<?php
			}
		?>
 	</ul>
</header>
<aside>
  <nav>
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
		<span class="category"><a href="?categoryid=<?php echo $p->article_category;?>" class="c_green" target="_self"><?php echo $category[$p->article_category];?></a></span>
		</li>
      <?php 
	}
	
	if ($i==0){
		Response::write("还没有相关文章存在，<a href=\"article.php?categoryid=".$categoryid."\">添加文章</a>",$csspath);
	}
	?>
    </ul>
  </nav>
</aside>
<footer> &copy; webshowme.com <script type="text/javascript" src="http://tajs.qq.com/stats?sId=9133643" charset="UTF-8"></script></footer>
</body>