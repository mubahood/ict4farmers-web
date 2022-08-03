<?php
namespace AfricasTalking\SDK;


use AfricasTalking\SDK\Airtime;
use AfricasTalking\SDK\application;
use AfricasTalking\SDK\Content;
use AfricasTalking\SDK\Payments;
use AfricasTalking\SDK\SMS;
use AfricasTalking\SDK\Token;
use AfricasTalking\SDK\Voice;

abstract class Service 
{
	protected $client;

	protected $username;

	protected $apiKey;

	public function __construct($client, $username, $apiKey)
	{
		$this->client 	= $client;
		$this->username = $username;
		$this->apiKey 	= $apiKey;
	}

	protected static function error($data) {
		return [
			'status' 	=> 'error',
			'data'		=> $data
		];
	}


	protected static function success($data) {
		return [
			'status' 	=> 'success',
			'data'		=> json_decode($data->getBody()->getContents())
		];
	}
}
