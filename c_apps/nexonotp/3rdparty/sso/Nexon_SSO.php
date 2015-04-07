<?php
class Nexon_SSO 
{
	var $configs = array('LIVE'=>"SSO.inc.php", 'DEV'=>"devSSO.inc.php");
	var $SERVER = 'DEV';
	
	function getSignInUrl($retUrl) {		
		require_once($this->configs[$this->SERVER]);
		
		$iso8601_time=gmstrftime("%Y%m%dT%H:%M:%S", time());
		$wtrealm = "http://".$_SERVER["HTTP_HOST"].SSOConfig::$SSO_AUTH_PATH;
		
		return SSOConfig::$SSO_CONF_FPSTS."?wa=wsignin1.0&wtrealm=$wtrealm&wctx=".urlencode("rm=0&id=passive&ru=".urlencode($retUrl))."&wct=".urlencode($iso8601_time);
	}
	function verify()
	{
		require_once($this->configs[$this->SERVER]);
		
		require_once 'CER_Validator.php';
		require_once "xmlseclibs.php";
		
		$certData = file_get_contents(SSOConfig::$CERTFILE_PATH, true);
		if($certData === FALSE)
			throw new Exception('Unable to load certificate file ');	

		CERL_Validator::ValidateCertificateFingerprint($certData, SSOConfig::$CER_FINGER_PRINT);
		
		$encdom = new DOMDocument();
		$encdom->loadXML(str_replace ("\r", "", str_replace('\"', '"',$_POST['wresult'])));
		
		$objenc = new XMLSecEnc();
		$encData = $objenc->locateEncryptedData($encdom);
		if (! $encData) {
			throw new Exception("Cannot locate Encrypted Data");
		}
		$objenc->setNode($encData);
		$objenc->type = $encData->getAttribute("Type");

		$key = NULL;
		$objKey = $objenc->locateKey();
		if ($objKey)
		{
			if ($objKeyInfo = $objenc->locateKeyInfo($objKey))
			{
				$objKeyInfo->passphrase = SSOConfig::$KEYFILE_PASS_PHRASE;

				if ($objKeyInfo->isEncrypted) {
					$objencKey = $objKeyInfo->encryptedCtx;
					$objKeyInfo->loadKey(dirname(__FILE__) .'\\'. SSOConfig::$KEYFILE_PATH, TRUE);
					$key = $objencKey->decryptKey($objKeyInfo);
				}
			}
		}
		if (empty($objKey) || empty($key))
			throw new Exception("Error loading key to handle Decryption");

		$objKey->loadKey($key);

		$wctxs = split('=',$_POST['wctx']);
		$userAttrs = array('retUrl'=>urldecode($wctxs[3]));
		if ($decrypt = $objenc->decryptNode($objKey, FALSE)) {
			$token = new DOMDocument();
			$token->loadXML($decrypt);

			$xpath = new DOMXpath($token);
			$xpath->registerNamespace('a', "http://schemas.microsoft.com/ws/2008/06/identity");
			$xmlAttrs = $xpath->query("/saml:Assertion/saml:AttributeStatement/saml:Attribute");
			foreach($xmlAttrs as $xmlAttr) {
				$attrName = $xmlAttr->attributes->getNamedItem("AttributeName")->nodeValue;
				$attrVal = $xmlAttr->firstChild->nodeValue;
				$userAttrs[$attrName] = $attrVal;
			}
			//$controller->Session->write("User", $userAttrs);
			// $_SESSION["EmpNo"] = $userAttrs["EmpNo"];
			// $_SESSION["CompanyCode"] = $userAttrs["CompanyCode"];
			// $_SESSION["EmpID"] = $userAttrs["EmpID"];
			return $userAttrs;
		}
		else
			throw new Exception("Error to decrypt data");
	}
	
	function getSignOutUrl()
	{
		// if(NEXON_DIST_ENV == 'LIVE')
			// return 'http://portal.weboffice.co.kr/ssoOut.php';
		
		require_once($this->configs[$this->SERVER]);
		$retUrl = 'http://'.$_SERVER["HTTP_HOST"].'/';
		return SSOConfig::$SSO_CONF_FPSTS.'?wa=wsignout1.0&wreply='.urlencode($retUrl);
	}
}
