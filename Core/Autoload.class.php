<?php
	//自动加载类

	//判断当前请求是否正常，如果不是通过index.php进行访问的，就退出系统
	if(!defined('ACCESS')) die('Hacking');

	/*
	 * 类的自动加载，先加载核心类，再加载控制器类，先加载使用较多的类
	 */
	class Autoload{

		//加载核心类，从核心类文件夹中加载
		public static function autoloadAppCore($className){
			$path=APP_CORE."$className".EXT;
			if(file_exists($path)){
				require_once $path;
			}
		}

		//加载Admin模块控制器类，从控制器类文件夹中加载
		public static function autoloadAdminController($className){
			$path=ADMIN_CONTROLLER."$className".EXT;
			if(file_exists($path)){
				require_once $path;
			}
		}

		//加载Home模块控制器类，从控制器类文件夹中加载
		public static function autoloadHomeController($className){
			$path=HOME_CONTROLLER."$className".EXT;
			if(file_exists($path)){
				require_once $path;
			}
		}

		//加载Admin模块模型类
		public static function autoloadAdminModel($className){
			$path=ADMIN_MODEL."$className".EXT;
			if(file_exists($path)){
				require_once $path;
			}
		}

		//加载Home模块模型类
		public static function autoloadHomeModel($className){
			$path=HOME_MODEL."$className".EXT;
			if(file_exists($path)){
				require_once $path;
			}
		}
	}

?>