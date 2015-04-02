<?php

namespace OCA\NEXONOTP;

$appId = 'nexonotp';
\OCP\Util::addStyle($appId,'personal');
$tmpl = new \OCP\Template($appId, 'personal');

$tmpl->assign('list_array', Data::getlastLoginlist());

return $tmpl->fetchPage();
