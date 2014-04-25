<?php
session_start();
if (!isset($_SESSION['admin'])){
	die("<script>location.href='login.php?error=0';</script>");
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站后台管理</title>
<style type="text/css">
<!--
html{width:100%; height:100%;}
* { font-size: 13px; * font-family: 微软雅黑, Verdana, 宋体, 新细明体, Arial, sans-serif;
}
body { margin: 0px 0px; text-align: center; display: block; overflow: hidden; width: 100%; height: 100%;min-width:786px;}
a.blue:link, a.blue:visited { color: #00c; text-decoration: none; margin: 0px 5px; }
a.blue:hover, a.blue:active { color: #000; text-decoration: none; }
a.white:link, a.white:visited, a.white:hover, a.white:active { color: #FFFFFF; text-decoration: none; }
.H {text-align: left; font-size: 13px; font-weight: 100; margin:0 5px;}
h1.H { height: 24px; line-height: 24px; border-bottom: 1px solid #C9D7F1; color: #555555; }
.fleft { float: left; margin-left: 8px; }
.fright { float: right; margin-right: 8px; }
h2.H { height: 65px; line-height: 65px;font-size:32px;text-indent:25px;color:#009CFF;font-family:"Microsoft Yahei";text-shadow:0 0 1px #009CFF;}
h3.H { height: 560px; }
h4.H {position:fixed; _position: absolute; height: 30px; line-height: 30px; left:0; bottom:0; width:100%; text-align:center;}
#statusBar{font-family:Arial;background:#E1E7F2;white-space:pre;margin-right:10px;}
#header { height: 35px; line-height: 25px; background: #67A7E3; position: relative;border-radius:5px 5px 0 0;}
#bodyLeft { width: 198px; float: left; background: #FFF; overflow-y:auto; overflow-x:hidden;border:1px solid #C8C8C8;border-width:1px auto;}
#bodyCenter { width: 4px; float: left; background: #E1E7F2;padding:1px 0;font-size:1px;_ margin-right:-4px;}
#bodyRight { width: auto; background: #FFF; height:560px;margin-left:204px;border:1px solid #C8C8C8;_ margin-left:0;}
#bodyLeft, #bodyRight, #bodyCenter { height: 100%; }
#bodyRight0 { width:100%; width:inherit; height:760px;}
#setInfoUl { position: absolute; top: 22px; left: -8px; margin: 0px; padding: 0px; list-style: none; border: 1px solid #E1E7F2; width: 120px; visibility: hidden; z-index:9999; background:#FFF; }
#setInfoUl li { height: 24px; line-height: 24px; text-align: center; text-align:left; text-indent:5px; }

.accordion{border:1px solid #c8c8c8;border-top:0px;border-bottom:0px;}
.accordion h3{height: 29px; line-height: 29px; text-align:left;text-indent:20px;margin:-1px 0 0;padding:0;font-size:12px;font-weight:bold;cursor:pointer;color:#666;border:1px solid #C8C8C8;border-width:1px 0;
background:#FEFEFD;
background: -o-linear-gradient(top,#FEFEFD,#F0F0F1);
background: -moz-linear-gradient(top,#FEFEFD,#F0F0F1);
background: -webkit-gradient(linear, left top, left bottom, from(#FEFEFD), to(#F0F0F1));
filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#FEFEFD', endColorstr='#F0F0F1');
}
.accordion .panel{border-bottom:0;margin:0;padding:0;}
.accordion .panel p{margin:0;padding:0;}
.accordion .panel p a:link,.accordion .panel p a:visited{color:#666;text-decoration:underline;display:block;text-decoration:none;height:30px;line-height:30px;text-indent:30px;}
.accordion .panel p a:hover,.accordion .panel p a:active{text-decoration:none;background:#E1E7F2;}
-->
</style>
</head>
<body scroll="no">
<h1 class="H"><span class="fleft">
<a href="../index.php" class="blue" target="_blank">首页</a>
<a href="include_files/tree.php" target="_blank" class="blue">代码管理</a>
<a href="../ServiceExplain.php" target="_blank" class="blue">客户服务</a>
<a href="../NewsCompany.php" target="_blank" class="blue">新闻中心</a>
<a href="../JobCommunity.php" target="_blank" class="blue">国梁人才</a>
<a href="../TojoinRange.php" target="_blank" class="blue">招商加盟</a>
<a href="../About1.php" target="_blank" class="blue">关于国梁</a>
</span>
<span class="fright">
<span>欢迎你，<?php echo $_SESSION['admin'];?></span>
<a href="manage_index.html" target="docsrc" class="blue">管理首页</a> 
<a href="login.php?action=exit" class="blue">退出</a></span></h1>
<h2 class="H">网站后台管理</h2>
<div class="H" id="menutitle">
  <div id="header"><span class="fleft"></span> <span class="fright"></span> </div>
<div class="accordion" id="bodyLeft">
	<h3>管理设置</h3>
	<div class="panel">
		<p><a href="include_files/admin.php?for=list" target="docsrc">管理员帐号</a></p>
		<p><a href="include_files/admin.php?for=add" target="docsrc">添加管理员</a></p>
	</div>
	<h3>文章系统</h3>
	<div class="panel">
		<p><a href="include_files/article_category.php" target="docsrc">分类管理</a></p>
		<p><a href="include_files/article_list.php" target="docsrc">文章管理</a></p>
	</div>
	
	<h3>新浪微博</h3>
	<div class="panel">
		<p><a href="../../sina/weibo.php?action=get_app_config_list" target="docsrc">可授权列表</a></p>
	</div>
	
	<h3>客户服务</h3>
	<div class="panel">
		<p><a href="include_files/article_sys.php?id=7" target="docsrc">客户服务介绍</a></p>
		<p><a href="include_files/guest_list.php" target="docsrc">客户留言</a></p>
		<p><a href="include_files/article_list.php?categoryid=1" target="docsrc">物流常识</a></p>
		<p><a href="include_files/article_sys.php?id=8" target="docsrc">客户服务专线</a></p>		
	</div>
	
	<h3>新闻中心</h3>
	<div class="panel">
		<p><a href="include_files/article_list.php?categoryid=2" target="docsrc">公司新闻</a></p>
		<p><a href="include_files/article_list.php?categoryid=3" target="docsrc">行业新闻</a></p>
		<p><a href="include_files/article_list.php?categoryid=4" target="docsrc">市场活动</a></p>
		<p><a href="include_files/article_list.php?categoryid=5" target="docsrc">业务公告</a></p>
		
	</div>
	
	<h3>人才投资</h3>
	<div class="panel">
		<p><a href="include_files/article_sys.php?id=9" target="docsrc">社会招聘</a></p>
		<p><a href="include_files/article_sys.php?id=10" target="docsrc">校园招聘</a></p>
		<p><a href="include_files/article_sys.php?id=11" target="docsrc">培训发展</a></p>
		<p><a href="include_files/article_sys.php?id=12" target="docsrc">绩效管理</a></p>
	</div>
    
	<h3>招商加盟</h3>
	<div class="panel">
		<p><a href="include_files/article_sys.php?id=13" target="docsrc">加盟范围</a></p>
		<p><a href="include_files/article_sys.php?id=14" target="docsrc">加盟政策</a></p>
		<p><a href="include_files/article_sys.php?id=15" target="docsrc">加盟专线</a></p>
	</div>
    
    <h3>其它内容</h3>
	<div class="panel">
		<p><a href="include_files/article_sys.php?id=16" target="docsrc">网点查询</a></p>
		<p><a href="include_files/article_sys.php?id=17" target="docsrc">价格查询</a></p>
		<?php /*<p><a href="include_files/members.php" target="docsrc">会员服务</a></p> */?>
	</div>
</div>


  <div id="bodyCenter"></div>
  <div id="bodyRight">
      <iframe height="100%" frameborder="0" id="docsrc" name="docsrc" src="manage_index.html" width="100%" marginwidth="0" marginheight="0"></iframe>
  </div>
</div>
<h4 class="H">
  <div id="statusBar">http://t.qq.com/laozi12345</div>
</h4>
<script>
function getE(a){document.getElementById(a);}
function page(p){document.getElementById("docsrc").src = p;}

function closeStatusBar(){
    if (getE('statusBar').style.visibility == 'hidden') {
        getE('statusBar').style.visibility = 'visible';
    }
    else {
        getE('statusBar').style.visibility = 'hidden';
    }
    getE("setInfoUl").style.visibility = 'hidden';
}

function windowResize(){
    var h = document.documentElement.clientHeight || document.body.clientHeight;
    var w = document.documentElement.clientWidth || document.body.clientWidth;
    var winw=parseInt((parseInt(w)*0.99-207));
    document.getElementById("bodyLeft").style.height    =
    document.getElementById("bodyCenter").style.height  =
    document.getElementById("bodyRight").style.height   = 
    (parseInt(h) - 157) + "px";
	document.getElementById("docsrc").style.width=winw+"px";		
}    
window.onload =window.onresize= windowResize;
window.onmousewheel=window.onscroll=function(event){event.preventDefault();return false;}

</script>
<script src="../js/jquery-1.6.4.min.js"></script>
<script>
$(function(){
	$(".accordion").find("h3").click(function(){
		$(".accordion").find(".panel").slideUp("fast");
		$(this).next(".panel").slideDown("fast");
	});
	$(".accordion").find(".panel").hide().first().show();
});
</script> 
</body>
</html>
