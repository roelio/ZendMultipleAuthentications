<?php
namespace TBS\Auth\Identity;

class Generic
{
	protected $_id;
	protected $_name;

	public function __construct($name, $id)
	{
		$this->_name = $name;
		$this->_id = $id;
	}

	public function getName()
	{
		return $this->_name;
	}

	public function getId()
	{
		return $this->_id;
	}
}
