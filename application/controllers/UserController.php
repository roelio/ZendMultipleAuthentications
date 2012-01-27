<?php

class UserController extends Zend_Controller_Action
{
    public function loginAction()
    {
        $auth = TBS_Auth::getInstance();

        $providers = $auth->getIdentity();

        // Here the response of the providers are registered
        if ($this->_hasParam('provider')) {
            $provider = $this->_getParam('provider');

            switch ($provider) {
                case "facebook":
                    if ($this->_hasParam('code')) {
                        $adapter = new TBS_Auth_Adapter_Facebook(
                                $this->_getParam('code'));
                        $result = $auth->authenticate($adapter);
                    }
                    break;
                case "twitter":
                    if ($this->_hasParam('oauth_token')) {
                        $adapter = new TBS_Auth_Adapter_Twitter($_GET);
                        $result = $auth->authenticate($adapter);
                    }
                    break;
                case "google":
                    if ($this->_hasParam('code')) {
                        $adapter = new TBS_Auth_Adapter_Google(
                                $this->_getParam('code'));
                        $result = $auth->authenticate($adapter);
                    }
                    break;

            }
            // What to do when invalid
            if (!$result->isValid()) {
                $auth->clearIdentity($this->_getParam('provider'));
                throw new Exception('Error!!');
            } else {
                $this->_redirect('/user/connect');
            }
        } else { // Normal login page
            $this->view->googleAuthUrl = TBS_Auth_Adapter_Google::getAuthorizationUrl();

            $this->view->facebookAuthUrl = TBS_Auth_Adapter_Facebook::getAuthorizationUrl();

            $this->view->twitterAuthUrl = TBS_Auth_Adapter_Twitter::getAuthorizationUrl();
        }

    }
    public function connectAction()
    {
        $auth = TBS_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            throw new Zend_Controller_Action_Exception('Not logged in!', 404);
        }
        $this->view->providers = $auth->getIdentity();
    }

    public function logoutAction()
    {
        TBS_Auth::getInstance()->clearIdentity();
        $this->_redirect('/');
    }
}
