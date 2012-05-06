<?php

App::uses('OAuth2ServerModel', 'OAuth2Server.Model');

class OAuth2ServerAuthCode extends OAuth2ServerModel {
		
	public $primaryKey = 'code';
	
	public $belongsTo = array(
		'OAuth2ServerClient' => array(
			'className' => 'OAuth2Server.OAuth2ServerClient'
		)
	);
	
}
