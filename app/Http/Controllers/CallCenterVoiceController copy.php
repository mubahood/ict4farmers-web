<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AfricasTalking\SDK\AfricasTalking;
use App\Models\Configuration;
use PhpOption\None;


class CallCenterVoiceController extends Controller
{
    public function voice(Request $request, $options){
        $username = 'musa@8technologies.net';  // use 'sandbox' for development in the test environment
        $apiKey = $_ENV['AT_API_KEY']; // use your sandbox app API key for development in the test environment
        
        $at = new AfricasTalking($username, $apiKey);

        // Get one of the services
        $sms      = $at->sms();
        $voice      = $at->voice();
        

        $session_id = $request->session_id;
        $is_active = $request->is_active;
        $phone_number = $request->phone_number;
        $direction = $request->direction;
        $agent_called = $request->agent_called;
        $destination_number = $request->destination_number;
        $recording_url = $request->recording_url;
        $duration_in_seconds = $request->duration_in_seconds;
        $currency_code = $request->currency_code;
        $call_state = $request->call_state;
        $amount = $request->amount;
        $dtmf_digits = $request->dtmf_digits;
        $config = Configuration::get()->first();
        $response = 'None';
        $menu = 'None';
        $language = 'None';


        if (!$this->isValidURL($url))
            return $this->error('Play URL is not valid');

        $playString = '<Play url="'. $url . '"/>';

        return $playString;
    }
}
