<?php
	//项目入口
	
	//为了能保证用户是从这index.php这个入口进去的，一般会在这个入口增加一个常量，前后台共用
	define('ACCESS', true);
	
	//加载初始化类
	require_once './init.php';
	
	//对系统进行初始化
	Init::run();
	
?>