<?php
defined( 'ABSPATH' ) or die( 'access denied.' );
define('CWP_PL_AUTOLOAD_ROOT', plugin_dir_path(__FILE__) );
spl_autoload_register('cwp_login__autoloader');
function cwp_login__autoloader($classname) {
    if(strpos($classname, 'cwp_login') === 0) {
        $namespace = substr($classname, 0, strrpos($classname, '\\'));
        $namespace = str_replace('\\', DIRECTORY_SEPARATOR, $classname);
        $classPath = CWP_PL_AUTOLOAD_ROOT . str_replace('\\', '/', $namespace) . '.php';
        if (is_readable($classPath)) {
            require_once $classPath;
        }
    }
}
