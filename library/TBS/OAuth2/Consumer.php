<?php
namespace TBS\OAuth2;

class Consumer {
	public static function getAuthorizationUrl($urlparams)
	{
		$authparams = array();
		if(!isset($urlparams['auth_url']))
		throw new \Exception('No auth url specified');
		if(isset($urlparams['client_id']))
		$authparams['client_id'] = $urlparams['client_id'];
		if(isset($urlparams['state']))
		$authparams['state'] = $urlparams['state'];
		if(isset($urlparams['redirect_uri']))
		$authparams['redirect_uri'] = $urlparams['redirect_uri'];
		if(isset($urlparams['scope']))
		$authparams['scope'] = $urlparams['scope'];
		if(isset($urlparams['response_type']))
		$authparams['response_type'] = $urlparams['response_type'];

		$out = $urlparams['auth_url'] . '?' . http_build_query($authparams);
		return $out;
	}

	public static function getAccessToken($urlparams)
	{
		$authparams = array();
		if(!isset($urlparams['token_url']))
		throw new \Exception('No token url specified');
		if(isset($urlparams['client_id']))
		$authparams['client_id'] = $urlparams['client_id'];
		if(isset($urlparams['client_secret']))
		$authparams['client_secret'] = $urlparams['client_secret'];
		if(isset($urlparams['redirect_uri']))
		$authparams['redirect_uri'] = $urlparams['redirect_uri'];
		if(isset($urlparams['scope']))
		$authparams['scope'] = $urlparams['scope'];
		if(isset($urlparams['code']))
		$authparams['code'] = $urlparams['code'];
		if(isset($urlparams['grant_type']))
		$authparams['grant_type'] = $urlparams['grant_type'];

		$client = new \Zend_Http_Client();
		$client->setUri($urlparams['token_url']);
		$client->setParameterPost($authparams);
		$response = $client->request('POST');
		if($response->getHeader("Content-type") == "application/json") {
			return (array)json_decode($response->getBody());
		}
		else {
			$token;
			parse_str($response->getBody(),$token);
			return $token;
		}
	}

	public static function getData($url, $accesstoken, $redirects = true)
	{
		$client = new \Zend_Http_Client();
		$client->setUri($url);
		$client->setParameterGet('access_token',$accesstoken);
		if($redirects) {
			$response = $client->request('GET')->getBody();
		}
		else {
			$client->setConfig(array('maxredirects'=>0));
			$response = $client->request()->getHeader('Location');
			$client->setConfig(array('maxredirects'=>5));
		}
		return $response;
	}
}
