<?php

/**
 * WS_MktoUpsertLeads
 *
 * Update or insert leads into Marketo database.  From here:
 * http://developers.marketo.com/documentation/rest/createupdate-leads/
 */

class WS_MktoUpsertLeads {
	private $host = 'https://' . WS_Marketo::marketo_id() . '.mktorest.com';
	private $clientId = "45c494eb-4c74-490d-917d-84e5f7e1c3b9";
	private $clientSecret = "Ih0ugeoKgeOMjAnPMyG0mrAeC73QD70U";
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
	
	private function getToken(){
		$ch = curl_init($this->host . "/identity/oauth/token?grant_type=client_credentials&client_id=" . $this->clientId . "&client_secret=" . $this->clientSecret);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json',));
		$response = json_decode(curl_exec($ch));
		curl_close($ch);
		$token = $response->access_token;
		return $token;
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
	private static function csvString($fields){
		$csvString = "";
		$i = 0;
		foreach($fields as $field){
			if ($i > 0){
				$csvString = $csvString . "," . $field;
			}elseif ($i === 0){
				$csvString = $field;
			}
		}
		return $csvString;
	}
}