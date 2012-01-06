<?php
namespace TBS\Auth\Adapter;


class Facebook implements \Zend_Auth_Adapter_Interface
{
   protected $_accessToken;
   protected $_requestToken;
   protected $_options;
 
   public function __construct($requestToken)
   {
      $this->_setOptions();
      $this->_setRequestToken($requestToken);
   }
 
   public function authenticate()
   {
      $result = array();
      $result['code'] = \Zend_Auth_Result::FAILURE;
      $result['identity'] = NULL;
      $result['messages'] = array();
 
      if(!array_key_exists('error',$this->_accessToken)) {
         $result['code'] = \Zend_Auth_Result::SUCCESS;
         $result['identity'] = new \TBS\Auth\Identity\Facebook($this->_accessToken);
      }
 
      return new \Zend_Auth_Result($result['code'],
                                  $result['identity'],
                                  $result['messages']);
   }
 
   public static function getAuthorizationUrl()
   {
      $options = \Zend_Registry::get('config');
      return \TBS\OAuth2\Consumer::getAuthorizationUrl($options['facebook']);
   }
 
   protected function _setRequestToken($requestToken)
   {
      $this->_options['code'] = $requestToken;
 
      $accesstoken = \TBS\OAuth2\Consumer::getAccessToken($this->_options);
 
      $accesstoken['timestamp'] = time();
      $this->_accessToken = $accesstoken;
   }
 
   protected function _setOptions($options = null)
   {
      $options = \Zend_Registry::get('config');
      $this->_options = $options['facebook'];
   }
 
}