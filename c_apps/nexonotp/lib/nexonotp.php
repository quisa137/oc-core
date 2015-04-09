<?php

namespace OCA\NEXONOTP;

use \OCP\Config;
class Nexonotp {
	const APP_NAME = 'nexonotp';
	private $session_file;
    public function __construct() {
         $this->session_file = __DIR__.'/session_'.\OCP\Config::getSystemValue('instanceid').'.txt';
    }
    public function getSessionFile() {
        return $this->session_file;
    }
	public static function getL10n(){
		return \OCP\Util::getL10N(self::APP_NAME);
	}

	public static function getinternalIPs(){
		return self::getAppValue('ips',serialize(array()));
	}
	public static function setinternalIPs($value){
		return self::setAppValue('ips', $value);
	}
	public static function getSettings() {
		return self::getAppValue('Settings',array());
	}
	public static function setSettings($value){
		return self::setAppValue('Settings', $value);
	}
	public static function getAppValue($key, $default){
		return \OCP\Config::getAppValue(self::APP_NAME, $key, $default);
	}
	public static function setAppValue($key, $value){
		return \OCP\Config::setAppValue(self::APP_NAME, $key, $value);
	}
	protected static function getUserValue($key, $default){
		return \OCP\Config::getUserValue(\OC_User::getUser(),self::APP_NAME, $key, $default);
	}
	protected static function setUserValue($key, $value){
		return \OCP\Config::setUserValue(\OC_User::getUser(),self::APP_NAME, $key, $value);
	}
	public static function isUserReaded() {
		$user = self::getUserReaded();
		return !empty($user);
	}
	public static function getUserReaded() {
		return self::getUserValue('agreed',0);
	}
	public static function setUserReaded() {
		return self::setUserValue('agreed', date('Y-m-d H:i:s'));
	}
	public static function isVaildIP($inputIP = null){
		$ips = unserialize(self::getinternalIPs());
		$inputIP = $inputIP=='::1'?'127.0.0.1':$inputIP;
		foreach($ips as $ip) {
			$matches = array();
			$start = 0;
			$end = 0;
			$input = 0;
			$rangebit = 31;

			//대역 비트가 있으면 비트를 얻어온다
			if(preg_match_all('/\/\d{1,2}/', $ip,$matches)){
				$rangebit = intval(str_replace('/','',$matches[0][0]));
				$ip = str_replace($matches[0][0], '', $ip);
			}

			//아이피 주소를 정수로 변환
			$start = ip2long($ip);
			$input = ip2long($inputIP);

			//비트에 따른 아이피 갯수 계산
			$q = 0;
			for($f = (31-$rangebit);$f>=0;$f--){
				$q += pow(2,$f);
			}
			$end = $start + $q;
			if($start <= $input && $input <=$end){
				return true;
			}
		}
		return false;
	}
	/**
	 * Parse the User Agent
	 * Device, DeviceType, OSType,IP, Browser String, Connect Region
	 */
	public function parseUserAgent() {
		$uaStr = $_SERVER['HTTP_USER_AGENT'];
		$uIP = self::getUserIP();
		$osRegex = '/Windows( NT| Phone| CE)?|Mac OS X|Android( \d(\.\d(\.\d)?)?)?/';
		$isLinuxRegex = '/Linux( arm| x86_64| i686)?/';
		$deviceRegex = '/Macintosh|iPad|iPhone|BlackBerry|Samsung|LG|HTC|Android/';
		$browserRegex = '/MSIE( \d{1,3}\.\d)?|Mobile Safari|Chrome|Firefox|Safari|mirall|neon/';
		$ie11LaterRegex = '/(Trident)\/.+; rv:(\d{1,3}\.\d)/';
		$device = array();
		$os = array();
		$browser = array();
		$linux = array();

		preg_match($deviceRegex, $uaStr, $device);
		preg_match($osRegex, $uaStr, $os);
		preg_match($browserRegex, $uaStr,$browser);
		$isLinux = preg_match($isLinuxRegex, $uaStr, $linux);
		$os = count($os)>0?$os[0]:'';
		$browser = count($browser)>0?$browser[0]:'';
		$device = count($device)>0?$device[0]:'';

		if(empty($os)){
			if($isLinux){
				$os = count($linux)>0?$linux[0]:'unknown linux';
			}else{
				$os = 'unknown';
			}
		}
		if(empty($browser)){
			if(preg_match($ie11LaterRegex, $uaStr,$browser)){
				if(count($browser)==3){
					$tmpBrowser = $browser[1]=='Trident'?'MSIE':'';
					$tmpBrowser .= ' '.(floatval($browser[2]));
					$browser = $tmpBrowser;
				}
			}else{
				$browser = 'unknown';
			}
		}
		if(empty($device)){
			$device = 'PC';
		}
		$browser = ($browser == 'neon')?'mirall':$browser;
		$os = ($device == 'Macintosh')?'MAC OS X':$os;

		$result = array(
				'os' => $os,
				'browser' => $browser,
				'device' => $device,
				'userip' => $uIP,
				'userAgent' => $uaStr
		);
		return $result;
	}
	public static function encryptText($plaintext){
		$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    	$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,$plaintext, MCRYPT_MODE_CBC, $iv);

