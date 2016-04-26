<?php

	//视图类

	//判断当前请求是否正常，如果不是通过index.php进行访问的，就退出系统
	if(!defined('ACCESS')) die('Hacking');


	/*
	 * 视图类
	 */
	class View{
		private $values;

		public function __construct(){
			$this->values=array();
		}

		/*
		 * 获取到要替换到模板的数据
		 */
		public function assign($name,$value){
			$this->values[$name]=$value;
		}


		/*
		 * 加载模板的方法
		 */
		public function display($template){

			//获取模板路径
			if(is_array($vars=explode("/", $template))){
				$path=APP."/".$vars['0']."/View/".$vars['1']."/".$vars['2'].".html";
			}
			// $path=ADMIN_VIEW.CONTROLLER."/".$template.'.html';
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

	
?>