<?php
namespace OCA\NEXONOTP;
class Hooks {
	public static function register() {
		\OCP\Util::connectHook('OC_User', 'post_login', 'OCA\NEXONOTP\Hooks', 'afterLogin');
		\OCP\Util::connectHook('OC_User', 'logout', 'OCA\NEXONOTP\Hooks', 'beforeLogout');
		\OCP\Util::connectHook('Filesystem', 'create','OCA\NEXONOTP\Hooks','fileCreate');
	}
	public static function afterLogin($uid) {
		return Data::send('login',$_SERVER['HTTP_USER_AGENT']);

	}
	public static function beforeLogout() {
		return Data::send('logout',$_SERVER['HTTP_USER_AGENT']);
	}
	public static function fileCreate($path,&$run) {
		
	}
}
?>