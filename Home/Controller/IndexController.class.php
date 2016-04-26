<?

	//判断当前请求是否正常，如果不是通过index.php进行访问的，就退出系统
	if(!defined('ACCESS')) die('Hacking');

	/*
	 * 前端商城首页
	 */
	class IndexController extends Controller{
		public function index(){
			// $this->success('Home/index/login',"处理的很好，真棒,success",2);
			$index=new IndexModel("ec_admin_group");
			$res=$index->select("1");
			var_dump($res);
		}
	}
?>