<?php
namespace TBS; 

class Auth
{
   protected static $_instance = null;
   protected $_storage = null;
 
   public static function getInstance()
   {
      if (null === self::$_instance) {
         self::$_instance = new self();
      }
 
      return self::$_instance;
   }
 
   protected function __construct()
   {}
 
   protected function __clone()
   {}
 
   public function setStorage(\Zend_Auth_Storage_Interface $storage)
   {
      $this->_storage = $storage;
      return $this;
   }
 
   public function getStorage()
   {
      if (NULL === $this->_storage) {
//          require_once 'TBS/Auth/Storage/MultipleIdentities.php';
         $this->setStorage(new Auth\Storage\MultipleIdentities());
      }
 
      return $this->_storage;
   }
 
   public function authenticate(\Zend_Auth_Adapter_Interface $adapter)
   {
      $result = $adapter->authenticate();
 
      if(get_class($result->getIdentity()) !== 'TBS\Auth\Identity\Generic' &&
         !is_subclass_of($result->getIdentity(), 'TBS\Auth\Identity\Generic')) {
         throw new Exception('Not a valid identity');
      }
 
      $currentIdentity = $this->getIdentity();
 
      if(get_class($currentIdentity) !== 'TBS\Auth\Identity\Container') {
         $currentIdentity = new Auth\Identity\Container();
      }
      $currentIdentity->add($result->getIdentity());
 
      if ($this->hasIdentity()) {
         $this->clearIdentity();
      }
 
      if ($result->isValid()) {
         $this->getStorage()->write($currentIdentity);
      }
 
      return $result;
   }
 
   public function hasIdentity($provider = null)
   {
      return !$this->getStorage()->isEmpty($provider);
   }
 
   public function getIdentity($provider = null)
   {
      $storage = $this->getStorage();
 
      if ($storage->isEmpty($provider)) {
         return false;
      }
      return $storage->read($provider);
   }
 
   public function clearIdentity($provider = null)
   {
      $this->getStorage()->clear($provider);
   }
 
 
}