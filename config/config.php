<?php
define('DEBUG',true);
$CONFIG = array (
  'instanceid' => 'ocd9b6a106e1',
  'passwordsalt' => 'f9ad620e7072828d5388ab41796da8',
  'trusted_domains' =>
  array (
  ),
  'datadirectory' => '/home/quisa137/webRoot/owncloud/data',
  'dbtype' => 'mysql',
  'version' => '7.0.2.0',
  'dbname' => 'owncloud',
  'dbhost' => 'localhost',
  'dbtableprefix' => 'oc_',
  'dbuser' => OC_Util::decryptText('BqCevufLSOFBbl25yO1kb7SFAAjcm3BfP8H/55+e3Ks=') . "\0" . '' . "\0" . '' . "\0" . '' . "\0" . '' . "\0" . '',
  'dbpassword' => OC_Util::decryptText('fHC8DCXRJ+bU9fRAdReAV2A07emZ84kdwd+BayfDIwmqVvlCnwuLte2Ct6avjMBd') . "\0" . '' . "\0" . '',
  'installed' => true,
  'custom_csp_policy' => 'default-src \'self\'; script-src \'self\' \'unsafe-eval\' \'unsafe-inline\'; style-src \'self\' \'unsafe-inline\'; frame-src *; img-src *; font-src \'self\' data:; media-src *',
  'forcessl' => false,
  'knowledgebaseenabled' => false,
  'maxZipInputSize' => 2147483648,
  'theme' => 'NCDrive',
  'maintenance' => false,
  'appstoreenabled' => false,
  'apps_paths' =>
  array (
    0 =>
    array (
      'path' => '/home/quisa137/webRoot/owncloud/apps',
      'url' => '/apps',
      'writable' => true,
    ),
  ),
  'mail_smtpmode' => 'smtp',
  'mail_smtpname' => 'quisa137@gmail.com',
  'mail_from_address' => 'ncdrive',
  'mail_domain' => 'ncsoft.com',
  'mail_smtpauthtype' => 'LOGIN',
  'mail_smtpauth' => true,
  'mail_smtphost' => 'smtp.gmail.com',
  'mail_smtpsecure' => 'tls',
  'mail_smtppassword' => 'dpffmdktkf',
  'mail_smtpport' => '587',
  'customclient_desktop' => '/agent_down.php',
  'preview_libreoffice_path' => '/usr/bin/libreoffice',
  // 'enable_previews' => true,
  // 'preview_max_x' => 640,
  // 'preview_max_y' => 640,
  // 'preview_max_scale_factor' => 10,
);
?>