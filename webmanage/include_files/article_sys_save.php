<?php
	session_start();
	if (!isset($_SESSION['admin'])){
		die("<script>top.location.href='../login.php?error=0';</script>");
	}
	require_once 'ini.php';
	require_once ROOT_PATH.'/controller/response.php';
	require_once ROOT_PATH.'/core/db.php';
	header("Content-type:text/html;charset=utf-8");
	$article = array(); 
	$article["id"] = intval($_GET["id"]);
	$article["title"] = Response::clearSpecialChar($_POST["article_title"]);
	$article["content"] = Response::clearSpecialChar($_POST["article_content"]);
	$article["time"] = time();
	$article["author"] = Response::clearSpecialChar($_POST["article_author"]);
	//echo Response::clearSpecialChar("ºÃ°¡");
	$mydb = new DB();
	$csspath = "../../css/admin.css";
	if ($mydb->updateSysArticleById($article)){
		Response::write("<script>frameElement.callback(0);</script>",$csspath);
	}else{
		Response::write("<script>frameElement.callback(1);</script>",$csspath);
	}
?>