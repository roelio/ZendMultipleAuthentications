<?php
namespace TBS\Resource;

class Google
{
	protected $_accessToken;

	protected $profile;
	 
	public function __construct($accessToken)
	{
		$this->_accessToken = $accessToken;
	}

	protected function _getData($url, $redirects = true)
	{
		return \TBS\OAuth2\Consumer::getData($url, $this->_accessToken['access_token'], $redirects);
	}

	public function getId() {
		if(NULL===$this->profile) $this->getProfile();
		return $this->profile['id'];
	}
	 
	public function getProfile() {
		if(NULL===$this->profile)
			$this->profile = (array)json_decode($this->_getData('https://www.googleapis.com/oauth2/v1/userinfo'));
		return $this->profile;
	}


}