<?php
	session_start();
	if (!isset($_SESSION['admin'])){
		die("<script>top.location.href='../login.php?error=0';</script>");
	}
	require_once 'ini.php';
	require_once ROOT_PATH.'/controller/response.php';
	require_once ROOT_PATH.'/core/db.php';
	$id = intval($_GET["id"]);
	$mydb = new DB();
	$csspath = "../../css/admin.css";
	$article = $mydb->getSysArticleById($id);
	if ($article==false){
		Response::write("数据不存在",$csspath);
	}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
	<title><?php echo $article->article_title;?></title>
	<link rel="stylesheet" href="<?php echo $csspath;?>" type="text/css" media="screen" charset="utf-8"/>
	<script charset="utf-8" src="../../kindeditor/kindeditor-min.js"></script>
</head>
<body scroll="no">
	<iframe id="saveframe" name="saveframe" width="1" height="1"></iframe>
	<form action="article_sys_save.php?id=<?php echo $article->article_id;?>" method="post" target="saveframe" class="postform" id="article_form" name="article_form">
		<ul>
			<li>
				<input type="text" value="<?php echo htmlspecialchars($article->article_title);?>" name="article_title" class="text_title" readonly/>
				<input type="hidden" name="article_author" value=""/>
			</li>
			<li>
				<textarea name="article_content" class="text_content" id="article_content"><?php echo $article->article_content;?></textarea>
			</li>
			<li class="right">
				<input type="reset" value="取消" name="cancel" class="cancel"/>
				<input type="submit" value="保存" name="submit" class="submit"/>
			</li>
		</ul>
	</form>
<script>
KindEditor.ready(function(K) {
var html = K('#article_content').val(),h = (document.body||document.documentElement).clientHeight;
	K('#article_content').height(h-110).val("");
var editor =K.create('#article_content', {
		themeType : 'simple',
		cssPath : '../../css/editor.css',
		uploadJson : 'upload_save.php',
		fileManagerJson : 'upload_save.php',
		allowFileManager : true,
		baseURL: location.href.replace(/([^\/]*\/?){3}$/,""),
		items:[
		        'fullscreen', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'cut', 'copy', 'paste',
		        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
		        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
		        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'source', '/',
		        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
		        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image',
		        'table', 'hr', 'emoticons', 'map', 'code', 'pagebreak',
		        'link', 'unlink'
		],
		afterCreate : function(){
			var doc = this.cmd.range.doc;
			if(!doc.head){
				doc.appendChild(doc.createElement("head"));
			}
			try{
				var base = doc.createElement("base");
					base.href = location.href.replace(/([^\/]*\/?){3}$/,"");
					doc.getElementsByTagName("head")[0].appendChild(base);
			}catch(e){
			}
			this.html(html);
		},
		filterMode : false
	});
	K("#saveframe")[0].callback=function(d){
		if (d==0){
			alert("保存成功");
		}else{
			alert("保存失败");
		}
	};
});
</script>
</body>
</html>