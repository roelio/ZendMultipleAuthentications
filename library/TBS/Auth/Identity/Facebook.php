<?php
namespace TBS\Auth\Identity;

class Facebook extends Generic
{
	protected $_api;

	public function __construct($token)
	{
		$this->_api = new \TBS\Resource\Facebook($token);
		$this->_name = 'facebook';
		$this->_id = $this->_api->getId();
	}

	public function getApi()
	{
		return $this->_api;
	}

}