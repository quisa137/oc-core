<?php
namespace OCA\NEXONOTP;

\OCP\JSON::checkLoggedIn();
\OCP\JSON::checkAppEnabled('nexonotp');
\OCP\JSON::callCheck();

Nexonotp::setUserReaded();
if(Nexonotp::isUserReaded()) {
	\OCP\JSON::success(array('data'=>array('message' => Nexonotp::getL10n()->t('Saved'))));
} else {
	\OCP\JSON::error(array('data'=>array('message' => 'error')));
}
?>