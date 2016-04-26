<?php
	//控制器父类

	//判断当前请求是否正常，如果不是通过index.php进行访问的，就退出系统
	if(!defined('ACCESS')) die('Hacking');

	/**
	* 控制器父类
	*/
	class Controller
	{

		protected $view;

		public function __construct(){
			$this->view = new View();
		}

		/*
		 * 跳转方法
		 * @param string 跳转的url
		 * @param string 提示的信息
		 * $url要跳转到的地址是在redirect.html里面执行的
		 */
		protected function redirect($url,$msg,$time = 2){

			$path='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
			$path=explode("index.php", $path);
			//重新构建url，解决从传统模式和pathinfo模式下跳转到其他方法时url的不兼容性
			strpos($url, "/")!==false ? $url=$path[0]."index.php/".$url : $url=$path[0]."index.php?".$url;

			$this->view->assign('{$url}',$url);
			$this->view->assign('{$msg}',$msg);
			$this->view->assign('{$time}',$time);
			$this->view->display("Common/redirect");
		}

		/*
		 * 成功时跳转的方法
		 * @param 跳转的地址
		 * @param 跳转的提示
		 * @param 跳转的时间
	 	 */
		protected function success($url,$msg,$time = 1){
			$this->redirect($url,$msg,$time);
		}

		/*
		 * 失败时跳转的方法
		 * @param 跳转的地址
		 * @param 跳转的提示
		 * @param 跳转的时间
	 	 */
		protected function error($url,$msg,$time = 3){
			$this->redirect($url,$msg,$time);
		}
	}
?>