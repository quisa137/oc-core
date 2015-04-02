<?php
$tmpl = new \OCP\Template('nexonotp', 'agree');
$tmpl->assign('content',\OCA\NEXONOTP\Nexonotp::getAppValue('content',''));
$tmpl->assign('buttonsDisplay', true);
$tmpl->printPage();
?>