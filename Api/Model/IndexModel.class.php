<?php
	
	//判断当前请求是否正常，如果不是通过index.php进行访问的，就退出系统
	if(!defined('ACCESS')) die('Hacking');

	/*
	 * 首页模型类
	 */
	class IndexModel extends Model{
		public function index(){
			
			
		}
	}
?>