<?php

/**
 * WS_MktoRequestCampaign
 *
 * This API runs an existing Marketo lead in a Marketo Smart Campaign. 
 * The Smart Campaign must have a “Campaign is Requested” trigger with 
 * a Web Service API source.   From here:
 * http://developers.marketo.com/documentation/rest/request-campaign/
 */

class WS_MktoRequestCampaign extends WS_MktoAuthenticator {
	private $host = 'https://593-ASZ-675.mktorest.com';
	private $clientId = "45c494eb-4c74-490d-917d-84e5f7e1c3b9";
	private $clientSecret = "Ih0ugeoKgeOMjAnPMyG0mrAeC73QD70U";
	public $leads;//array of stdClass objects with one member, id, required
	public $tokens;//array of stdClass objects with two members, name and value

	public function postData(){
		$url = $this->host . "/rest/v1/campaigns/6227/trigger.json?access_token=" . $this->getToken(); // <----------------- WILL ID 6227 work here?
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
		if (isset($this->leads)){ 		// sample code used 'tokens' - not used here
			$body->input = new stdClass();
			$body->input->leads = $this->leads;//  using 'leads' instead
		}
		$json = json_encode($body);
		return $json;
	}
}
