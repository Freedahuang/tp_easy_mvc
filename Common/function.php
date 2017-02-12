<?php

   /**
	* 定义error_handler 函数
	*
	* @param $error_level 错误级别
	* @param $error_message 错误信息
	* @param $file 错误所在文件
	* @param $line 错误所在行数
	*
	*/
	function error_handler($error_level,$error_message,$file,$line) {
		$flag = false;
		switch ($error_level) {
			//提醒级别
			case E_NOTICE:
			case E_USER_NOTICE:
			$error_type = 'Notice';
			break;
			
			//警告级别
			case E_WARNING:
			case E_USER_WARNING:
			$error_type = 'Warning';
			break;
			
			//错误级别
	        case E_ERROR:
	        case E_USER_ERROR:
	            $error_type = 'Fatal Error';
	            $flag = true;
	            break;
	         
	        //其他未知错误
	        default:
	            $error_type = 'Unknown';
	            $flag = true;
	            break;
		}
		
		file_put_contents(APP_LOGS."error.txt","文件：".$file.PHP_EOL."行数：".$line.PHP_EOL."错误级别：".$error_type.PHP_EOL."错误信息：".$error_message.PHP_EOL.PHP_EOL,FILE_APPEND);
		
	}
	
	
	/*
	 * 获取数据操作对象
	 * $table  表名
	 */
	function M($table){
		
		if(strpos($table, "Admin")===0 || strpos($table,"Api")===0){//参数填写方式：模块/控制器名。 Admin/User
			echo "这种获取数据操作对象方式暂时没有写。位置：app/Common/function.php 的M()";
		}else{//参数填写方式：控制器名。 User
			$class=$table."Model";
				
			if(MODULE == "Admin"){
				require_once ADMIN_MODEL."/".$class.EXT;
				return new $class($table);
			}else if(MODULE == "Api"){
				require_once API_MODEL."/".$class.EXT;
				return new $class($table);
			}
		}
		
	}
	
	
	/*
	 * 过滤XSS攻击
	 */
	function filterXSS($mix){
		if(is_string($mix)){//字符串
			return htmlspecialchars(strip_tags(trim($mix)),ENT_QUOTES);
		}else{//数组
			$res=array();
			foreach ($mix as $key => $value){
				$res[$key]=htmlspecialchars(strip_tags(trim($value)),ENT_QUOTES);
			}
			return $res;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	


?>