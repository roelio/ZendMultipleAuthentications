<?php
namespace TBS; 

/**
 * 
 * This class is almost an identical copy of the Zend_Auth class.
 * Their are a few things different which are commented on.
 * 
 * @author Roel Obdam
 *
 */
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
 
   // The default storage is the MultipleIdenties class
   public function getStorage()
   {
      if (NULL === $this->_storage) {
         $this->setStorage(new Auth\Storage\MultipleIdentities());
      }
 
      return $this->_storage;
   }
 
   /**
    * 
    * This function doesn't delete the identity information but adds the new 
    * identity to the storage. This function only works with adapters that 
    * create a Generic identity.
    * 
    * @param \Zend_Auth_Adapter_Interface $adapter
    * @throws Exception
    */
   public function authenticate(\Zend_Auth_Adapter_Interface $adapter)
   {
      $result = $adapter->authenticate();
 
      if(get_class($result->getIdentity()) !== 'TBS\Auth\Identity\Generic' &&
         !is_subclass_of($result->getIdentity(), 'TBS\Auth\Identity\Generic')) {
         throw new \Exception('Not a valid identity');
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
 
   // The three functions below accept the provider parameter so that a 
   // specific identity can be retreived or removed.
   
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