	    # prepend the IV for it to be available for decryption
	    $ciphertext = $iv . $ciphertext;
	    
	    # encode the resulting cipher text so it can be represented by a string
	    return base64_encode($ciphertext);
	}

	public static function decryptText($ciphertext){
		$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
		$ciphertext_dec = base64_decode($ciphertext);

	    # retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
	    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	    $iv_dec = substr($ciphertext_dec, 0, $iv_size);
	    
	    # retrieves the cipher text (everything except the $iv_size in the front)
	    $ciphertext_dec = substr($ciphertext_dec, $iv_size);

	    # may remove 00h valued characters from end of plain text
		return mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
                                    $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
	}

	public static function getUserIP() {
		if (isset($_SERVER)) { 
			if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) 
				return $_SERVER["HTTP_X_FORWARDED_FOR"]; 
			if (isset($_SERVER["HTTP_CLIENT_IP"])) 
				return $_SERVER["HTTP_CLIENT_IP"]; 
			return $_SERVER["REMOTE_ADDR"];
		}
		if (getenv('HTTP_X_FORWARDED_FOR')) 
			return getenv('HTTP_X_FORWARDED_FOR'); 
		if (getenv('HTTP_CLIENT_IP')) 
			return getenv('HTTP_CLIENT_IP'); 
		return getenv('REMOTE_ADDR');
	}
    public function send($data,$uri) {
		$host = self::getAppValue('host', self::getAppValue('host','127.0.0.1'));
		$port = self::getAppValue('port', self::getAppValue('port','8080'));
		$host = (substr($host, -1) === '/')?substr($host,0,strlen($host)-1):$host;
		$url = $host.':'.$port.'/';


        $ch = curl_init($host);
        $res = '';
        $errno = 0;
        $error = '';
        curl_setopt($ch, CURLOPT_URL, $url.$uri);
        curl_setopt($ch, CURLOPT_PORT,$port);
        if(preg_match('/^https/', $url)>0) {
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false); 
            curl_setopt ($ch, CURLOPT_SSLVERSION, 3);
            if(defined ('DEBUG') && DEBUG===true) {
                curl_setopt ($ch, CURLOPT_CERTINFO, false);
                curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, false);
            }
        }
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, true);

        curl_setopt($ch, CURLOPT_COOKIEFILE, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->getSessionFile());
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->getSessionFile());

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // \OCP\Util::writeLog(SELF::APP_NAME, print_r($data,true), \OCP\Util::DEBUG);
        if(curl_exec($ch) && ($errno = curl_errno($ch)) === 0) {
            $res = curl_multi_getcontent($ch);

            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header = substr($res, 0, $header_size);
            $body = substr($res, $header_size);
        } else {
            $error = curl_error($ch);
            \OCP\Util::writeLog(SELF::APP_NAME, $error, \OCP\Util::ERROR);
        }
        $code = intval(curl_getinfo($ch,CURLINFO_HTTP_CODE));
        curl_close($ch);


        $resultArray = [
            'header'=>$header,
            'response'=>$body,
            'httpcode'=>$code,
            'errno'=>$errno,
            'error'=>$error
        ];
        \OCP\Util::writeLog(SELF::APP_NAME, print_r($resultArray,true), \OCP\Util::DEBUG);
        return $resultArray;
    }
}