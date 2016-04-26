<?php

	//初始化类
	
	//判断当前请求是否正常，如果不是通过index.php进行访问的，就退出系统
	if(!defined('ACCESS')) die('Hacking');

	//实现初始化类
	class Application{

		//浏览器显示的字符集
		private static function initHeader(){
			//uft-8字符集
			header("Content-type:text/hmtl;charsetset=uft-8");
		}

		//目录常量
		private static function initConst(){
			//先找到项目根目录（应用根目录）,__DIR__可以找到本文件所在的目录，再通过更目录去定位其他的目录
			//根目录下
			defined('APP')			or define('APP', str_replace('Core', '', str_replace('\\', '/', __DIR__)));
			defined('APP_ADMIN')		or define('APP_ADMIN', APP.'Admin/');
			defined('APP_HOME')			or define('APP_HOME', APP.'Home/');
			defined('APP_CORE')			or define('APP_CORE', APP.'Core/');
			defined('APP_CONFIG')		or define('APP_CONFIG', APP.'Config/');
			defined('APP_PUBLIC')		or define('APP_PUBLIC', APP.'Public/');
			defined('APP_COMMON')		or define('APP_COMMON', APP.'Common/');
			//Admin目录下
			defined('ADMIN_MODEL')		or define('ADMIN_MODEL', APP_ADMIN.'Model/');
			defined('ADMIN_VIEW')		or define('ADMIN_VIEW', APP_ADMIN.'View/');
			defined('ADMIN_CONTROLLER')	or define('ADMIN_CONTROLLER', APP_ADMIN.'Controller/');
			//Home目录下
			defined('HOME_MODEL')		or define('HOME_MODEL', APP_HOME.'Model/');
			defined('HOME_VIEW')		or define('HOME_VIEW', APP_HOME.'View/');
			defined('HOME_CONTROLLER')	or define('HOME_CONTROLLER', APP_HOME.'Controller/');
			defined('EXT')				or define('EXT', '.class.php');
		}

		//系统错误
		private static function initError(){

			//错误的显示级别:开发阶段显示所有错误
			ini_set('error_reporting', E_ALL);

			//是否显示错误:显示所有错误
			ini_set('display_error', 1);
		}

		//配置文件加载
		private static function initConfig(){
			//加载
			$config=require_once APP_CONFIG.'config.php';

			//全局化配置文件
			$GLOBALS['config']=$config;
		}

		//加载公共函数
		private static function initFunction(){
			require_once APP_COMMON.'function.php';
		}


		//使用自定义自动加载
		private static function initAutoload(){
			if (function_exists('spl_autoload_register')) {
				require_once APP_CORE.'Autoload'.EXT;
				spl_autoload_register(array('Autoload', 'autoloadAppCore'));
				spl_autoload_register(array('Autoload', 'autoloadAdminController'));
				spl_autoload_register(array('Autoload', 'autoloadHomeController'));
				spl_autoload_register(array('Autoload', 'autoloadAdminModel'));
				spl_autoload_register(array('Autoload', 'autoloadHomeModel'));
			}else{
				function __autoload($className){
					//return Core::autoload($className);
				}
			}
		}

		//开启session
		private static function initSession(){
			//修改session机制
			//这个有空再做了
		}

		//初始化url
		private static function initUrl(){

			//如果有参数，就是传统的传值访问，否则就是pathinfo模式，目前只有这两种url模式
			if($_SERVER['QUERY_STRING']){	//传统模式
				//获取模块
				$module=isset($_REQUEST['m']) ? $_REQUEST['m'] : "";
				//获取用户请求的控制器
				$controller=$_REQUEST['c'];
				//获取当前用户请求方法
				$action=$_REQUEST['a'];

				if (isset($module)) {
					//一般将模块名首字母大写
					$module=ucfirst(strtolower($module));
					//为了局部变量在其他地方可以使用，将之定义为常量
					define('MODULE', $module);
				}
			}else{	//pathinfo模式
				//获取文件地址，取出pathinfo模式下的模块，控制器和方法
				$url='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
				$path=explode("index.php", $url);
				
				if((strpos($path[0], "http://")!==false) && $path[1]==""){	//控制器和方法缺省
					$controller="Index";
					$action="index";
				}else{
					//解析url
					$url=explode("/", $url);

					$module=array_slice($url,-3,1);
					$controller=array_slice($url,-2,1);
					$action=array_slice($url,-1,1);

					if($module[0]=='Admin' || $module[0]=='Home'){ //有传模块名
						$module=$module[0];
						$controller=$controller[0];
						$action=$action[0];

						if (isset($module)) {
							//一般将模块名首字母大写
							$module=ucfirst(strtolower($module));
							//为了局部变量在其他地方可以使用，将之定义为常量
							define('MODULE', $module);
						}
					}else{									//没有传模块名，只是传了控制名和方法名
						$controller=$controller[0];
						$action=$action[0];
					}
				}
			}

			//一般将类名的首字母大写
			$controller=ucfirst(strtolower($controller));

			//为了局部变量在其他地方可以使用，将之定义为常量
			define('CONTROLLER', $controller);
			define('ACTION', $action);
		}
		
		//将用户请求的控制器和方法分发
		private static function initDispatch(){
			//创建控制类的对象和调用其相关的方法
			if(defined('MODULE')) $module=MODULE;	//模块名
			$controller=CONTROLLER;					//类名
			$action=ACTION;							//方法名
			//构造全类名
			$controller .= "Controller";		//这里类文件和类名是一样的
			//实例化
			$module=new $controller(); 		//$controller，不能忘了$,变量才是代表类名
			//调用方法
			$module->$action();
		}

		//初始化方法
		public static function run(){

			//浏览器显示的字符集
			self::initHeader();

			//目录常量
			self::initConst();

			//系统错误
			self::initError();

			//配置文件加载
			self::initConfig();

			//加载公共函数
			self::initFunction();

			//类的自动加载，调用函数自定义spl_autoload_register()文件加载
			self::initAutoload();

			//开启session
			self::initSession();

			//初始化url，获取当前用户的请求，其实就是执行确定的控制器的确定方法
			self::initUrl();

			//将用户请的控制器和方法分发
			self::initDispatch();
		}


	}

?>