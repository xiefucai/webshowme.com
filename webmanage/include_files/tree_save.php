<?php
	header("Content-Type:text/html;charset=utf-8");
	function detectUTF8($string)
	{
	        return preg_match('%(?:
	        [\xC2-\xDF][\x80-\xBF]        # non-overlong 2-byte
	        |\xE0[\xA0-\xBF][\x80-\xBF]               # excluding overlongs
	        |[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}      # straight 3-byte
	        |\xED[\x80-\x9F][\x80-\xBF]               # excluding surrogates
	        |\xF0[\x90-\xBF][\x80-\xBF]{2}    # planes 1-3
	        |[\xF1-\xF3][\x80-\xBF]{3}                  # planes 4-15
	        |\xF4[\x80-\x8F][\x80-\xBF]{2}    # plane 16
	        )+%xs', $string);
	}
	
	if (isset($_GET["path"])){
		$path = str_replace("\\\\","/",urldecode($_GET["path"]));
		if (file_exists($path)){
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$str = file_get_contents($path);
			preg_match('/charset=([a-zA-Z0-9\-]+)/',$str,$charsets);
			if (isset($charsets[1])){
				$charset = $charsets[1];
			}elseif(detectUTF8($str)){
				$charset = "utf-8";
			}else{
				$charset = "gb2312";
			}
			if ($charset !== "utf-8"){
				$content = iconv($charset, 'UTF-8//IGNORE', $str);
			}else{
				$content = $str;
			}
			/*
			if (!empty($str) && empty($hstr)){
				$content = iconv('GB2312', 'UTF-8//IGNORE', $str);
			}else{
				$content = $str;
			}*/
		}else{
			echo "文件不存在！";
			exit;
		}
	}else{
		echo "没有指定文件！";
		exit;
	}
?>	
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<title><?php echo $path;?></title>
<style type="text/css" media="screen">
	body{background:#E6F5FC;margin:0;padding:0;}
    #editor { 
        position: absolute;
        top: 30px;
        right: 0;
        bottom: 0;
        left: 0;
    }
    .none{display:none;}
    .menu{position:relative;}
    .filename{margin:0 100px 0 15px;padding:0;font-size:12px;font-weight:normal;line-height:30px;}
    .btn_save{position:absolute;top:0;right:0;display:block;padding:0 10px;line-height:30px;background:#28ABE2;color:#fff;text-decoration:none;font-size:12px;width:80px;text-align:center;}
    #status{right:100px;display:block;position:absolute;top:0;line-height:30px;padding:0 10px;}
</style>
</head>
<body>
<div class="menu">
	<h1 class="filename"><?php echo $path;?></h1>
	<span id="status" class="gray"></span>
	<a href="javascript:;" class="btn_save" id="btn_save">点击保存</a>
</div>
<div id="editor"><?php echo htmlspecialchars($content);?></div>
<iframe id="post_frame" name="post_frame" class="none"></iframe>
<form action="?action=save" method="post" id="post_form" class="none" target="post_frame">
<input type="hidden" name="path" value="<?php echo $path;?>"/>
<textarea name="source"></textarea>
</form>
<script src="http://ajaxorg.github.io/ace/build/src-min-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="http://ajaxorg.github.io/ace/build/src-min-noconflict/ext-static_highlight.js"></script>
<script>
	(function(){
	    var editor = ace.edit("editor"),
	    	ext = "<?php echo $ext;?>",
	    	theme = {"js":"javascript","php":"php"}[ext] || ext,
	    	btn = document.getElementById('btn_save'),
			postForm = document.getElementById('post_form'),
			postFrame = document.getElementById('post_frame');
	    //editor.setTheme("ace/theme/monokai");
	    editor.setTheme("ace/theme/chrome");
	    editor.getSession().setMode("ace/mode/"+theme);
	    postFrame.callback = function(d){
	    	if (d){
	    		frameElement.callback(d);
	    	}
	    	postFrame.errCallback = null;
	    };
	    postFrame.onload = function(){
	    	setTimeout(function(){
	    		if (postFrame.errCallback !== null){
	    			frameElement.callback({"ret":-1,"msg":"网络连接失败！"});
	    		}
	    	},100);
	    }
	    btn.onclick = function(){
	    	postForm.value = editor.getValue();
	    	postFrame.errCallback = 1;
	    	postForm.submit();
	    }
	})();
</script>
</body>
</html>