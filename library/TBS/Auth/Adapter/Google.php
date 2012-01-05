<?php
namespace TBS\Auth\Adapter;

class Google implements \Zend_Auth_Adapter_Interface
{
	protected $_openIdAdapter;
	protected $_userdata;
	protected $_id;
	protected $_options;

	public function __construct($params = null)
	{
		$this->_setOptions();
		if(null === $params) {
			$this->_openIdAdapter = new \Zend_Auth_Adapter_OpenId($this->_options['authurl']);
		}
		if(is_array($params)) {
			$this->_openIdAdapter = new \Zend_Auth_Adapter_OpenId();
			$userdata = array();
			$userdata['id'] = $params['openid_identity'];
			$userdata['email'] = $params['openid_ext1_value_email'];
			$userdata['firstname'] = $params['openid_ext1_value_firstname'];
			$userdata['lastname'] = $params['openid_ext1_value_lastname'];
			$userdata['language'] = $params['openid_ext1_value_language'];
			$this->_userdata = $userdata;
		}

	}

	public function authenticate()
	{
		$openIdResult = $this->_openIdAdapter->authenticate();

		$result['code'] = $openIdResult->getCode();
		$result['messages'] = $openIdResult->getMessages();

		$result['identity'] = new \TBS\Auth\Identity\Google($this->_userdata);

		return new \Zend_Auth_Result($result['code'],
		$result['identity'],
		$result['messages']);
	}

	public static function getAuthorizationUrl()
	{
		$options = \Zend_Registry::get('config');
		return $options['google']['loginurl'];
	}

	protected function _setOptions($options = null)
	{
		$options = \Zend_Registry::get('config');
		$this->_options = $options['google'];
	}

}