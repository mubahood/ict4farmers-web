<?php

namespace Callcenter;

use App\Http\Controllers\Controller;
use AfricasTalking\SDK\AfricasTalking;
use App\Models\Call;
use App\Models\Configuration;
use Illuminate\Http\Request;

$username = 'musa@8technologies.net';  // use 'sandbox' for development in the test environment
$apiKey = $_ENV['AT_API_KEY']; // use your sandbox app API key for development in the test environment

$AT = new AfricasTalking($username, $apiKey);

// Get the voice service
$voice = $AT->voice();


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
        $dtmf_digits = $request->dtmfDigits;
        $config = Configuration::get()->first();
        $response = "";
        $menu = "";
        $language = "";

        if ($dtmf_digits == Null)
            $response = '<?xml version="1.0" encoding="UTF-8"?>';
            $response .= '<Response>';
            $response .= '<Play url>'. $config->introduction->url;
            $response .= '<GetDigits timeout="30" numDigits="1">';
            $response .= '<Play url>'. $config->call_back_voice->url;
            $response .= '</GetDigits>';
            $response .= '</Response>';

        // getting the current call
        $current_call = '';

        if (!isset($current_call)){
            $current_call = Call::where('session_id', "=>", "session_id")->get();
        }else{
            $current_call == Null;
        }

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
            $response .= '<Response>';
            $response .= '<GetDigits timeout="30" numDigits="1">';
            $response .= '<Play url=""' . $config->help_in_english->url;
            $response .= '</GetDigits>';
            $response .= '</Response>';
            $menu = 2;
            $language= "English";

            // Start English sub menu
            if ($dtmf_digits == '1' &&  $current_call->call_menu_selected == 2 && $current_call->language == "English"){
                $response .= '<Response>';
                $response .= '<Dial record="true" sequential="true" phoneNumbers="+256774610022,+256789272217,agent1.farmercallcenter@ug.sip2.africastalking.com"/>';
                $response .= '</Response>';
            }
            
            elseif ($dtmf_digits == '2' &&  $current_call->call_menu_selected == 2 && $current_call->language == "English"){
                $response .= '<Response>';
                $response .= '<Dial record="true" sequential="true" phoneNumbers="+256787969833,+256783784498,agent1.farmercallcenter@ug.sip2.africastalking.com"/>';
                $response .= '</Response>';
            } // End English sub menu
        } // End English menu 1 ---------------------------------------------------------------------------


        // Start Luganda menu 1
        elseif (($dtmf_digits == '2') && ($current_call->call_menu_selected == 1)) {
            $response .= '<Response>';
            $response .= '<GetDigits timeout="30" numDigits="1">';
            $response .= "<Play url=''" . $config->help_in_luganda->url;
            $response .= '</GetDigits>';
            $response .= '</Response>';
            $menu = 2;
            $language= "Luganda";

            // Start Luganda sub menu
            if ($dtmf_digits == '2' &&  $current_call->call_menu_selected == 2 && $current_call->language == "Luganda"){
                $response .= '<Response>';
                $response .= '<Dial record="true" sequential="true" phoneNumbers="+256774610022,+256789272217,agent1.farmercallcenter@ug.sip2.africastalking.com"/>';
            }
            elseif ($dtmf_digits == '2' &&  $current_call->call_menu_selected == 2 && $current_call->language == "Luganda"){
                $response .= '<Response>';
                $response .= '<Dial record="true" sequential="true" phoneNumbers="+256787969833,+256783784498,agent1.farmercallcenter@ug.sip2.africastalking.com"/>';
                $response .= '</Response>';
            } 
            elseif ($dtmf_digits == '3' &&  $current_call->call_menu_selected == 1){
                $response .= '<Response>';
                $response .= '<Dial record="true" sequential="true" phoneNumbers="+256774952449,+256783784498,agent2.farmercallcenter@ug.sip2.africastalking.com"/>';
                $response .= '</Response>';
            } 
            elseif ($dtmf_digits == '4' &&  $current_call->call_menu_selected == 1){
                $response .= '<Response>';
                $response .= '<Dial record="true" sequential="true" phoneNumbers="+256772973970,+256783784498,agent3.farmercallcenter@ug.sip2.africastalking.com"/>';
                $response .= '</Response>';
            } 
            elseif ($dtmf_digits == '5' &&  $current_call->call_menu_selected == 1){
                $response .= '<Response>';
                $response .= '<Dial record="true" sequential="true" phoneNumbers="+256782701885,+256784067089,agent3.farmercallcenter@ug.sip.africastalking.com"/>';
                $response .= '</Response>';
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
    }
}


/*
+256312319003	Tollfree	Yes	
Callback: https://app.unffeict4farmers.org/callcenter/voice/
Events: N/A

+256800209003	Tollfree	Yes	
Callback:

https://a155-41-75-188-87.eu.ngrok.io/api/callcenter/voice/
Events: N/A
*/
