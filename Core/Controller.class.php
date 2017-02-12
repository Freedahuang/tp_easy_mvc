<?php
	//控制器父类

	//判断当前请求是否正常，如果不是通过index.php进行访问的，就退出系统
	if(!defined('ACCESS')) die('Hacking');

	/**
	* 控制器父类
	*/
	class Controller
	{
		/*
		 * 获取到网址传递过来的参数，参数是以数组的形式存储的
		 */
		public function __construct($argus)
		{
			$this->argus=$argus;
		}

		/*
		 * 跳转方法
		 * 路径  Login/index   Api/Login/index
		 * 参数  name/huangfohai/age/20
		 */
		protected function redirect($route,$argu){
			$argus=array();
			if( strpos($route, "Admin")===0 || strpos($route,"Api")===0){//参数填写方式：模块/控制器/方法。 Api/Index/index
				echo "这种跳转方式暂时没有写。位置：app/Core/Controller.class.php 的redirect()";
			}else{//参数填写方式：/控制器/方法。 Index/index
				
				//获取控制器和方法
				$request=explode("/", $route);
				$controller=$request[0]."Controller";
				$action=$request[1];
				
				//获取要传递的参数
				if(!empty($argu)){
					$res=explode("/", $argu);
					for($i=0;$i<count($res);$i++){
						if( $i % 2 ==0 ){
							$argus[$res[$i]]=$res[$i+1];
						}
					}
				}
				
				$object=new $controller($argus);
				$object->$action();
			}
		}

		/*
		 * 传递参数
		 * @param string 键
		 * @param string 值
		 */
		protected function assign($name,$value){
			$this->values[$name]=$value;
		}

		/*
		 * 加载模板的方法
		 */
		protected function display($template){
			
			if(strpos($template, "Admin")===0 || strpos($template,"Api")===0){//参数填写方式：模块/控制器/方法。 Api/Index/index
				echo "这种显示模板的方式暂时没有写。位置：app/Core/Controller.class.php 的display()";
			}else{//参数填写方式：/控制器/方法。 Index/index
				
				//获取模板路径
				$vars=explode("/", $template);
				
				if(MODULE == "Admin"){
					$path=ADMIN_VIEW.$vars[0]."/".$vars[1].".html";
				}else if(MODULE == "Api"){
					$path=API_VIEW.$vars[0]."/".$vars[1].".html";
				}
				
				if(file_exists($path)){
					$file=file_get_contents($path);
					//循环替换掉模板里面的标签
					foreach ($this->values as $key => $value) {
						$file=str_replace($key, $value, $file);
					}
					//要加入这句话，echo出来的html代码才会被解析，不懂，因为回来的报文头本身已经包含了它
					//为什么还要设置
					header('Content-Type:text/html; charset=utf-8');
					echo $file;
					exit;
				}
			}
				
		}

	}
?>







