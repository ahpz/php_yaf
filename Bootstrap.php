<?php
/**
 * @name Bootstrap
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Ap调用,
 * 这些方法, 都接受一个参数:Ap_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
//define("NO_THROW_DB", true);//保证数据库Dao不抛出异常，只是返回false
class Bootstrap extends Ap_Bootstrap_Abstract{
    /**
     * @param Ap_Dispatcher $dispatcher
     */
	public function _initRoute(Ap_Dispatcher $dispatcher) {
		//在这里注册自己的路由协议,默认使用static路由
        Ap_Dispatcher::getInstance()->autoRender(false);
        Ap_Dispatcher::getInstance()->disableView();
	}
	
	public function _initPlugin(Ap_Dispatcher $dispatcher) {
        //注册saf插件
        $objPlugin2= new Validate_ApiPlugin();
        $dispatcher->registerPlugin($objPlugin2);
        //注册验证自定义插件
        $objPlugin = new Saf_ApUserPlugin();
        $dispatcher->registerPlugin($objPlugin);
    }

    /**
     * @param Ap_Dispatcher $dispatcher
     */
	public function _initView(Ap_Dispatcher $dispatcher){
		//在这里注册自己的view控制器，例如smarty,firekylin
		$dispatcher->disableView();//禁止ap自动渲染模板
	}

    /**
     * @param Ap_Dispatcher $dispatcher
     */
    public function _initDefaultName(Ap_Dispatcher $dispatcher) {
        //设置路由默认信息
        //$dispatcher->setDefaultModule('demo');
        //$dispatcher->setDefaultController('api');
        $dispatcher->setDefaultAction('sample');

    }

    /**
     * @param Ap_Dispatcher $dispatcher
     * @return bool
     */
    public function __initLoad(Ap_Dispatcher $dispatcher) {

        //require_once(ROOT_PATH . "/php/phplib/vendors/Cross-PHPExcel-1-8-1/Classes/PHPExcel.php");//加载excel扩展类
        //library 命名空间搜索路径 添加
        if (function_exists('__autoload')) {
            //    Register any existing autoloader function with SPL, so we don't get any clashes
            spl_autoload_register('__autoload');
        }

        //    Register ourselves with SPL
        if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
            return spl_autoload_register(function($pClassName) {
                $pClassFilePath = trim(str_replace('\\', DIRECTORY_SEPARATOR, $pClassName), DIRECTORY_SEPARATOR);
                $pClassFilePath = ROOT_PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . Bd_AppEnv::getCurrApp() .
                    DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . $pClassFilePath . ".php";

                if ((file_exists($pClassFilePath) === FALSE) || (is_readable($pClassFilePath) === FALSE)) {
                    //    Can't load
                    return FALSE;
                }
                require($pClassFilePath);
            }, true, true);//抛出异常 添加到队列之首
        } else {
            return spl_autoload_register(function($pClassName) {
                $pClassFilePath = trim(str_replace('\\', DIRECTORY_SEPARATOR, $pClassName), DIRECTORY_SEPARATOR);
                $pClassFilePath = ROOT_PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . Bd_AppEnv::getCurrApp() .
                    DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . $pClassFilePath . ".php";
                echo $pClassFilePath . PHP_EOL;
                if ((file_exists($pClassFilePath) === FALSE) || (is_readable($pClassFilePath) === FALSE)) {
                    //    Can't load
                    return FALSE;
                }
                require($pClassFilePath);
            });
        }
    }

}
