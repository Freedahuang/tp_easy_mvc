本框架要注意的地方
①调用assign()时，应该注意模板中的替换变量的名字应该和assign的第一个参数一样，
并且第一个参数是用单引号引起来，因为替换模板的位置和值是根据assign的参数确定的，双引号会解析成变量
单引号不会，是作为字符串传递的，这个忘了回看代码就知道了

②如果子类没自定义构造函数，则自动执行父类的构造函数，反之，如果子类定义类构造函数，就不会自动执行父类的构造函数。要在子类的构造函数中显式调用父类的构造函数parent::__construct()
用在是否调用Db.class.php的构造函数上
