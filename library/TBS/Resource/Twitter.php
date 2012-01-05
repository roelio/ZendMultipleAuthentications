<?php

namespace TBS\Resource;
class Twitter
{
	protected $_accessToken;
	protected $_options;

	public function __construct($accessToken,$options)
	{
		$this->_accessToken = $accessToken;
		$this->_options = $options;
	}

	protected function _getData($url)
	{
		$client = $this->_accessToken->getHttpClient($this->_options);
		$client->setUri($url);
		$client->setParameterGet('user_id', $this->_accessToken->user_id);
		return $client->request()->getBody();
	}

	public function getStatus() {
		return json_decode($this->_getData('http://api.twitter.com/1/statuses/user_timeline.json'));
	}

	public function getId() {
		return json_decode($this->_getData('http://api.twitter.com/1/users/show.json'))->id_str;
	}

	public function getProfile() {
		return (array)json_decode($this->_getData('http://api.twitter.com/1/users/show.json'));
	}
	
	public function getPicture() {
		return json_decode($this->_getData('http://api.twitter.com/1/users/show.json'))->profile_image_url_https;
	}

}