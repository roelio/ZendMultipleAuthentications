<?php
namespace TBS\Auth\Identity;

use \TBS\Resource\Twitter as Resource;

class Twitter extends Generic
{
	protected $_api;

	public function __construct($token,$options)
	{
		$this->_api = new Resource($token,$options);
		$this->_name = 'twitter';
		$this->_id = $this->_api->getId();
	}

	public function getApi()
	{
		return $this->_api;
	}
}
