<?php
namespace TBS\Auth\Identity;

class Twitter extends Generic
{
	protected $_api;

	public function __construct($token,$options)
	{
		$this->_api = new \TBS\Resource\Twitter($token,$options);
		$this->_name = 'twitter';
		$this->_id = $this->_api->getId();
	}

	public function getApi()
	{
		return $this->_api;
	}

}