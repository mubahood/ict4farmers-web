<?php

namespace AfricasTalking\SDK;


use AfricasTalking\SDK\Airtime;
use AfricasTalking\SDK\application;
use AfricasTalking\SDK\Content;
use AfricasTalking\SDK\Payments;
use AfricasTalking\SDK\Service;
use AfricasTalking\SDK\SMS;
use AfricasTalking\SDK\Voice;


class Token extends Service
{
    public function createCheckoutToken($options)
    {
        if (!isset($options['phoneNumber'])) {
            return $this->error('phoneNumber must be provided');
        }

        $requestData = [
            'username' => $this->username,
            'phoneNumber' => $options['phoneNumber']
        ];

		$response = $this->client->post('checkout/token/create', ['form_params' => $requestData]);
		return $this->success($response);
    }

    public function generateAuthToken()
    {
        $requestData = json_encode(['username' => $this->username]);
		$response = $this->client->post('auth-token/generate', ['body' => $requestData ] );
		return $this->success($response);
    }
}
