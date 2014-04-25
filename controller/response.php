<?php
Class Response{
	static public function write($str,$csspath){
		$tpl="<html>\n"
			."<head>\n"
			."\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n"
			."\t<title>页面出错了</title>\n";
		if ($csspath){
		$tpl=$tpl."\t<link rel=\"stylesheet\" href=\"".$csspath."\" type=\"text/css\" media=\"screen\" charset=\"utf-8\"/>";
		}
		$tpl=$tpl."</head>\n"
			."<body>\n"
			."\t<div class=\"error_msg\">".$str."</div>\n"
			."</body>\n</html>";
		echo $tpl;
		exit();
	}
	
	static public function clearSpecialChar($str){
		
		//$str = htmlentities($str,ENT_QUOTES,"utf-8");//htmlspecialchars($str);
		//$str = preg_replace('/\'/','\\\'', $str);//新浪用的是&acute; (&acute;)，这并不是一个正常的单引号。比较理想的代码是用&#39; (')。
		//return addslashes($str);
		$str = str_replace("'","&#039;",$str);
		return $str;
	}
	
	static public function decodeSpecialChar($str){
		//$str = preg_replace('/&amp;#039;/','\'', $str);
		$str = @preg_replace('/\'/','\\\'',$str);
		$str = @preg_replace('/(&amp;#039|&#039;)/',"'");
		return $str;
	}
	
}