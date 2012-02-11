<?php 

App::import('Vendor', 'OAuth2Server.OAuth2', array('file' => 'oauth2-php'.DS.'lib'.DS.'OAuth2.php'));
App::uses('OAuth2ServerAccessToken', 'OAuth2Server/Model');

class OAuthWorkerComponent extends Component {
	
		
	private $controller = null;
	
	private $oauth = null;
	
	private $data = null;
	
	
	
	//called before Controller::beforeFilter()
	public function initialize($controller) {
		
		// saving the controller reference for later use
		$this->controller = $controller;
		
		configure::write('OAuth', array(
			'access_token_lifetime' => 3600 * 24 * 30
		));
		
	}
	

	public function authorize() {
		
		$this->oauth = new OAuth2($this->controller->OAuth2ServerAccessToken, configure::read('OAuth'));		
		
		$userId = $this->controller->Auth->user('id'); // Use whatever method you have for identifying users.
		$this->oauth->finishClientAuthorization($_POST["accept"] == "yes", $userId, $_POST);
		
		try {
			$auth_params = $this->oauth->getAuthorizeParams();
		} catch (OAuth2ServerException $oauthError) {
			$oauthError->sendHttpResponse();
		}
		
	}
	
	/**
	 * Get the user_id for the current access_token
	 *
	 * @return int
	 * @author Rui Cruz
	 */
	public function getUserId() {
		
		return $this->data['user_id'];
		
	}
	
	/**
	 * Check if an access_token was received and it is valid
	 *
	 * @return array
	 * @author Rui Cruz
	 */
	public function verifyToken() {
		
		try {

			$this->controller->loadModel('OAuth2Server.OAuth2ServerAccessToken');
			$this->oauth = new OAuth2($this->controller->OAuth2ServerAccessToken, configure::read('OAuth'));
			$token = $this->oauth->getBearerToken();
			$this->data = $this->oauth->verifyAccessToken($token);
			
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