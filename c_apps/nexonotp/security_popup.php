<?php
$appId = 'nexonotp';
$appPath = str_replace(basename(__FILE__),'',str_replace($_SERVER['DOCUMENT_ROOT'], '',  realpath(__FILE__)));
$tmpl = new \OCP\Template('sbotp', 'agree');
$tmpl->assign('buttonsDisplay', false);
$tmpl->assign('appPath', $appPath);
$tmpl->assign('content',\OCA\NEXONOTP\Nexonotp::getAppValue('content',''));
$tmpl->assign('currentUser', OC_User::getUser());
$tmpl->printPage();
?>