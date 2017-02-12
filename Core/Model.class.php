<?php
	//模型类父类

	//判断当前请求是否正常，如果不是通过index.php进行访问的，就退出系统
	if(!defined('ACCESS')) die('Hacking');
	
	/*
	 * 模型类父类
	 */
	class Model extends Db{

		public $table;		//实例化xxxModel类时的表名

		public function __construct($table){
			$this->table=$table;
			parent::__construct();
		}
		
	}
?>