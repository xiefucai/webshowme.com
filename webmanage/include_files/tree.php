<?php
header("Content-Type:text/html;charset=GB2312");
	/*
function getPath($p1,$p2=__FILE__){
//	echo $p1."\t".$p2."\n";
	$ps = explode('/',$p1);
	if (is_file($p2)){
		$p2 = dirname($p2);
	}
	if ($ps[0] === "" && $p1=== "/"){
		return $_SERVER['DOCUMENT_ROOT'];
	}else if($ps[0] === ".."){
		if (isset($ps[1])){
			unset($ps[0]);
			//print_r($ps);
			return getPath(implode("/",$ps),dirname($p2));
		}
	}else if($ps[0] === "."){
		return $p2;
	}else if(preg_match('/^[^\/]+$/',$ps[0])){
		return $p2;
	}else{
		return $p2;
	}
}
class RecursiveFileFilterIterator extends FilterIterator {
    // 满足条件的扩展名
    protected $ext = array('php','html');
    //提供 $path 并生成对应的目录迭代器
    public function __construct($path) {
        parent::__construct(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)));
    }
    //检查文件扩展名是否满足条件
    public function accept() {
        $item = $this->getInnerIterator();
        //if ($item->isFile() && in_array(pathinfo($item->getFilename(), PATHINFO_EXTENSION), $this->ext)) {
        if ($item->isFile()) {
            return TRUE;
        }
    }
}

// 实例化
if (isset($_GET["path"])){
	$path = getPath($_GET["path"]);
}else{
	$path = getPath("../../");
}
//print_r($_SERVER);
echo '<dt>'.$path.'</dt>';
foreach (new RecursiveFileFilterIterator($path) as $item) {
	$f = str_replace('\\','/',$item . PHP_EOL);
    echo '<dd><a href="'.($f).'">'.str_replace($path."/",'',$f).'</a></dd>';
}*/

function tree($directory){
	$mydir=dir($directory);
	$str = '';
	while($file=$mydir->read()){
		$str .= '<dd>';
		//$file = iconv('GB2312', 'UTF-8', $file);
		if (is_file($directory.'/'.$file)){
			$str .= '<a href="'.($directory.'/'.$file).'" onclick="editFile(this.getAttribute(\'href\',2));return false;" class="file file_'.pathinfo($file, PATHINFO_EXTENSION).'">'.$file.'</a>';
		}else if($file === "."){
			//	$str .= '<a href="?path='.dirname($directory.'/'.$file).'" class="up">[上级目录]</a>';
		}else if($file === ".."){
			$str .= '<a href="?path='.dirname(dirname($directory.'/'.$file)).'" class="up">[上级目录]</a>';
		}else if(is_dir($directory.'/'.$file) && $file !== '.' && $file !== '..'){
			$str .= '<a href="?path='.($directory.'/'.$file).'" class="dir">'.$file.'</a>';
		}
		$str .='</dd>';
	}
	return $str;
}

