<?php 

App::import('Vendor', 'OAuth2Server.OAuth2', array('file' => 'oauth2-php'.DS.'lib'.DS.'OAuth2.php'));
App::uses('OAuth2ServerAccessToken', 'OAuth2Server/Model');

class OAuthWorkerComponent extends Component {
	
		
	private $controller = null;
	
	private $oauth = null;
	
	//called before Controller::beforeFilter()
	public function initialize($controller) {
		
		// saving the controller reference for later use
		$this->controller = $controller;
		
	}
	

	public function authorize() {
		
		$this->oauth = new OAuth2($this->controller->OAuth2ServerAccessToken);		
		
		$userId = $this->controller->Auth->user('id'); // Use whatever method you have for identifying users.
		$this->oauth->finishClientAuthorization($_POST["accept"] == "yes", $userId, $_POST);
		
		try {
			$auth_params = $this->oauth->getAuthorizeParams();
		} catch (OAuth2ServerException $oauthError) {
			$oauthError->sendHttpResponse();
		}
		
	}
	
	
	public function getCurrentUserId() {
		
		try {
			
			$this->controller->loadModel('OAuth2Server.OAuth2ServerAccessToken');
			$this->oauth = new OAuth2($this->controller->OAuth2ServerAccessToken);
			$token = $this->oauth->getBearerToken();
			$data = $this->oauth->verifyAccessToken($token);
			
			return $data['user_id'];
			
		} catch (OAuth2ServerException $oauthError) {
			$oauthError->sendHttpResponse();
		}
		
	}
	
	public function token() {
		
		die(__FUNCTION__);
		
		try {
			$this->oauth->grantAccessToken();
		} catch (OAuth2ServerException $oauthError) {
			$oauthError->sendHttpResponse();
		}		
		
	}
	
}