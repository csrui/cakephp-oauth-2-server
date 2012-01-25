<?php 

App::uses('OAuth2ServerController', 'OAuth2Server.Controller');

class OAuth2ServerAccessTokensController extends OAuth2ServerController {
	
	
	
	public function index() {
		
		debug($this->OAuth2ServerAccessToken->read(null, 'xpto'));
		
	}
	
}