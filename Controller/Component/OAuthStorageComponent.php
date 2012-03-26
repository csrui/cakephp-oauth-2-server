<?php 

App::import('Vendor', 'OAuth2Server.IOAuth2Storage', array('file' => 'oauth2-php'.DS.'lib'.DS.'IOAuth2Storage.php'));
App::import('Vendor', 'OAuth2Server.IOAuth2GrantCode', array('file' => 'oauth2-php'.DS.'lib'.DS.'IOAuth2GrantCode.php'));
App::import('Vendor', 'OAuth2Server.IOAuth2RefreshTokens', array('file' => 'oauth2-php'.DS.'lib'.DS.'IOAuth2Refreshtokens.php'));

App::uses('OAuth2ServerClient', 'OAuth2Server.Model');
App::uses('OAuth2ServerAuthCode', 'OAuth2Server.Model');
App::uses('OAuth2ServerAccessToken', 'OAuth2Server.Model');

class OAuthStorageComponent extends Component implements IOAuth2Storage, IOAuth2GrantCode { //, IOAuth2RefreshTokens  {
	

	public function setAuthCode($code, $client_id, $user_id, $redirect_uri, $expires, $scope = NULL) {
		
		$OAuth2ServerAuthCode = new OAuth2ServerAuthCode();
		
		$data = compact('code', 'client_id', 'user_id', 'redirect_uri', 'expires', 'scope');
		
		$OAuth2ServerAuthCode->save($data);
		
	}
	
	public function getAuthCode($code) {
		
		try {
			
			$OAuth2ServerAuthCode = new OAuth2ServerAuthCode();
			$result = $OAuth2ServerAuthCode->read(null, $code);
			
			if (empty($result)) {
				return false;
			}
			
			return $result['OAuth2ServerAuthCode'];
			
		} catch (PDOException $e) {
			$this->handleException($e);
		}
		
	}
	
	
	public function checkClientCredentials($client_id, $client_secret = NULL) {
		
		$OAuth2ServerClient = new OAuth2ServerClient();
		$result = $OAuth2ServerClient->read(array('client_secret'), $client_id);
		
		if (empty($result)) {
			return false;
		}
		
		return $this->checkPassword($client_secret, $result['OAuth2ServerClient']['client_secret'], $client_id);

	}
	
	public function checkRestrictedGrantType($client_id, $grant_type) {
		return TRUE; // Not implemented
	}
	
	public function getAccessToken($oauth_token) {

		$OAuth2ServerAccessToken = new OAuth2ServerAccessToken();
		
		$result = $OAuth2ServerAccessToken->read(null, $oauth_token);
		
		return $result['OAuth2ServerAccessToken'];
		
	}
	
	public function SetAccessToken($oauth_token, $client_id, $user_id, $expires, $scope = null) {
		
		$OAuth2ServerAccessToken = new OAuth2ServerAccessToken();
		
		$data = compact('oauth_token', 'client_id', 'user_id', 'expires', 'scope');
		
		$OAuth2ServerAccessToken->save($data);
		
	}

	public function getClientDetails($client_id) {
		
		$OAuth2ServerClient = new OAuth2ServerClient();
		
		$result = $OAuth2ServerClient->read(null, $client_id);
		
		return $result['OAuth2ServerClient'];
		
	}
	
	
	
	/**
	 * Change/override this to whatever your own password hashing method is.
	 * 
	 * In production you might want to a client-specific salt to this function. 
	 * 
	 * @param string $secret
	 * @return string
	 */
	protected function hash($client_secret, $client_id) {
		return Security::hash($client_id . $client_secret);
	}

	protected function checkPassword($client_secret, $try, $client_id) {		
		return $try == $client_secret;
	}
	

	public function addClient($client_id, $client_secret, $redirect_uri) {

		try {

			$client_secret = $this->hash($client_secret, $client_id);
			
			$data = compact('client_id', 'client_secret', 'redirect_uri');
			
			$OAuth2ServerClient = new OAuth2ServerClient();
			return $OAuth2ServerClient->save($data);
			
		} catch (PDOException $e) {
			$this->handleException($e);
		}
	}	
	
}