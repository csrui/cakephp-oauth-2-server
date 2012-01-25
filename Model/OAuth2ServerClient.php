<?php 

App::uses('OAuth2ServerModel', 'OAuth2Server.Model');

class OAuth2ServerClient extends OAuth2ServerModel {


	public $hasMany = array(
		'OAuth2ServerAuthCode',
		'OAuth2ServerAccessToken'
	);
	
}