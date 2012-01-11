<?php
namespace TBS\Auth\Identity;

class Container implements \Iterator
{
	protected $_identities = array();
	protected $_exists = true;

	public function getSize()
	{
		return sizeof($this->_identities);
	}

	public function isEmpty($provider = null)
	{
		if(empty($this->_identities)) return true;
		if(null !== $provider) {
			return !$this->has($provider);
		}
		return false;
	}

	public function add(Generic $identity)
	{
		$this->_identities[$identity->getName()] = $identity;
	}

	public function remove($name)
	{
		if($this->has($name)) {
			unset($this->_identities[$name]);
		}
	}

	public function get($name)
	{
		if(!$this->has($name)) {
			return false;
		}
		return $this->_identities[$name];
	}

	public function has($name)
	{
		return isset($this->_identities[$name]);
	}

	// Iterator functions
	public function current()
	{
		return current($this->_identities);
	}

	public function key()
	{
		return key($this->_identities);
	}

	public function next()
	{
		next($this->_identities);
	}

	public function rewind()
	{
		reset($this->_identities);
	}

	public function valid()
	{
		if(false === $this->current()) return false;
		else return true;
	}
}
