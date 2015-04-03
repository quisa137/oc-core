<?php
$appId = 'nexonotp';
$reqMethod = [];
$userAgent = [];


use OCA\NEXONOTP\Nexonotp;

if(\OC::$CLI===false) {
	$loginId = OC_User::getUser();
	$isLogin = !empty($loginId);
	if (!$isLogin && !Nexonotp::isVaildIP(Nexonotp::getUserIP())) {
		if(strpos($_SERVER['SCRIPT_NAME'], '/public.php')===false) {
			OCP\Util::addScript($appId, 'login');
		}
		if(!empty($_POST)) {
			$userid = isset($_POST['user'])?$_POST['user']:'';
			$otp = isset($_POST['otpNumber'])?$_POST['otpNumber']:'';
			//OTP 앱이 사용되면 OTP인증을 거치지 않고는 로그인이 불가능하게 처리한다.
			if(!empty($userid) && empty($otp)) {
				\OCP\Util::writeLog($appId, 'NEXONOTP required '.$userid.'`s otp number.', \OCP\Util::DEBUG);
				OC_Util::redirectToDefaultPage();
			}

			//입력 변수가 온전해야 인증 할 수 있다
			if(!empty($userid) && !empty($otp)) {

				$otpReq = new Nexonotp();
				$resp = $otpReq->send(array('username'=>$userid,'otpcode'=>$otp),'otp/vaildation');
				$respValue = json_decode($resp['response'],true);
				// \OCP\Util::writeLog($appId, $respValue, \OCP\Util::DEBUG);
				//인증값이 불완전하면 로그인을 불가능하게 처리한다.
				if($respValue['status']!=='OK') {
					$_POST['user'] = '';
					$_POST['password'] = '';
				}
			}
		}
	}else {
		//첫 로그인의 경우 보안 인증 팝업을 띄운다.
		$secureAlarm = OCP\Config::getAppValue($appId, 'secureAlarm','false');
		if($secureAlarm==='true') {
			if($isLogin && !Nexonotp::isUserReaded()) {
				OCP\Util::addStyle($appId, 'colorbox');
				OCP\Util::addScript($appId, 'jquery.colorbox-min');
				OCP\Util::addScript($appId, 'agreed');
			} else if($isLogin) {
				OCP\Util::addScript($appId, 'popup_util');
				OCP\Util::addScript($appId, 'security_upgrade');
			}
		}
	}
	\OCP\App::registerPersonal($appId, 'personal');
	\OCP\App::registerAdmin($appId, 'admin');
	OCA\NEXONOTP\Hooks::register();
}
