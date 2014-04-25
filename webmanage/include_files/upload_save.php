<?php
	header("Content-type:text/html;charset=utf-8");
	require_once 'ini.php';
	require_once 'JSON.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') //判断方法是否为post
{
            if(!is_uploaded_file($_FILES['imgFile']['tmp_name'])){ //验证上传文件是否存在
			//echo '<script>frameElement.callback({"ret":5,"msg":"请选择你想要上传的文件"});</script>';
			alert('请选择你想要上传的文件');
			exit;
		}
		$files = $_FILES['imgFile'];
		$path = 'upload_files/';
		$destination_file = ROOT_PATH.'/'.$path;
		$max_file_size = 2097152;
		if($max_file_size < $files['size']){//判断文件是否超过限制大小
			echo '<script>frameElement.callback({"ret":4,"msg":"你上传的图片过大,本系统最大图片为2MB"});</script>';
			exit;
		}
		$imgType = array(//判断文件格式是否正确
							'image/jpeg',
							'image/pjpeg',
							'image/gif',
							'image/png',
							'image/jpg',
							'image/x-png',
							'image/bmp'
						);
		if(!in_array($files['type'],$imgType)){
				//echo '<script>frameElement.callback({"ret":3,"msg":"不支持此类型文件"});</script>';
				alert('不支持此类型文件：'.$files['type']);
				exit;
				}
		if(!file_exists($destination_file)){//判断上传目录是否存在,不存在则创建一个.
				mkdir($destination_file);
				}
		$filename=$files["tmp_name"];
                $destination = $destination_file.$files['name'];
                if (file_exists($destination) && $overwrite != true){//判断文件是否已经存在
                                //echo '<script>frameElement.callback({"ret":2,"msg":"同名文件已经存在了"});</script>';
                                //exit;
                                alert('同名文件已经存在了');
                         }
                if(!move_uploaded_file ($files['tmp_name'], $destination_file.$files['name'])){
                               //echo '<script>frameElement.callback({"ret":1,"msg":"移动文件出错"});</script>';
                               //exit;
                               alert('移动文件出错');
                         }
      //打印出上传文件到页面
	  //echo '<script>frameElement.callback({"ret":0,"src":"'.$path.$files['name'].'","name":"'.$files['name'].'"});</script>';
	  $json = new Services_JSON();
	  echo $json->encode(array('error' => 0, 'url' => '../../'.$path.$files['name']));
	  exit;
      //echo "<div class=\"preview\"><p>你上传的图片为:</p><div class=\"imgLoad\">"."<img src=\"{$destination}\" alt=\"{$files['name']}\" />"."</div></div>";
}

function alert($msg) {
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 1, 'message' => $msg));
	exit;
}
?>