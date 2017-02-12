<?php

	//初始化类
	
	//判断当前请求是否正常，如果不是通过index.php进行访问的，就退出系统
	if(!defined('ACCESS')) die('Hacking');

	//实现初始化类
	class Init{

		//浏览器显示的字符集
		private static function initHeader(){
			//uft-8字符集
			header("Content-type:text/hmtl;charsetset=uft-8");
		}

		//目录常量
		private static function initConst(){
			//先找到项目根目录（应用根目录）,__DIR__可以找到本文件所在的目录，再通过更目录去定位其他的目录
			//根目录下
			defined('APP')				or define('APP', str_replace("Admin","",str_replace('\\', '/', __DIR__)));
			defined('APP_ADMIN')		or define('APP_ADMIN', APP.'Admin/');
			defined('APP_API')			or define('APP_API', APP.'Api/');
			defined('APP_CORE')			or define('APP_CORE', APP.'Core/');
			defined('APP_CONFIG')		or define('APP_CONFIG', APP.'Config/');
			defined('APP_PUBLIC')		or define('APP_PUBLIC', APP.'Public/');
            defined('APP_COMMON')		or define('APP_COMMON', APP.'Common/');
            defined('APP_LOGS')	    	or define('APP_LOGS', APP.'Logs/');
            //Admin目录下
			defined('ADMIN_MODEL')		or define('ADMIN_MODEL', APP_ADMIN.'Model/');
			defined('ADMIN_VIEW')		or define('ADMIN_VIEW', APP_ADMIN.'View/');
			defined('ADMIN_CONTROLLER')	or define('ADMIN_CONTROLLER', APP_ADMIN.'Controller/');
			//Api目录下
			defined('API_MODEL')		or define('API_MODEL', APP_API.'Model/');
			defined('API_VIEW')		or define('API_VIEW', APP_API.'View/');
			defined('API_CONTROLLER')	or define('API_CONTROLLER', APP_API.'Controller/');
			defined('EXT')				or define('EXT', '.class.php');
			defined('MODULE') 			or define('MODULE', 'Admin');
		}

		//加载公共函数
		private static function initFunction(){
			require_once APP_COMMON.'function.php';
		}
		
		//自定义处理错误
		private static function initError(){
			//set_error_handler("error_handler");
		}

		//配置文件加载
		private static function initConfig(){
			//加载
			$config=require_once APP_CONFIG.'config.php';

			//全局化配置文件
			$GLOBALS['config']=$config;
		}

		//使用自定义自动加载
		private static function initAutoload(){
			if (function_exists('spl_autoload_register')) {
				require_once APP_CORE.'Autoload'.EXT;
				spl_autoload_register(array('Autoload', 'AppCore'));
				spl_autoload_register(array('Autoload', 'AdminController'));
				spl_autoload_register(array('Autoload', 'AdminModel'));
			}else{
				function __autoload($className){
					//return Core::autoload($className);
				}
			}
		}

		//开启session
		private static function initSession(){
			//修改session机制
		}

		//初始化url
		private static function initUrl(){

			//pathinfo模式
			//获取网址，取出pathinfo模式下的模块，控制器和方法
			$url='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
			$path=explode("index.php", $url);
			
			$_SESSION['argus']=array();
			if((strpos($path[0], "http://")!==false) && $path[1]==""){	//控制器和方法缺省
				$controller="Index";
				$action="index";
			}else if((strpos($path[0], "http://")!==false) && strpos($path[1], "/")==0 && strrpos($path[1], "/")==0 && strlen($path[1])>1){//控制器存在，方法缺省
				//获取请求的控制器和方法
				$request=explode("/", $path[1]);
				
				//一般将类名的首字母大写，方法名小写
				$controller=ucfirst(strtolower($request[1]));
				$action="index";
			}else{
				//获取请求的控制器和方法
				$request=explode("/", $path[1]);
				
				//一般将类名的首字母大写，方法名小写
				$controller=ucfirst(strtolower($request[1]));
				$action=strtolower($request[2]);

                //将传递过来的参数封装到数组中
                for($i=0;$i<count($request);$i++){
                    if($i>2 && $i%2 ==1 ){
                        $argus[$request[$i]]=$request[$i+1];
                    }
                }
                $_SESSION['argus']=$argus;
			}

			//为了局部变量在其他地方可以使用，将之定义为常量
			define('CONTROLLER', $controller);
			define('ACTION', $action);
		}
		
		//将用户请求的控制器和方法分发
		private static function initDispatch(){
			//创建控制类的对象和调用其相关的方法
			$controller=CONTROLLER;					//类名
			$action=ACTION;							//方法名
			
			//构造全类名
			$controller .= "Controller";			//这里类文件和类名是一样的
			
			//实例化
			$object=new $controller($_SESSION['argus']);
			
			//调用方法
			$object->$action();
		}

		//初始化方法
		public static function run(){

			//浏览器显示的字符集
			self::initHeader();

			//目录常量
			self::initConst();

			//加载公共函数
			self::initFunction();
				
			//系统错误
			self::initError();

			//配置文件加载
			self::initConfig();

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