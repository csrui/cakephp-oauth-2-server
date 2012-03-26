<?php 

App::uses('OAuth2ServerController', 'OAuth2Server.Controller');

class OAuth2ServerClientsController extends OAuth2ServerController {
	
	
	public function index() {
		
		$clients = $this->OAuth2ServerClient->findAllByUserId($this->Auth->user('id'));
		
		$this->set('clients', $clients);
		
	}
	
	public function view($client_id) {
		
		$client = $this->OAuth2ServerClient->read(null, $client_id);
		
		if ($client['OAuth2ServerClient']['user_id'] != $this->Auth->user('id')) {
			
			$this->redirect(array('action' => 'index'));
			
		}
			
		$this->set('client', $client);
		
	}
	
	public function add() {
			
		if (!empty($this->data)) {
			
			$this->OAuth2ServerClient->set($this->data);
			if ($this->OAuth2ServerClient->validates()) {
				
				try {
					
					// Generate some strings
					$client_id = substr(Security::hash($this->data['OAuth2ServerClient']['name'].$this->data['OAuth2ServerClient']['redirect_uri']), 0, 20);
					$client_secret = Security::hash($client_id . time());
					
					$user_id = $this->Auth->user('id');

					$data = array_merge($this->data['OAuth2ServerClient'], compact('client_id', 'client_secret', 'user_id'));

					if ($this->OAuth2ServerClient->save($data)) {
						$this->Session->setFlash(__('OAuth consumer created'));
						$this->redirect(array('action' => 'index'));
					}
					
				} catch (Exception $e) {

					$this->log($e);
					
				}
				
			}
			
		}
		
		// $this->OAuthWorker->OAuthStorage->addClient('xxx', 'secret', 'http://importer.planamatch.dev');
		// $this->OAuthWorker->OAuthStorage->addClient('blahblah', 'xpto', 'http://venues.planamatch.dev/authorize');
		
	}
	
	public function delete($id) {
		
		try {
			
			$client = $this->OAuth2ServerClient->read(null, $id);
			
			if ($client['OAuth2ServerClient']['user_id'] == $this->Auth->user('id')) {
				
				$this->OAuth2ServerClient->delete($id);
				$this->Session->setFlash(__('Consumer removed successfully'));
				$this->redirect(array('action' => 'index'));
				
			}
			
		} catch (Exception $e) {
			
		}
		
		$this->redirect(array('action' => 'index'));
		
	}
	
}