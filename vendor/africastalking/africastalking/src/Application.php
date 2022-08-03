<?php

namespace AfricasTalking\SDK;
use AfricasTalking\SDK\Airtime;
use AfricasTalking\SDK\application;
use AfricasTalking\SDK\Content;
use AfricasTalking\SDK\Payments;
use AfricasTalking\SDK\Service;
use AfricasTalking\SDK\SMS;
use AfricasTalking\SDK\Token;
use AfricasTalking\SDK\Voice;

class Application extends Service
{
    public function doFetchApplication()
    {
		$response = $this->client->get('user', ['query' => ['username'=> $this->username]]);        
		return $this->success($response);
    }

    public function fetchApplicationData()
    {
        return $this->doFetchApplication();
    }
}
