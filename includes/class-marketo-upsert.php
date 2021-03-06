<?php

/**
 * WS_MktoUpsertLeads
 *
 * Update or insert leads into Marketo database.  From here:
 * http://developers.marketo.com/documentation/rest/createupdate-leads/
 */
 
class WS_MktoUpsertLeads extends WS_MktoAuthenticator {
	// private $host = ''; // defined in Authenticator
	// private $clientId = "";
	// private $clientSecret = "";
	public $input; //an array of lead records as objects
	public $lookupField; //field used for deduplication
	public $action; //operation type, createOnly, updateOnly, createOrUpdate, createDuplicate
	
	public function postData(){
		$url = $this->host . "/rest/v1/leads.json?access_token=" . $this->getToken();
		$ch = curl_init($url);
		$requestBody = $this->bodyBuilder();
		print_r($requestBody);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json','Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
		curl_getinfo($ch);
		$response = curl_exec($ch);
		return $response;
	}
	
	private function bodyBuilder(){
		$body = new stdClass();
		if (isset($this->action)){
			$body->action = $this->action;
		}
		if (isset($this->lookupField)){
			$body->lookupField = $this->lookupField;
		}
		$body->input = $this->input;
		$json = json_encode($body);
		return $json;
	}

}