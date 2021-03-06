<?php

App::uses('OAuth2ServerModel', 'OAuth2Server.Model');

class OAuth2ServerAccessToken extends OAuth2ServerModel {
		
	
	public $primaryKey = 'oauth_token';
	
	public $belongsTo = array(
		'OAuth2ServerClient' => array(
			'className' => 'OAuth2Server.OAuth2ServerClient'
		)
	);
		
}