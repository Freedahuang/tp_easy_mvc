<?php

	//判断当前请求是否正常，如果不是通过index.php进行访问的，就退出系统
	if(!defined('ACCESS')) die('Hacking');

	class Db{
		public $conn;
		
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
			$this->conn=mysql_connect($this->host.":".$this->port,$this->user,$this->password);
			if (!$this->conn){
				die("连接数据库失败：".mysql_error());
			}
			mysql_select_db($this->db);
			mysql_query("set names {$this->charset}");
		}

		/*
		 * 操作dql查询语句
		 */
		public function execute_dql($sql){
			$res=mysql_query($sql,$this->conn) or die(mysql_errno().":".mysql_error());
			$i=0;
			$arr=array();
			while ($row=mysql_fetch_assoc($res)){	//将结果集存放在一个数组里面，这样就用完结果集了
				$arr[$i++]=$row;
			}
			mysql_free_result($res);				//关闭结果集，释放资源
			return $arr;
		}

		/*
		 * 操作dml语句
		 */
		public function execute_dml($sql){
			$res=mysql_query($sql,$this->conn) or die(mysql_errno().":".mysql_error());
			if (!$res) {
				//失败
				return 0;
			}else{
				if (mysql_affected_rows($this->conn)>0){
					//成功，并且修改了数据的数据
					return 1;
				}else {
					//成功，但是没有影响任何一行，语句正确不一定有真正的操作到了数据库的数据
					return 2;
				}
			}
		}	
		//关闭连接
		public function close_connect(){
			if (!empty($this->conn)) {		//先判断一下，如果还连着，就断掉
				mysql_close($this->conn);
			}
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	