<?php 
	if(!isset($_GET["action"])){
		exit();
	}
	$action = $_GET["action"];
	require_once 'ini.php';
	require_once ROOT_PATH.'/controller/response.php';
	require_once ROOT_PATH.'/core/db.php';
	header("Content-type:text/html;charset=utf-8");
	$csspath = "../css/";
	if ($action=="saveliuyan"){
		$p = array(); 
		$p["nick"] = Response::clearSpecialChar($_POST["nick"]);
		$p["email"] = Response::clearSpecialChar($_POST["email"]);
		$p["tel"] = Response::clearSpecialChar($_POST["tel"]);
		$p["title"] = Response::clearSpecialChar($_POST["title"]);
		$p["content"] = Response::clearSpecialChar($_POST["content"]);
		$mydb = new DB();
		if ($mydb->saveLiuYan($p)){
			Response::write("<script>frameElement.callback(0);</script>",$csspath);
		}else{
			Response::write("<script>frameElement.callback(1);</script>",$csspath);
		}
		//var_dump($p);
	}elseif($action=="delmessage"){
		$id = $_GET["id"];
		if (!$id){exit();}
		$id =intval($id);
		$mydb = new DB();
		if ($mydb->delGuestBookById($id)){
			Response::write("<script>alert('删除成功');location.replace(document.referrer);</script>",$csspath);
		}else{
			Response::write("<script>alert('删除失败');location.replace(document.referrer);</script>",$csspath);
		}
	}else if($action == "savearticle"){
		$id =$_GET["id"];
		if ($id){$id =intval($id);}
		if (!isset($_POST["article_category"])){exit();}
		$mydb = new DB();
		$p = array(); 
		$p["article_id"] = $id;
		$p["article_title"] = Response::clearSpecialChar($_POST["article_title"]);
		$p["article_author"] = Response::clearSpecialChar($_POST["article_author"]);
		$p["article_category"] = intval($_POST["article_category"]);
		$p["article_content"] = Response::clearSpecialChar($_POST["article_content"]);
		$p["article_htmlencode"] = isset($_POST["article_htmlencode"])?1:0;
		$r = $mydb->updateArticleById($p);
		
		if ($r){
			Response::write("<script>frameElement.callback(0,'".$r."');</script>",$csspath);
		}else{
			Response::write("<script>frameElement.callback(1);</script>",$csspath);
		}
	}else if($action == "delarticle"){
		$id = $_GET["id"];
		if (!$id){exit();}
		if (!isset($_SESSION['admin'])){
			die("<script>top.location.href='/';</script>");
		}
		$id =intval($id);
		$mydb = new DB();
		if ($mydb->delArticleById($id)){
			Response::write("<script>alert('删除成功');location.replace(document.referrer);</script>",$csspath);
		}else{
			Response::write("<script>alert('删除失败');location.replace(document.referrer);</script>",$csspath);
		}
	}else if($action === "setArticlesCategory"){
		if (!isset($_GET["id"]) || !isset($_POST["articles_id"])){
			exit(json_encode(array("ret"=>1,"msg"=>"参数错误")));
		}
		$mydb = new DB();
		$ret = $mydb->setArticlesCategory($_GET["id"],$_POST["articles_id"]);
		if ($ret){
			exit(json_encode(array("ret"=>0,"msg"=>"设置成功")));
		}else{
			exit(json_encode(array("ret"=>2,"msg"=>"设置失败")));
		}
	}else if($action == "login"){
		session_start();
		$p = array();
		$p["admin"] = Response::clearSpecialChar($_POST["admin"]);
		$p["pasw"] = md5($_POST["pasw"]);
		if ($_POST["varicode"] != $_SESSION['code']){
			Response::write("<script>frameElement.callback(2);</script>",$csspath);
		}
		$mydb = new DB();
		$ret = $mydb->checkAdminLogin($p);
		$ret = mysql_fetch_object($ret);
		if ($ret->result == 0){
			Response::write("<script>frameElement.callback(1);</script>",$csspath);
		}else{
			$_SESSION['admin'] = $p["admin"];  
			Response::write("<script>frameElement.callback(0);</script>",$csspath);
		}	
	}else if($action == "saveadmin"){
		$p = array();
		if (isset($_GET["id"]) && $_GET["id"]!=""){
			$p["adminId"]=intval($_GET["id"]);
		}
		$p["adminName"] = Response::clearSpecialChar($_POST["adminName"]);
		$p["adminPasw"] = md5($_POST["adminPasw"]);
		$mydb = new DB();
		$ret = $mydb->saveAdmin($p);
		if ($ret === true){
			Response::write("<script>frameElement.callback(1);</script>",$csspath);
		}else{ 
			Response::write("<script>frameElement.callback(0);</script>",$csspath);
		}
	}
	