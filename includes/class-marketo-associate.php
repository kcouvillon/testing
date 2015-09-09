<?php

/**
 * WS_MktoAssociateLead
 *
 * Update or insert leads into Marketo database.  From here:
 * http://developers.marketo.com/documentation/rest/associate-lead/
 */

class WS_MktoAssociateLead {
	private $host = 'https://593-ASZ-675.mktorest.com';
	private $clientId = "45c494eb-4c74-490d-917d-84e5f7e1c3b9";
	private $clientSecret = "Ih0ugeoKgeOMjAnPMyG0mrAeC73QD70U";
	public $id;//id of the lead to associate to
	public $cookie;//cookie to associate
	
	public function getData(){
		$url = $this->host . "/rest/v1/leads/" . $this->id . "/associate.json?access_token=" . $this->getToken() . "&cookie=" . $this->cookie;
		$ch = curl_init($url);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json','Content-Type: application/json'));
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