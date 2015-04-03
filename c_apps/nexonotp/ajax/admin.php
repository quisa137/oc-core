<?php
namespace OCA\NEXONOTP;

\OCP\JSON::callCheck();
\OCP\JSON::checkAdminUser();

$ips = isset($_POST['ips']) ? $_POST['ips'] : null;
$content = isset($_POST['content']) ? $_POST['content'] : null;
$host = isset($_POST['host']) ? $_POST['host'] : null;
$port = isset($_POST['port']) ? $_POST['port'] : null;
$secureAlarm = isset($_POST['secureAlarm']) ? $_POST['secureAlarm'] : null;

try {
	$ips = json_decode($ips);
	$arr = $ips;
	if(is_array($ips)){
		$ips = serialize($ips);
		if (!is_null($ips)){
			Nexonotp::setinternalIPs($ips);
		}
	}
	if(!empty($content)){
		if(!is_null($content)){
			Nexonotp::setAppValue('content',$content);
		}
	}
	if(!empty($host)){
		if(!is_null($host)){
			Nexonotp::setAppValue('host',$host);
		}
	}
	if(!empty($port)){
		if(!is_null($port)){
			Nexonotp::setAppValue('port',$port);
		}
	}
	if($secureAlarm==='1') {
		Nexonotp::setAppValue('secureAlarm','true');
	}else{
		Nexonotp::setAppValue('secureAlarm','false');
	}
	\OCP\JSON::success(array('data'=>array('message' => Nexonotp::getL10n()->t('Saved'),'ips' => $arr)));
} catch (\Exception $e){
	\OCP\JSON::error(array('data'=>array('message' => $e->getMessage())));
}
