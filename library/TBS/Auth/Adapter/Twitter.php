<?php
namespace TBS\Auth\Adapter;
use \TBS\Auth\Identity\Twitter as Identity;

use \Zend_Oauth_Consumer as Consumer;
use \Zend_Auth_Result as Result;
use \Zend_Session_Namespace as SessionNameSpace;
use \Zend_Registry as Registry;

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
        $this->_consumer = new Consumer($this->_options);
        $this->_setRequestToken($params);
    }

    public function authenticate()
    {
        $result = array();
        $result['code'] = Result::FAILURE;
        $result['identity'] = NULL;
        $result['messages'] = array();

        $data = array('tokens' => array('access_token' => $this->_accessToken));

        $identity = new Identity($this->_accessToken, $this->_options);
        $result['code'] = Result::SUCCESS;
        $result['identity'] = $identity;

        return new Result($result['code'], $result['identity'],
                          $result['messages']);
    }

    public static function getAuthorizationUrl()
    {
        $options = Registry::get('config');
        $consumer = new Consumer($options['twitter']);
        $token = $consumer->getRequestToken();
        $twitterToken = new SessionNamespace('twitterToken');
        $twitterToken->rt = serialize($token);
        return $consumer->getRedirectUrl(null, $token);
    }

    protected function _setOptions($options = null)
    {
        $options = Registry::get('config');
        $this->_options = $options['twitter'];
    }

    protected function _setRequestToken($params)
    {
        $twitterToken = new SessionNameSpace('twitterToken');
        $token = unserialize($twitterToken->rt);
        $accesstoken = $this->_consumer->getAccessToken($params, $token);
        unset($twitterToken->rt);
        $this->_accessToken = $accesstoken;
    }
}
