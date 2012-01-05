<?php
namespace TBS\Resource;

class Facebook
{
   protected $_accessToken;
 
   public function __construct($accessToken)
   {
      $this->_accessToken = $accessToken;
   }
 
   protected function _getData($url, $redirects = true)
   {
      return \TBS\OAuth2\Consumer::getData($url, $this->_accessToken['access_token'], $redirects);
   }
 
   public function getId() {
      return json_decode($this->_getData('https://graph.facebook.com/me?fields=id'))->id;
   }
 
   public function getProfile() {
      return (array)json_decode($this->_getData('https://graph.facebook.com/me'));
   }
 
   public function getFriends() {
      return json_decode($this->_getData('https://graph.facebook.com/me/friends'))->data;
   }
 
   public function getPicture($large = false) {
      if(!$large)
      return $this->_getData('https://graph.facebook.com/me/picture', false);
      else
      return $this->_getData('https://graph.facebook.com/me/picture?type=large', false);
   }
 
}