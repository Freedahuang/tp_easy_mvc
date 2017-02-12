<?php

	//判断当前请求是否正常，如果不是通过index.php进行访问的，就退出系统
	if(!defined('ACCESS')) die('Hacking');

	class Db{
		public $mysqli;
		
		public $host;
		public $port;
		public $user;
		public $password;
		public $db;
		public $charset;

		/*
		 * 构造函数，同时连接数据库
		 * @param string 主机名
		 * @param string 端口号
		 * @param string 用户名
		 * @param string 密码
		 * @param string 数据库
		 * @param string 编码方式
		 */
		public function __construct($arr=array()){
			//从配置文件中获取必要信息
			$this->host=$GLOBALS['config']['mysql']['host'];
			$this->port=$GLOBALS['config']['mysql']['port'];
			$this->user=$GLOBALS['config']['mysql']['user'];
			$this->password=$GLOBALS['config']['mysql']['password'];
			$this->db=$GLOBALS['config']['mysql']['db'];
			$this->charset=$GLOBALS['config']['mysql']['charset'];

			//连接数据库
			$this->connect_db();
		}

		/*
		 * 连接数据库
		 */
		public function connect_db(){
			
			$this->mysqli = new mysqli($this->host, $this->user, $this->password, $this->db);
			
			if ($this->mysqli->connect_error) {
				die("连接数据库失败：".$mysqli->connect_error);
			}
			
			if (!$this->mysqli->set_charset("utf8")) {
				die("设置默认字符编码失败：".$mysqli->error);
			}
		}

		/*
		 * 操作mysqli预处理
		 */
		public function execute_prepare($sql){
			$stmt = $this->mysqli->prepare($sql);
			return $stmt;
		}
		
		/*
		 * 执行sql查询语句
		 */
		public function execute_dql($stmt){
			$stmt->execute();
			$result = $stmt->get_result()->fetch_all();

			//关闭结果集
			$stmt->free_result();
			$stmt->close();
			//操作完成数据库后，要及时关闭连接，不然比较浪费资源。还有如果不关闭，插入一条记录时可能会变成插入两条
			$this->mysqli->close();
			
			return $result;
		}

		/*
		 * 操作dml语句
		 */
		public function execute_dml($stmt){
			
			$res=$stmt->execute();
			
			if(!$res){
				//失败
				$stmt->close();
				$this->mysqli->close();  
				return 0;
			}else{
				if($stmt->affected_rows>0){
					//成功，并且修改了数据的数据
					$stmt->close();
					$this->mysqli->close();
					return 1;
				}else{
					//成功，但是没有影响任何一行，语句正确不一定有真正的操作到了数据库的数据
					$stmt->close();
					$this->mysqli->close();
					return 2;
				}
			}
			
		}	
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	