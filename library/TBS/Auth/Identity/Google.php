<?php
namespace TBS\Auth\Identity;

class Google extends Generic
{
   protected $_api;
 
   public function __construct($token)
   {
		$this->_api = new \TBS\Resource\Google($token);
		$this->_name = 'google';
		$this->_id = $this->_api->getId();
   }
 
	public function getApi()
	{
		return $this->_api;
	}
 
}