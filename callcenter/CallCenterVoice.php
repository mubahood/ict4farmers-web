<?php

use Illuminate\Http\Request;
use AfricasTalking\SDK\AfricasTalking;
use App\Models\Call;
use App\Models\Configuration;
use Exception;
use phpDocumentor\Reflection\PseudoTypes\True_;
use PhpOption\None;

/**
 * Remember to set the env['AT_API_KEY'] value in your .env file of the project
 * 
**/

$username = 'musa@8technologies.net';  // use 'sandbox' for development in the test environment
$apiKey = $_ENV['AT_API_KEY']; // use your sandbox app API key for development in the test environment

$AT = new AfricasTalking($username, $apiKey);

// Get the voice service
$voice = $AT->voice();

$session_id = $_POST["session_id"];
$is_active = $_POST["is_active"];
$phone_number = $_POST["phone_number"];
$direction = $_POST["direction"];
$agent_called = $_POST["agent_called"];
$destination_number = $_POST["destination_number"];
$recording_url = $_POST["recording_url"];
$duration_in_seconds = $_POST["duration_in_seconds"];
$currency_code = $_POST["currency_code"];
$call_state = $_POST["call_state"];
$amount = $_POST["amount"];
$dtmf_digits = $_POST["dtmf_digits"];
$config = Configuration::get()->first();
$response = "";
$menu = "";
$language = "";

$at_xml= new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>');

$response = $at_xml->addChild('play_obj');
$response->addChild("Response");
$response->addChild("Play url", $config->introduction->url());
$response->addChild("GetDigits timeout='30' numDigits='1'", $config->call_back_voice->url);

// getting the current call
$current_call = '';

if (!isset($current_call)){
    $current_call = Call::where('session_id', "=>", "session_id")->get();
}

$current_call = "";

# check if you already save the call and skip saving it again

if (!isset($current_call)){
    $new_call = new Call();
    $new_call->session_id = $session_id;
    $new_call->phone = $phone_number;
    $new_call->call_type = $direction; 
    $new_call->active = $is_active;
    $new_call->agent_phone = $agent_called;
    $new_call->call_menu_selected = 1;
    $new_call->save();
}

// Start English menu 1 ---------------------------------------------------------------------------
if (($dtmf_digits == '1') && ($current_call->call_menu_selected == 1)) {
    $response = $at_xml->addChild('english_selected');
    $response->addChild("Response");
    $response->addChild("GetDigits timeout='30' numDigits='1'", $config->call_back_voice->url());
    $response->addChild("Play url", $config->help_in_english->url);
    $menu = 2;
    $language= "English";

    // Start English sub menu
    if ($dtmfDigits == '1' &&  $current_call->call_menu_selected == 2 && $current_call->language == "English"){
        $response = $at_xml->addChild('english_submenu1');
        $response->addChild("Response");
        $response->addChild('<Dial record="true" sequential="true" phoneNumbers="+256774610022,+256789272217,agent1.farmercallcenter@ug.sip2.africastalking.com"/>');
    } 
    elseif ($dtmfDigits == '2' &&  $current_call->call_menu_selected == 2 && $current_call->language == "English"){
        $response = $at_xml->addChild('english_submenu2');
        $response->addChild("Response");
        $response->addChild('<Dial record="true" sequential="true" phoneNumbers="+256787969833,+256783784498,agent1.farmercallcenter@ug.sip2.africastalking.com"/>');
    } // End English sub menu
} // End English menu 1 ---------------------------------------------------------------------------


// Start Luganda menu 1
elseif (($dtmf_digits == '2') && ($current_call->call_menu_selected == 1)) {
    $response = $at_xml->addChild('luganda_selected');
    $response->addChild("Response");
    $response->addChild("GetDigits timeout='30' numDigits='1'", $config->call_back_voice->url());
    $response->addChild("Play url", $config->help_in_luganda->url);
    $menu = 2;
    $language= "Luganda";

    // Start Luganda sub menu
    if ($dtmfDigits == '2' &&  $current_call->call_menu_selected == 2 && $current_call->language == "Luganda"){
        $response = $at_xml->addChild('luganda_submenu1');
        $response->addChild("Response");
        $response->addChild('<Dial record="true" sequential="true" phoneNumbers="+256774610022,+256789272217,agent1.farmercallcenter@ug.sip2.africastalking.com"/>');
    }
    elseif ($dtmfDigits == '2' &&  $current_call->call_menu_selected == 2 && $current_call->language == "Luganda"){
        $response = $at_xml->addChild('luganda_submenu2');
        $response->addChild("Response");
        $response->addChild('<Dial record="true" sequential="true" phoneNumbers="+256787969833,+256783784498,agent1.farmercallcenter@ug.sip2.africastalking.com"/>');
    } 
    elseif ($dtmfDigits == '3' &&  $current_call->call_menu_selected == 1){
        $response = $at_xml->addChild('luganda_submenu3');
        $response->addChild("Response");
        $response->addChild('<Dial record="true" sequential="true" phoneNumbers="+256774952449,+256783784498,agent2.farmercallcenter@ug.sip2.africastalking.com"/>');
    } 
    elseif ($dtmfDigits == '4' &&  $current_call->call_menu_selected == 1){
        $response = $at_xml->addChild('luganda_submenu3');
        $response->addChild("Response");
        $response->addChild('<Dial record="true" sequential="true" phoneNumbers="+256772973970,+256783784498,agent3.farmercallcenter@ug.sip2.africastalking.com"/>');
    } 
    elseif ($dtmfDigits == '5' &&  $current_call->call_menu_selected == 1){
        $response = $at_xml->addChild('luganda_submenu3');
        $response->addChild("Response");
        $response->addChild('<Dial record="true" sequential="true" phoneNumbers="+256782701885,+256784067089,agent3.farmercallcenter@ug.sip.africastalking.com"/>');
    } // End Luganda sub menu
} // End Luganda menu 1 ---------------------------------------------------------------------------


// updating the selected menu option of the current call
if ($menu == 2){
    $current_call->call_menu_selected = 2;
    $current_call->language = $language;
    $current_call->save();
}

// update call when its done
if ($call_state == 'Completed') {
    # update the call to record the voice
    # getting the current call
    
    try {
        $current_call->recording_url = $recording_url;
        $current_call->call_duration = $duration_in_seconds;
        $current_call->agent_phone = $agent_called;
        $current_call->save();
    } catch (\Throwable $th) {
        throw $th->getMessage();
    }
}

return $response;
