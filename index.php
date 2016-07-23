<?php
	//项目入口
	
	//为了能保证用户是从这index.php这个入口进去的，一般会在这个入口增加一个常量，
	
	define('ACCESS', true);
	
	//加载初
	
	require_once './Core/Application.class.php';
	
	//对系统进行12化

	Application::run();

	//这是增加的代码区域
	
?>
