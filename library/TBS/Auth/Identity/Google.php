<?php
namespace TBS\Auth\Identity;

class Google extends Generic
{
   protected $_userData;
 
   public function __construct($userData)
   {
      $this->_userData = $userData;
      $this->_name = 'google';
      $this->_id = $userData['id'];
   }
 
   public function getUserData()
   {
      return $this->_userData;
   }
 
}