<?php
namespace TBS\Auth\Adapter;


class Twitter implements \Zend_Auth_Adapter_Interface
{
	protected $_accessToken;
	protected $_requestToken;
	protected $_params;
	protected $_options;
	protected $_consumer;

	public function __construct($params)
	{
		$this->_setOptions();
		$this->_consumer = new \Zend_Oauth_Consumer($this->_options);
		$this->_setRequestToken($params);
	}

	public function authenticate()
	{
		$result = array();
		$result['code'] = \Zend_Auth_Result::FAILURE;
		$result['identity'] = NULL;
		$result['messages'] = array();

		$data = array('tokens' => array('access_token' =>$this->_accessToken));

		$identity = new \TBS\Auth\Identity\Twitter($this->_accessToken,$this->_options);
		$result['code'] = \Zend_Auth_Result::SUCCESS;
		$result['identity'] = $identity;

		return new \Zend_Auth_Result($result['code'],
		$result['identity'],
		$result['messages']);
	}

	public static function getAuthorizationUrl()
	{
		$options = \Zend_Registry::get('config');
		$consumer = new \Zend_Oauth_Consumer($options['twitter']);
		$token = $consumer->getRequestToken();
		$twitterToken = new \Zend_Session_Namespace('twitterToken');
		$twitterToken->rt = serialize($token);
		return $consumer->getRedirectUrl(null,$token);
	}

	protected function _setOptions($options = null)
	{
		$options = \Zend_Registry::get('config');
		$this->_options = $options['twitter'];
	}

	protected function _setRequestToken($params)
	{
		$twitterToken = new \Zend_Session_Namespace('twitterToken');
		$token = unserialize($twitterToken->rt);
		$accesstoken = $this->_consumer->getAccessToken($params, $token);
		unset($twitterToken->rt);
		$this->_accessToken = $accesstoken;
	}

}