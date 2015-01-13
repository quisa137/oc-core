<?php
/**
 * Default strings and values which differ between the enterprise and the
 * community edition. Use the get methods to always get the right strings.
 */
class OC_Theme {

	private $theme;
	private $l;

	private $defaultEntity;
	private $defaultName;
	private $defaultTitle;
	private $defaultBaseUrl;
	private $defaultSyncClientUrl;
	private $defaultDocBaseUrl;
	private $defaultDocVersion;
	private $defaultSlogan;
	private $defaultLogoClaim;
	private $defaultMailHeaderColor;

	function __construct() {
		$version = OC_Util::getVersion();

		$this->defaultEntity = "NCDrive"; /* e.g. company name, used for footers and copyright notices */
		$this->defaultName = "NCDrive"; /* short name, used when referring to the software */
		$this->defaultTitle = "NCDrive"; /* can be a longer name, for titles */
		$this->defaultBaseUrl = "https://ncdrive.ncsoft.com";
		$this->defaultSyncClientUrl = "https://ncdrive.ncsoft.com/agent/desktop/agent_down.php";
		$this->defaultDocBaseUrl = "https://ncdrive.ncsoft.com";
		$this->defaultDocVersion = $version[0] . ".0"; // used to generate doc links
		$this->defaultSlogan = 'NCSOFT Cloud Storage';
		$this->defaultLogoClaim = "";
		$this->defaultMailHeaderColor = "#1d2d44"; /* header color of mail notifications */
	}
	/**
	 * Returns the base URL
	 * @return string URL
	 */
	public function getBaseUrl() {
		return $this->defaultBaseUrl;
	}

	/**
	 * Returns the URL where the sync clients are listed
	 * @return string URL
	 */
	public function getSyncClientUrl() {
		return $this->defaultSyncClientUrl;
	}

	/**
	 * Returns the documentation URL
	 * @return string URL
	 */
	public function getDocBaseUrl() {
		return $this->defaultDocBaseUrl;
	}

	/**
	 * Returns the title
	 * @return string title
	 */
	public function getTitle() {
		return $this->defaultTitle;
	}

	/**
	 * Returns the short name of the software
	 * @return string title
	 */
	public function getName() {
		return $this->defaultName;
	}

	/**
	 * Returns entity (e.g. company name) - used for footer, copyright
	 * @return string entity name
	 */
	public function getEntity() {
		return $this->defaultEntity;
	}

	/**
	 * Returns slogan
	 * @return string slogan
	 */
	public function getSlogan() {
		return $this->defaultSlogan;
	}

	/**
	 * Returns logo claim
	 * @return string logo claim
	 */
	public function getLogoClaim() {
		return $this->defaultLogoClaim;
	}

	/**
	 * Returns short version of the footer
	 * @return string short footer
	 */
	public function getShortFooter() {
		$footer = "<a href=\"". $this->getBaseUrl() . "\" target=\"_blank\">" .$this->getEntity() . "</a>".
				' – ' . $this->getSlogan();
		return $footer;
	}

	/**
	 * Returns long version of the footer
	 * @return string long footer
	 */
	public function getLongFooter() {
		$footer = $this->getShortFooter();

		return $footer;
	}

	public function buildDocLinkToKey($key) {
		return $this->getDocBaseUrl() . '/server/' . $this->defaultDocVersion . '/go.php?to=' . $key;
	}

	/**
	 * Returns mail header color
	 * @return string
	 */
	public function getMailHeaderColor() {
		return $this->defaultMailHeaderColor;
	}
}
