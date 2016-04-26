<?php

	//配置文件

	//判断当前请求是否正常，如果不是通过index.php进行访问的，就退出系统
	if(!defined('ACCESS')) die('Hacking');

	//配置项
	return array(
		'mysql'=>array(
			'host'=>'localhost',
			'port'=>'3306',
			'user'=>'root',
			'password'=>'root',
			'db'=>'ec_ecshop',
			'prefix'=>'ec_',
			'charset'=>'utf8'
			)
		);
?>