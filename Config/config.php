<?php

	//配置文件

	//判断当前请求是否正常，如果不是通过index.php进行访问的，就退出系统
	if(!defined('ACCESS')) die('Hacking');

	//配置项
	
	if(stripos($_SERVER['HTTP_HOST'], '.dev') > -1){  //本地服务器
		return array(
				'mysql'=>array(
						'host'=>'localhost',
						'port'=>'3306',
						'user'=>'root',
						'password'=>'',
						'db'=>'opencart',
						'prefix'=>'mcc_',
						'charset'=>'utf8'
				)
		);
	}else if(false){//测试服务器
		return array(
				'mysql'=>array(
						'host'=>'',
						'port'=>'',
						'user'=>'',
						'password'=>'',
						'db'=>'',
						'prefix'=>'',
						'charset'=>''
				)
		);
		
	}else{//正式服务器
		return array(
				'mysql'=>array(
						'host'=>'',
						'port'=>'',
						'user'=>'',
						'password'=>'',
						'db'=>'',
						'prefix'=>'',
						'charset'=>''
				)
		);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>
