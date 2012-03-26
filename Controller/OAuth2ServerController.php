<?php

App::uses('AppController', 'Controller');

class OAuth2ServerController extends AppController {
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->Auth->deny();
		$this->Auth->allow('access_token');
		
	}
	
}