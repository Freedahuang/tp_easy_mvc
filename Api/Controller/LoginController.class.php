<?php

	//判断当前请求是否正常，如果不是通过index.php进行访问的，就退出系统
	if(!defined('ACCESS')) die('Hacking');

	class LoginController extends Controller{
		public function index(){
			print_r($this->argus);
		}
	}