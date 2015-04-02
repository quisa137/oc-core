<?php

namespace OCA\NEXONOTP;

use \OCP\DB;
use \OCP\User;
use \OCP\Util;

class Data {
	public static function send($type,$agent){
		$timestamp = time();
		$user = User::getUser();
		$userip = Nexonotp::getUserIP();
		$userip = $userip=='::1'?'127.0.0.1':$userip;
		$query = DB::prepare('INSERT INTO *PREFIX*loginLog(`uid`,`type`,`timestamp`,`userAgent`,`userip`) VALUES (?,?,?,?,inet_aton(?))');
		$result = $query->execute(array($user, $type, $timestamp, $agent, $userip));
		if (DB::isError($result)) {
         Util::writeLog('NEXONOTP', DB::getErrorMessage($result), Util::ERROR);
		}
		return true;
	}
	public static function getlastLoginlist() {
	    $user = User::getUser();
		$query = DB::prepare('SELECT type,timestamp,userAgent,inet_ntoa(userip) as userip FROM *PREFIX*loginLog WHERE type=? and uid=? ORDER BY timestamp desc',5,0);
		$result = $query->execute(array('login', $user));
		if (DB::isError($result)) {
			Util::writeLog('NEXONOTP', DB::getErrorMessage($result), Util::ERROR);
		} else {
			return $result->fetchAll();
		}
	}
}