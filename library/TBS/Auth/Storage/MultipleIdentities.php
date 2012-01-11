<?php
namespace TBS\Auth\Storage;
use \Zend_Session_Namespace as SessionNameSpace;

class MultipleIdentities implements \Zend_Auth_Storage_Interface
{
    const SESSION_NAMESPACE = "MultipleIdentities";

    protected $_session;

    public function __construct()
    {
        $this->_session = new SessionNameSpace(self::SESSION_NAMESPACE);
    }

    public function isEmpty($provider = null)
    {
        $container = $this->read();
        if (!$container) {
            return true;
        } else if ($container->isEmpty($provider)) {
            return true;
        } else {
            return false;
        }
    }

    public function read($provider = null)
    {
        if (!isset($this->_session->identityContainer)) {
            return false;
        } else {
            $container = unserialize($this->_session->identityContainer);
            if (null !== $provider) {
                return $container->get($provider);
            } else {
                return $container;
            }
        }
    }

    public function write($container)
    {
        if (get_class($container) !== 'TBS\Auth\Identity\Container') {
            throw new Exception('No valid identity container');
        }
        $this->_session->identityContainer = serialize($container);
    }

    public function clear($provider = null)
    {
        if (null !== $provider) {
            $container = $this->read();
            $container->remove($provider);
            $this->write($container);
        } else {
            unset($this->_session->identityContainer);
        }
    }

}
