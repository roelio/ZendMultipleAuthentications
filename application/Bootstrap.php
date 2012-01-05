<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initConfig() {
		Zend_Registry::set('config', $this->getOptions());
	}

	protected function _initRoutes() {
		$front = Zend_Controller_Front::getInstance();
		$router = $front->getRouter();
		
		$route = new Zend_Controller_Router_Route (
            'login/:provider',
			array('controller' => 'user', 'action' => 'login') );

		$router->addRoute('login/:provider', $route);
		
		$route = new Zend_Controller_Router_Route_Static(
					'login',
		array('controller' => 'user', 'action' => 'login') );
		
		$router->addRoute('login', $route);
		
		$route = new Zend_Controller_Router_Route_Static(
			'logout',
			array('controller' => 'user', 'action' => 'logout') );
		$router->addRoute('logout', $route);
	}
}

