<?php

class UserController extends Zend_Controller_Action
{
    public function loginAction()
    {
        $auth = TBS\Auth::getInstance();

        $providers = $auth->getIdentity();

        // Here the response of the providers are registered
        if ($this->_hasParam('provider')) {
            $provider = $this->_getParam('provider');

            switch ($provider) {
                case "facebook":
                    if ($this->_hasParam('code')) {
                        $adapter = new TBS\Auth\Adapter\Facebook(
                                $this->_getParam('code'));
                        $result = $auth->authenticate($adapter);
                    }
                    if($this->_hasParam('error')) {
                        throw new Zend_Controller_Action_Exception('Facebook login failed, response is: ' . 
                            $this->_getParam('error'));
                    }
                    break;
                case "twitter":
                    if ($this->_hasParam('oauth_token')) {
                        $adapter = new TBS\Auth\Adapter\Twitter($_GET);
                        $result = $auth->authenticate($adapter);
                    }
                    break;
                case "google":
                
                    if ($this->_hasParam('code')) {
                        $adapter = new TBS\Auth\Adapter\Google(
                                $this->_getParam('code'));
                        $result = $auth->authenticate($adapter);
                    }
                    if($this->_hasParam('error')) {
                        throw new Zend_Controller_Action_Exception('Google login failed, response is: ' . 
                            $this->_getParam('error'));
                    }
                    break;

            }
            // What to do when invalid
            if (isset($result) && !$result->isValid()) {
                $auth->clearIdentity($this->_getParam('provider'));
                throw new Zend_Controller_Action_Exception('Login failed');
            } else {
                $this->_redirect('/user/connect');
            }
        } else { // Normal login page
            $this->view->googleAuthUrl = TBS\Auth\Adapter\Google::getAuthorizationUrl();
            $this->view->googleAuthUrlOffline = TBS\Auth\Adapter\Google::getAuthorizationUrl(true);
            $this->view->facebookAuthUrl = TBS\Auth\Adapter\Facebook::getAuthorizationUrl();

            $this->view->twitterAuthUrl = \TBS\Auth\Adapter\Twitter::getAuthorizationUrl();
        }

    }
    public function connectAction()
    {
        $auth = TBS\Auth::getInstance();
        if (!$auth->hasIdentity()) {
            throw new Zend_Controller_Action_Exception('Not logged in!', 404);
        }
        $this->view->providers = $auth->getIdentity();
    }

    public function logoutAction()
    {
        \TBS\Auth::getInstance()->clearIdentity();
        $this->_redirect('/');
    }
}
