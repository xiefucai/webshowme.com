<?php
	Class DB{
		private $conn;
		private $db;
		public function __construct(){
			$db = include_once 'config_db.php';
			$this->conn = mysql_connect($db["url"],$db["user"],$db["pasw"]);
			mysql_query("set names utf8");
			mysql_select_db($db["name"],$this->conn);
		}
		private function query($query_str){
			if ($this->conn){
				return mysql_query($query_str);
			}else{
				return false;
			}
		}
		public function getSysArticleById($id){
			$query_str = 'select * from gl_article_system where article_id='.intval($id);
			$record = $this->query($query_str);
			if ($record){
				return mysql_fetch_object($record);
			}else{
				return false;
			}
		}
		public function getArticlesByCategoryId($categoryid,$page,$pageSize){
			$query_str = 'select * from gl_article ';
			if (intval($categoryid)>0){
				$query_str .='where article_category='.intval($categoryid).' ';
			}
			$query_str .= 'order by article_id desc limit '.($page-1)*$pageSize.','.$pageSize;
			$record = $this->query($query_str);
			return $record;
		}
		public function getSomeArticlesByCategoryId($id,$num){
			
			$query_str = 'select * from gl_article where article_category='.intval($id).' order by article_id desc limit 0,'.$num.'';
			$record = $this->query($query_str);
			return $record;
		}
		public function getPageOfArticleList($categoryid){
			$query_str = "select count(1) as num from gl_article";
			if ($categoryid > 0){
				$query_str .= " where article_category=".$categoryid;
			}
			return $this->query($query_str);
		}
		public function getArticleById($id){
			$query_str = 'select * from gl_article where article_id='.intval($id);
			$record = $this->query($query_str);
			return mysql_fetch_object($record);
		}
		public function updateArticleById($p){
			if (isset($p["article_id"]) && !empty($p["article_id"])){
					$id = $p["article_id"];
					unset($p["article_id"]);
					$query_str = "update gl_article set ";
					foreach($p as $k=>$v){
						if (gettype($v) === "string"){
							$query_str.= $k." = '" . $v . "',";
						}else{
							$query_str.= $k." = " . $v . ",";
						}
					}
					$query_str.= "article_time=".time()." where article_id = " . $id;
			}else{
					unset($p["article_id"]);
					$p["article_time"] = time();
					$karr = array();
					$vstr = '';
					foreach($p as $k=>$v){
						$karr[] = $k;
						if (gettype($v) === "string"){
							$vstr .= "'".$v."',";
						}else{
							$vstr .= $v.",";
						}
					}
					if (!empty($vstr)){
						$vstr = substr($vstr, 0, count($vstr)-2);
					}
					$query_str = "INSERT into gl_article(".implode(",",$karr).") values(".$vstr.")";
				}
				echo $query_str;
				$r = $this->query($query_str);
				if ($r){
					return $r;
				}else{
					return mysql_error($this->conn);
				}
		}
		public function setArticlesCategory($categoryid,$articles_id){
			$query_str = "update gl_article set article_category=".$categoryid." where article_id in(".$articles_id.")";
			//echo $query_str;
			return $this->query($query_str);
		}
		public function updateSysArticleById($article){
			if (isset($article["id"])){
				$query_str = "update gl_article_system set ";
				if (isset($article["content"])){
					$query_str.= "article_content = '" . $article["content"] . "',";
				}
				if (isset($article["author"])){
					$query_str.= "article_author = '" . $article["author"] . "',";
				}
				if (isset($article["title"])){
					$query_str.= "article_title = '" . $article["title"] . "',";
				}
				$query_str.= "article_time=".time()." where article_id = " . $article["id"];
				return $this->query($query_str);
			}else{
				return false;
			}
		}
		public function saveLiuYan($p){
			$query_str = "INSERT INTO gl_guestbook(nick,email,tel,title,content,time) VALUES ('".$p["nick"]."', '".$p["email"]."', '".$p["tel"]."', '".$p["title"]."', '".$p["content"]."', ".time().")";
			return $this->query($query_str);
		}
		public function getGuestBookList($page,$pageSize){
			$query_str = "select * from gl_guestbook order by id desc limit ".$pageSize * ($page-1).",".$pageSize;
			return $this->query($query_str);
		}
		public function getPageOfGuestBook(){
			$query_str = "select count(1) as num from gl_guestbook";
			return $this->query($query_str);
		}
		public function delGuestBookById($id){
			
			$query_str = "DELETE FROM gl_guestbook where id=".$id;
			return $this->query($query_str);
		}
		public function delArticleById($id){
			$query_str = "DELETE FROM gl_article where article_id=".$id;
			return $this->query($query_str);
		}
		public function checkAdminLogin($p){
			$query_str = "select count(1) as result from gl_admin where adminName='".$p["admin"]."' AND adminPasw='".$p["pasw"]."'";
			//echo $query_str;
			return $this->query($query_str);
		}
		public function getAdminList(){
			$query_str = "select adminName,adminId from gl_admin order by adminId";
			return $this->query($query_str);
		}
		public function getAdmin($id){
			$query_str = "select adminName,adminId from gl_admin where adminId=".intval($id);
			return $this->query($query_str);
		}
		public function saveAdmin($p){
			if (isset($p["adminId"])){
				$query_str = "update gl_admin set adminName='".$p["adminName"]."',adminPasw='".$p["adminPasw"]."' where adminId=".intval($p["adminId"]);
			}else{
				$query_str = "INSERT into gl_admin(adminName,adminPasw)values('".$p["adminName"]."','".$p["adminPasw"]."')";echo $query_str;
			}
			return $this->query($query_str);
		}		
	}