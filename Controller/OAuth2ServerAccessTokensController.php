<?php 

App::uses('OAuth2ServerController', 'OAuth2Server.Controller');

class OAuth2ServerAccessTokensController extends OAuth2ServerController {
	
	public function authorize() {
		
		$this->set('auth_params', array(
	      "client_id" => $_GET['client_id'],
	      "response_type" => $_GET['response_type'],
	      "redirect_uri" => $_GET['redirect_uri'],
	      "state" => @$_GET['state'],
	      "scope" => @$_GET['scope']
		));
		
		# Fetch client information to display to the user
		if (!empty($_GET['client_id'])) {
			
			$client = $this->OAuth2ServerAccessToken->OAuth2ServerClient->read(null, $_GET['client_id']);			
			$this->set('client', $client);
			
		}
		
		# Try to authorize
		if ($this->request->is('post')) {
			$this->OAuthWorker->authorize();
		}
		
	}
	
	public function token() {
		
		$this->OAuthWorker->token();
		
	}

	
}