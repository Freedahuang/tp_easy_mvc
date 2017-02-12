<?php

	//判断当前请求是否正常，如果不是通过index.php进行访问的，就退出系统
	if(!defined('ACCESS')) die('Hacking');

    class IndexController extends Controller{
    	
        public function index(){
        	
//         	$user=M("User");
//         	$user->getList();
        	$this->redirect("Index/good","");
        	
//         	$name="huangfohai";
//             $this->assign("{name}", $name);
// 			$this->display("Index/index");
        }
        
        public function good(){
        	echo PREFIX;
        }
    }
?>