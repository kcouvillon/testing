<?php

/**
 * WS_MktoAuthenticator
 *
 * Abstract prototype for classes that need authentication for Marketo
 */

class WS_MktoAuthenticator {
	protected $host = 'https://593-ASZ-675.mktorest.com';
	protected $clientId = "45c494eb-4c74-490d-917d-84e5f7e1c3b9";
	protected $clientSecret = "Ih0ugeoKgeOMjAnPMyG0mrAeC73QD70U";

	protected function getToken(){
		$ch = curl_init($this->host . "/identity/oauth/token?grant_type=client_credentials&client_id=" . $this->clientId . "&client_secret=" . $this->clientSecret);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json',));
		$response = json_decode(curl_exec($ch));
		curl_close($ch);
		$token = $response->access_token;
		return $token;
	}

	protected static function csvString($fields){
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
