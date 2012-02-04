<?php 

App::uses('OAuth2ServerModel', 'OAuth2Server.Model');

class OAuth2ServerClient extends OAuth2ServerModel {

	public $primaryKey = 'client_id';

	// public $hasMany = array(
	// 	'OAuth2Server.AuthCode',
	// 	'OAuth2Server.AccessToken'
	// );
	
}