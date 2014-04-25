<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0, width=device-width, user-scalable=no"/>
		<title>发送邮件</title>
	<style type="text/css">
		.button,.reset{padding:5px 15px;}
		ul,li{margin:0;padding:0;list-style:none;}
		li{margin-bottom:10px;}
		.center{text-align:center;}
		label{display:inline-block;width:80px;text-align:left;vertical-align:top;line-height:30px;}
		input[type="text"],input[type="email"],textarea{vertical-align:top;padding:5px;width:100%;border:1px solid #ccc;border-radius:3px;}
		input[type="text"]:focus,input[type="email"]:focus,textarea:focus{outline:none;border-color:#7DB6D8;outline:0;-webkit-box-shadow:0 0 10px rgba(123,214,246,.6);}
		input[type="submit"],input[type="button"],input[type="reset"]{
		border:1px solid #7DB6D8;border-radius:3px;background:-webkit-gradient(linear, left top, left bottom, from(#F4F9FC), to(#E0EFFB));color:#2473A2;cursor:pointer;padding-left:15px;padding-right:15px;
		}
		input[type="submit"]:focus,input[type="button"]:focus,input[type="reset"]:focus{
			border:1px solid #f00;color:#f00;}
		}
		input[type="submit"]:active,input[type="button"]:active,input[type="reset"]:active{
			border:1px solid #090;color:#090;
		}
	</style>
	</head>
	<body>
		<?php 
			$p = array();
			$p["subject"] = htmlspecialchars((isset($_POST["subject"])?$_POST["subject"]:""),ENT_NOQUOTES);
			$p["to"] = htmlspecialchars((isset($_POST["to"])?$_POST["to"]:""),ENT_NOQUOTES);
			$p["body"] = htmlspecialchars((isset($_POST["body"])?$_POST["body"]:""),ENT_QUOTES);
		?>
		<form name="email" action="email_post.php" method="post">
		<ul>
			<li><label>收件人：</label><input type="email" name="to" value="<?php echo $p["to"];?>" tabindex="0"/></li>
			<li><label>标题：</label><input type="text" name="subject" value="<?php echo $p["subject"];?>" tabindex="0"/></li>
			<li><label>正文：</label><textarea name="body" rows="12" autofocus="autofocus" tabindex="0"><?php echo $p["body"];?></textarea></li>
			<li class="center"><input type="submit" value="发送" class="button" tabindex="0"/><input type="reset" value="取消" class="reset" tabindex="0"/></li>
		</ul>
		</form>
	</body>
</html>