if (isset($_GET["path"])){
	$path = $_GET["path"];
}else{
	$path = $_SERVER['DOCUMENT_ROOT'];
}
$path = str_replace("\\\\","/",$path);
?>
<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<head>
<style>
html,body{display:block;height:100%;overflow:hidden;margin:0;padding:0;}
dl{margin:0;padding:0;position:absolute;width:200px;left:0;height:100%;overflow-x:hidden;overflow-y:auto;}
dt,dd{margin:0;padding:2px 10px;}
dt{height:24px;line-height:24px;}
.none{display:none;}
a.file,a.dir,a.up{padding-left:24px;}
a.icon {
    padding-left: 1.5em;
    text-decoration: none;
  }

  a.icon:hover {
    text-decoration: underline;
  }

  a.file {
    background : url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAIAAACQkWg2AAAABnRSTlMAAAAAAABupgeRAAABHUlEQVR42o2RMW7DIBiF3498iHRJD5JKHurL+CRVBp+i2T16tTynF2gO0KSb5ZrBBl4HHDBuK/WXACH4eO9/CAAAbdvijzLGNE1TVZXfZuHg6XCAQESAZXbOKaXO57eiKG6ft9PrKQIkCQqFoIiQFBGlFIB5nvM8t9aOX2Nd18oDzjnPgCDpn/BH4zh2XZdlWVmWiUK4IgCBoFMUz9eP6zRN75cLgEQhcmTQIbl72O0f9865qLAAsURAAgKBJKEtgLXWvyjLuFsThCSstb8rBCaAQhDYWgIZ7myM+TUBjDHrHlZcbMYYk34cN0YSLcgS+wL0fe9TXDMbY33fR2AYBvyQ8L0Gk8MwREBrTfKe4TpTzwhArXWi8HI84h/1DfwI5mhxJamFAAAAAElFTkSuQmCC ") left top no-repeat;
  }

  a.dir {
    background : url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAd5JREFUeNqMU79rFUEQ/vbuodFEEkzAImBpkUabFP4ldpaJhZXYm/RiZWsv/hkWFglBUyTIgyAIIfgIRjHv3r39MePM7N3LcbxAFvZ2b2bn22/mm3XMjF+HL3YW7q28YSIw8mBKoBihhhgCsoORot9d3/ywg3YowMXwNde/PzGnk2vn6PitrT+/PGeNaecg4+qNY3D43vy16A5wDDd4Aqg/ngmrjl/GoN0U5V1QquHQG3q+TPDVhVwyBffcmQGJmSVfyZk7R3SngI4JKfwDJ2+05zIg8gbiereTZRHhJ5KCMOwDFLjhoBTn2g0ghagfKeIYJDPFyibJVBtTREwq60SpYvh5++PpwatHsxSm9QRLSQpEVSd7/TYJUb49TX7gztpjjEffnoVw66+Ytovs14Yp7HaKmUXeX9rKUoMoLNW3srqI5fWn8JejrVkK0QcrkFLOgS39yoKUQe292WJ1guUHG8K2o8K00oO1BTvXoW4yasclUTgZYJY9aFNfAThX5CZRmczAV52oAPoupHhWRIUUAOoyUIlYVaAa/VbLbyiZUiyFbjQFNwiZQSGl4IDy9sO5Wrty0QLKhdZPxmgGcDo8ejn+c/6eiK9poz15Kw7Dr/vN/z6W7q++091/AQYA5mZ8GYJ9K0AAAAAASUVORK5CYII= ") left top no-repeat;
  }

  a.up {
    background : url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAmlJREFUeNpsU0toU0EUPfPysx/tTxuDH9SCWhUDooIbd7oRUUTMouqi2iIoCO6lceHWhegy4EJFinWjrlQUpVm0IIoFpVDEIthm0dpikpf3ZuZ6Z94nrXhhMjM3c8895977BBHB2PznK8WPtDgyWH5q77cPH8PpdXuhpQT4ifR9u5sfJb1bmw6VivahATDrxcRZ2njfoaMv+2j7mLDn93MPiNRMvGbL18L9IpF8h9/TN+EYkMffSiOXJ5+hkD+PdqcLpICWHOHc2CC+LEyA/K+cKQMnlQHJX8wqYG3MAJy88Wa4OLDvEqAEOpJd0LxHIMdHBziowSwVlF8D6QaicK01krw/JynwcKoEwZczewroTvZirlKJs5CqQ5CG8pb57FnJUA0LYCXMX5fibd+p8LWDDemcPZbzQyjvH+Ki1TlIciElA7ghwLKV4kRZstt2sANWRjYTAGzuP2hXZFpJ/GsxgGJ0ox1aoFWsDXyyxqCs26+ydmagFN/rRjymJ1898bzGzmQE0HCZpmk5A0RFIv8Pn0WYPsiu6t/Rsj6PauVTwffTSzGAGZhUG2F06hEc9ibS7OPMNp6ErYFlKavo7MkhmTqCxZ/jwzGA9Hx82H2BZSw1NTN9Gx8ycHkajU/7M+jInsDC7DiaEmo1bNl1AMr9ASFgqVu9MCTIzoGUimXVAnnaN0PdBBDCCYbEtMk6wkpQwIG0sn0PQIUF4GsTwLSIFKNqF6DVrQq+IWVrQDxAYQC/1SsYOI4pOxKZrfifiUSbDUisif7XlpGIPufXd/uvdvZm760M0no1FZcnrzUdjw7au3vu/BVgAFLXeuTxhTXVAAAAAElFTkSuQmCC ") left top no-repeat;
  }
.editor{margin-left:200px;height:100%;}
.editor iframe{}
</style>
</head>
<body>
<?php echo '<dl><dt title="'.$path.'">'.$path.'</dt>'.tree($path).'</dl>';?>
<div class="editor"><iframe src="" frameborder="0" width="0" height="0" id="frame"></iframe></div>
<script>
	var codeFrame = document.getElementById('frame');
	function editFile(src){
		codeFrame.resize();
		codeFrame.src = "tree_save.php?path="+encodeURIComponent(src.replace(/\\+/g,"/"));
	}
	codeFrame.resize = function(sh){
		var w = document.documentElement.clientWidth || document.body.clientWidth,
			h = document.documentElement.clientHeight || document.body.clientHeight;
		codeFrame.width = w - 200;
		//frame.height = h -30;
		if (sh){
			codeFrame.height = sh;
		}
	}
	
	codeFrame.resize(document.documentElement.clientHeight || document.body.clientHeight - 40);	
	</script>
</body>
</html>