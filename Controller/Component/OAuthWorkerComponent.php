<?php 

App::import('Vendor', 'OAuth2Server.OAuth2', array('file' => 'oauth2-php'.DS.'lib'.DS.'OAuth2.php'));



App::uses('OAuth2ServerAccessToken', 'OAuth2Server/Model');

class OAuthWorkerComponent extends Component {
	
	public $components = array('OAuth2Server.OAuthStorage');
	
		
	private $controller = null;
	
	private $oauth = null;
	
	private $data = null;
	
	private $user = null;
	
	
	
	//called before Controller::beforeFilter()
	public function initialize($controller) {
		
		// saving the controller reference for later use
		$this->controller = $controller;
		
		configure::write('OAuth', array(
			'access_token_lifetime' => 3600 * 24 * 30
		));
		
	}
	

	public function authorize() {
		
		$this->oauth = new OAuth2($this->OAuthStorage, configure::read('OAuth'));		
		
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

		if (isset($this->data['user_id'])) return $this->data['user_id'];

		if ($this->controller->Auth->user('id')) return $this->controller->Auth->user('id');
		
		return false;
		
	}
	
	/**
	 * Gets all the user data
	 *
	 * @return void
	 * @author Rui Cruz
	 */
	public function getUserData() {
		
		if (!empty($this->user)) return $this->user;
		
		# Let's fetch the user
		$user_id = $this->getUserId();
		
		$this->controller->loadModel('User', $this->getUserId());
		$this->user = $this->controller->User->read();
		
		return $this->user;
		
	}
	
	/**
	 * Check if an access_token was received and it is valid
	 *
	 * @return array
	 * @author Rui Cruz
	 */
	public function verifyToken() {
		
		try {

			$this->oauth = new OAuth2($this->OAuthStorage, configure::read('OAuth'));
			
			$token = $this->oauth->getBearerToken();
			$this->data = $this->oauth->verifyAccessToken($token);
			
		} catch (OAuth2ServerException $oauthError) {
			$oauthError->sendHttpResponse();
		}		
		
	}
	
	public function token() {
				
		try {
			
			$this->oauth = new OAuth2($this->OAuthStorage, configure::read('OAuth'));
			$this->oauth->grantAccessToken();
		} catch (OAuth2ServerException $oauthError) {
			$oauthError->sendHttpResponse();
		}		
		
	}
	
}