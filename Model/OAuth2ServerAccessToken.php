<?php

App::import('Vendor', 'OAuth2Server.IOAuth2Storage', array('file' => 'oauth2-php'.DS.'lib'.DS.'IOAuth2Storage.php'));
App::import('Vendor', 'OAuth2Server.IOAuth2GrantCode', array('file' => 'oauth2-php'.DS.'lib'.DS.'IOAuth2GrantImplicit.php'));

App::uses('OAuth2ServerModel', 'OAuth2Server.Model');

class OAuth2ServerAccessToken extends OAuth2ServerModel implements IOAuth2Storage, IOAuth2GrantImplicit {
		
	
	public $primaryKey = 'oauth_token';
	
	public $belongsTo = array(
		'OAuth2ServerClient' => array(
			'className' => 'OAuth2Server.OAuth2ServerClient'
		)
	);
	
	
	
	public function getAccessToken($oauth_token) {
		
		$result = $this->read(null, $oauth_token);
		
		return $result[$this->alias];
		
	}
	
	public function SetAccessToken($oauth_token, $client_id, $user_id, $expires, $scope = null) {

		$data = compact('oauth_token', 'client_id', 'user_id', 'expires', 'scope');
		
		$this->save($data);
		
	}
	
	
	public function checkRestrictedGrantType($client_id, $grant_type) {
		return true; // NOT IMPLEMENTED
	}
	
	// protected function setToken($token, $client_id, $user_id, $expires, $scope) {
	// 	
	// 	
	// 	
	// }
	// 
	// protected function getToken($token) {
	// 	
	// 	
	// }
	
	public function checkClientCredentials($client_id, $client_secret = null) {
		
		die(__FUNCTION__);		
		
	}
	
	public function getClientDetails($client_id) {
		
		$result = $this->OAuth2ServerClient->read(null, $client_id);
		
		return $result['OAuth2ServerClient'];
		
	}
	
}