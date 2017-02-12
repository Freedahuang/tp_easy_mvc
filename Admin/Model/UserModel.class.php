<?php
	//判断当前请求是否正常，如果不是通过index.php进行访问的，就退出系统
	if(!defined('ACCESS')) die('Hacking');

	class UserModel extends Model{
		public function __construct($table){
			parent::__construct($table);
		}
		
		public function index(){
			echo "dd";
		}
		
		public function getList(){
			$prefix=PREFIX;
			$sql="delete from {$prefix}user where user_id = 24";
			$res=$this->execute_dml($sql);
			var_dump($res);
		}
	}
	
	
	
	
	
?>