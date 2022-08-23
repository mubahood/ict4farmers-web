<?php

namespace App\Http\Controllers\CallCenter;

use App\Http\Controllers\Controller;
use AfricasTalking\SDK\AfricasTalking;
use App\Models\Call;
use App\Models\Configuration;
use Illuminate\Http\Request;

$username = 'musa@8technologies.net';  // use 'sandbox' for development in the test environment
$apiKey = $_ENV['AT_API_KEY']; // use your sandbox app API key for development in the test environment
// $apiKey = "27709b682804f7f4d3b0bd3b69f76de8ed6da2ea0e7dc12f2995e53e30ae2f5f"; 
// print_r($apiKey);

$AT = new AfricasTalking($username, $apiKey);

// Get the voice service
$voiceinstance = $AT->voice();

class CallCenterController extends Controller
{
    public function call_center_voice(Request $request){
        $session_id = $request->sessionId;
        $is_active = $request->isActive;
        $phone_number = $request->callerNumber;
        $direction = $request->direction;
        $agent_called = $request->dialDestinationNumber;
        $destination_number = $request->destinationNumber;
        $recording_url = $request->recordingUrl;
        $duration_in_seconds = $request->durationInSeconds;
        $currency_code = $request->currencyCode;
        $call_state = $request->callSessionState;
        $amount = $request->amount;
        $dtmfDigits = $request->dtmfDigits;
        $config = Configuration::get()->first();
        $response = NULL;
        $menu = NULL;
        $language = NULL;

        if ($dtmfDigits == NULL)
            $response = '<?xml version="1.0" encoding="UTF-8"?>';
            $response .= '<Response>';
            // $response .= '<Play url="'. $_ENV['APP_URL'] .'/ict4farmers-web/public/assets/audio/pwds/call_center/intro_01.mp3'.'">';   // thank you for calling  the farmers help center, please wait as we redirect you
            $response .= '<Play url="'.$config->introduction.'">';   // thank you for calling  the farmers help center, please wait as we redirect you
            $response .= '</Play>';
            $response .= '<GetDigits timeout="30" numDigits="1">';
            $response .= '<Play url="'.$config->call_back_voice.'">';   // for help in english, press 1,.......
            $response .= '</Play>';
            $response .= '</GetDigits>';
            $response .= '</Response>';

        $current_call = NULL;

        // getting the current call
        try {            
            $current_call = Call::where('session_id', $session_id)->first();;
        } catch (\Throwable $th) {
            $current_call = NULL;
        }

        // print($current_call);

        # check if call is already saved and skip saving it again
        try {
            if (!isset($current_call)){
                $new_call = new Call();
                $new_call->session_id = $session_id;
                $new_call->phone = $phone_number;
                $new_call->call_type = $direction; 
                $new_call->active = $is_active;
                $new_call->agent_phone = $agent_called;
                $new_call->call_menu_selected = 1;
                $new_call->save();   // save the current call and all its attributes
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

    
        // Start English menu 1 ---------------------------------------------------------------------------
        if (($dtmfDigits == 1) && ($current_call->first()->call_menu_selected == 1)) {
            $response = '<?xml version="1.0" encoding="UTF-8"?>';
            $response .= '<Response>';
            $response .= '<GetDigits timeout="30" numDigits="1">';
            $response .= '<Play url="'.$config->help_in_english.'">';   // (isaac) for help in coffee farming, press 1, ...
            $response .= '</Play>';
            $response .= '</GetDigits>';
            $response .= '</Response>';
            $menu = 2;
            $language = "English";
            // $current_call->first()->language = $language;
            // $current_call->save();    // update the language to the db on this one
        } // End English menu 1 ---------------------------------------------------------------------------

        // Start English sub menu
        elseif ($dtmfDigits == 1 && ($current_call->first()->call_menu_selected == 2) && ($current_call->first()->language == "English")){
            $response .= '<Response>';
            $response .= '<Dial record="true" sequential="true" phoneNumbers="+2516706638494,+2516706638494"/>';
            $response .= '</Response>';
        }

        elseif (($dtmfDigits == 2) && ($current_call->first()->call_menu_selected == 2) && ($current_call->first()->language == "English")){
            $response .= '<Response>';
            $response .= '<Dial record="true" sequential="true" phoneNumbers="+256706638494,+256706638494"/>';
            $response .= '</Response>';
        } // End English sub menu


        // Start Luganda menu 1
        if (($dtmfDigits == '2') && ($current_call->first()->call_menu_selected == 1)) {
            $response = '<?xml version="1.0" encoding="UTF-8"?>';
            $response .= '<Response>';
            $response .= '<GetDigits timeout="30" numDigits="1">';
            $response .= '<Play url="'.$config->help_in_luganda.'">'.'</Play>';
            $response .= '</GetDigits>';
            $response .= '</Response>';
            $menu = 2;
            $language= "Luganda";

            // Start Luganda sub menu
            if ($dtmfDigits == '2' &&  $current_call->first()->call_menu_selected == 2 && $current_call->first()->language == "Luganda"){
                $response .= '<Response>';
                $response .= '<Dial record="true" sequential="true" phoneNumbers="+256706638494,agent1.farmercallcenter@ug.sip2.africastalking.com"/>';
            }
            elseif ($dtmfDigits == '2' &&  $current_call->first()->call_menu_selected == 2 && $current_call->first()->language == "Luganda"){
                $response .= '<Response>';
                $response .= '<Dial record="true" sequential="true" phoneNumbers="+256706638494,agent1.farmercallcenter@ug.sip2.africastalking.com"/>';
                $response .= '</Response>';
            } 
            elseif ($dtmfDigits == '3' &&  $current_call->first()->call_menu_selected == 1){
                $response .= '<Response>';
                $response .= '<Dial record="true" sequential="true" phoneNumbers="+256706638494,agent2.farmercallcenter@ug.sip2.africastalking.com"/>';
                $response .= '</Response>';
            } 
            elseif ($dtmfDigits == '4' &&  $current_call->first()->call_menu_selected == 1){
                $response .= '<Response>';
                $response .= '<Dial record="true" sequential="true" phoneNumbers="+256706638494,agent3.farmercallcenter@ug.sip2.africastalking.com"/>';
                $response .= '</Response>';
            } 
            elseif ($dtmfDigits == '5' &&  $current_call->first()->call_menu_selected == 1){
                $response .= '<Response>';
                $response .= '<Dial record="true" sequential="true" phoneNumbers="+256706638494,agent3.farmercallcenter@ug.sip.africastalking.com"/>';
                $response .= '</Response>';
            } // End Luganda sub menu
        } // End Luganda menu 1 ---------------------------------------------------------------------------


        // updating the selected menu option of the current call
        if ($menu == 2){
            $current_call->first()->call_menu_selected = 2;
            $current_call->first()->language = $language;
            $current_call->save();
        }

        // update call when its done
        if ($call_state == 'Completed') {
            # update the call to record the voice
            # getting the current call
            
            try {
                $current_call->first()->recording_url = $recording_url;
                $current_call->first()->call_duration = $duration_in_seconds;
                $current_call->first()->agent_phone = $agent_called;
                $current_call->save();
            } catch (\Throwable $th) {
                // throw $th->getMessage();
            }
        }
        return $response;
    }
}


/*
+256312319003	Tollfree	Yes	
Callback: https://app.unffeict4farmers.org/callcenter/voice/
Events: N/A

+256800209003	Tollfree	Yes	
Callback: https://app.unffeict4farmers.org/callcenter/voice/
Events: N/A

https://bcac-41-75-186-219.eu.ngrok.io/api/call_center_voice
"recordingUrl": "http://41.210.130.212:8080/e62bc0ae2203608af64424cdb390518d.mp3",


*/


        
        