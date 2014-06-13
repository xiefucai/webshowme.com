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
	if (isset($_GET["id"])){
		$id = intval($_GET["id"]);
		$article = (array)($mydb->getArticleById($id));
		if ($article==false){
			Response::write("数据不存在",$csspath);
		}
		if ($article["article_htmlencode"]==1){
			$article["article_content"] = htmlspecialchars($article["article_content"]);
		}
	}else{
		$article = array(
			"article_title"=>"",
			"article_id"=>"",
			"article_author"=>"",
			"article_category"=>intval($_GET["categoryid"])||0,
			"article_content"=>"",
			"article_htmlencode"=>1
		);
	}
	
	//echo $article->article_htmlencode;
//	echo property_exists($article,"article_category");
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
	<title><?php echo $article["article_title"];?></title>
	<link rel="stylesheet" href="<?php echo $csspath;?>" type="text/css" media="screen" charset="utf-8"/>
	<script>window.UEDITOR_HOME_URL = "/ueditor/"</script>
	<script type="text/javascript" charset="utf-8" src="../../../ueditor/editor_config.js"></script>
    <script type="text/javascript" charset="utf-8" src="../../../ueditor/editor_all_min.js"></script>
</head>
<body scroll="no">
	<iframe id="saveframe" name="saveframe" width="1" height="1"></iframe>
	<form action="../../controller/frontControll.php?action=savearticle&id=<?php echo $article["article_id"];?>" method="post" target="saveframe" class="postform" id="article_form" name="article_form">
		<ul>
			<li>
				<input type="text" value="<?php echo htmlspecialchars($article["article_title"]);?>" name="article_title" class="text_title"/>
				<input type="hidden" name="article_author" value="admin"/>
				<input type="hidden" name="article_category" value="<?php echo $article["article_category"];?>"/>
			</li>
			<li>
				<textarea name="article_content" class="text_content" id="article_content"><?php echo $article["article_content"];?></textarea>
			</li>
			<li class="right">
				<span><input type="checkbox" name="article_htmlencode" id="article_htmlencode" value="1" <?php if($article["article_htmlencode"] == 1) {echo "checked";}?>/> <label for="article_htmlencode">html转义</label></span>
				<input type="reset" value="取消" name="cancel" class="cancel"/>
				<input type="submit" value="保存" name="submit" class="submit"/>
			</li>
		</ul>
	</form>
<script>
var ue = UE.getEditor('article_content');
    ue.addListener('ready',function(){
        this.focus()
    });
    
    document.getElementById("saveframe").callback = function(ret,msg){
    	if (ret === 0){
    		alert("保存成功");
    	}else{
    		alert("保存失败");
    	}
    }
</script>
</body>
</html>