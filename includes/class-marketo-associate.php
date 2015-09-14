<?php

/**
 * WS_MktoAssociateLead
 *
 * Associate cookie with a lead in the Marketo database.  From here:
 * http://developers.marketo.com/documentation/rest/associate-lead/
 */

class WS_MktoAssociateLead extends WS_MktoAuthenticator {
	// private $host = ''; // defined in Authenticator
	// private $clientId = "";
	// private $clientSecret = "";
	public $id;//id of the lead to associate to
	public $cookie;//cookie to associate
	
	public function __construct($new_id,$new_cookie) {
		$this->id = $new_id;
		$this->cookie = $new_cookie;
	}

	public function getData(){
		$url = $this->host . "/rest/v1/leads/" . $this->id . "/associate.json?access_token=" . $this->getToken() . "&cookie=" . $this->cookie;

		$ch = curl_init($url);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json','Content-Type: application/json'));
		$response = curl_exec($ch);
		return $response;
	}
	
}