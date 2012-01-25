<?php

App::import('Vendor', 'OAuth2Server.IOAuth2Storage', array('file' => 'oauth2-php'.DS.'lib'.DS.'IOAuth2Storage.php'));

App::uses('OAuth2ServerModel', 'OAuth2Server.Model');

class OAuth2ServerAccessToken extends OAuth2ServerModel implements IOAuth2Storage {
		
	
	public $primaryKey = 'oauth_token';
	
	public $belongsTo = array(
		'OAuth2ServerClient'
	);
	
	
	
	public function getAccessToken($oauth_token) {
		
		
	}
	
	public function SetAccessToken($oauth_token, $client_id, $user_id, $expires, $scope = null) {
		
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
		
		
		
	}
	
	public function getClientDetails($client_id) {
		
		
	}
	
}