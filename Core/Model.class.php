<?php
	//模型类父类

	//判断当前请求是否正常，如果不是通过index.php进行访问的，就退出系统
	if(!defined('ACCESS')) die('Hacking');
	
	/*
	 * 模型类父类
	 */
	class Model extends DB{

		public $tableName;		//实例化xxxModel类时的表名

		public function __construct($tableName){
			$this->tableName=$tableName;
			parent::__construct();
		}

		/*
		 * 通过主键id获取表的数据
		 * $param 记录的id号
		 * 返回值是二维数组，第一层只有一个元素，第二层数组一个元素存储结果集的一条记录
		 */
		public function select($id){
			$sql="select * from {$this->tableName} where id = $id";
			return $this->execute_dql($sql);
		}

		/*
		 * 通过主键id删除表的数据
		 * 记录的id号
		 * 返回值。0：失败，1：成功、并且修改了数据的数据，2：成功，但是没有影响任何一行
		 */
		public function delete($id){
			$sql="delete from {$this->tableName} where id = $id";
			return $this->execute_dml($sql);
		}

		/*
		 *	获取当前表所有的字段
		 */
		protected function getFields(){

		}
	}
?>