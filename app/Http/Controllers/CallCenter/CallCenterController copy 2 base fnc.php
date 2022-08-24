<?php

namespace App\Http\Controllers\CallCenter;

use App\Http\Controllers\Controller;
use AfricasTalking\SDK\AfricasTalking;
use App\Models\Call;
use App\Models\Configuration;
use Illuminate\Http\Request;

$username = $_ENV['AT_API_USERNAME'];  // use 'sandbox' for development in the test environment
$apiKey = $_ENV['AT_API_KEY']; // use your sandbox app API key for development in the test environment

$AT = new AfricasTalking($username, $apiKey);

// Get the voice service
$voiceinstance = $AT->voice();

$details = NULL;
$is_a_lang_selected = NULL;


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
		global $is_a_lang_selected;

		if ($is_a_lang_selected == false) {

			if ($dtmfDigits == NULL){
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
			}

        // getting the current call
        try {            
            $current_call = Call::where('session_id', $session_id)->first();;
        } catch (\Throwable $th) {
            $current_call = NULL;
        }

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

		// if ($request->is_active == "0") {
		// 	return callEnded();
		// }


		switch ($dtmfDigits) {
			case 1:
				return $this->support_in_english();
				break;
			
			case 2:
				return $this->support_in_luganda();
				break;
			
			default:
				return $this->base();
				break;

		}  // end switch
	}   
	
	return $response;
	}


	public function support_in_english()
	{
		global $details;
		global $response;
		global $dtmfDigits;
		global $current_call;
		global $config;

		// $is_a_lang_selected = true;
		// $current_call->first()->language == "English";

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
			$current_call->first()->call_menu_selected == 2;
            $language = "English";
        } // End English menu 1 ---------------------------------------------------------------------------

		
		// switch ([$dtmfDigits, ($current_call->first()->call_menu_selected), ($current_call->first()->language)]){
		// 	case [$dtmfDigits == 1 && ($current_call->first()->call_menu_selected == 2) && ($current_call->first()->language == "English")]:
		// 		$response .= '<Response>';
		// 		$response .= '<Dial record="true" sequential="true" phoneNumbers="+256705638458,+2516706638494"/>';
		// 		$response .= '</Dial>';
		// 		$response .= '</Response>';
		// 		break;
			
		// 	case [$dtmfDigits == 2 && ($current_call->first()->call_menu_selected == 2) && ($current_call->first()->language == "English")]:
		// 		$response .= '<Response>';
		// 		$response .= '<Dial record="true" sequential="true" phoneNumbers="+256705638458,+256706638494"/>';
		// 		$response .= '</Dial>';
		// 		$response .= '</Response>';
		// 		break;
			
		// 	default:
		// 		return $this->base();
		// 		break;

		// }  // end switch


		// $this->update_details($current_call);

        // Start English sub menu
        if ($dtmfDigits == 1 && ($current_call->first()->call_menu_selected == 2) && ($current_call->first()->language == "English")){
            $response .= '<Response>';
            $response .= '<Dial record="true" sequential="true" phoneNumbers="+256705638458,+2516706638494"/>';
            $response .= '</Dial>';
            $response .= '</Response>';
        }
		elseif (($dtmfDigits == 2) && ($current_call->first()->call_menu_selected == 2) && ($current_call->first()->language == "English")){
            $response .= '<Response>';
            $response .= '<Dial record="true" sequential="true" phoneNumbers="+256705638458,+256706638494"/>';
            $response .= '</Dial>';
            $response .= '</Response>';
        } // End English sub menu

		return $response;
	}


	public function support_in_luganda(Request $request)
	{
		global $details;
		global $dtmfDigits;
		global $current_call;
		global $response;

		$is_a_lang_selected = true;
		$current_call->first()->language = "Luganda";

		// $this->update_details($this->call_center_voice($request)->$details);
		
		// Start Luganda sub menu
		if ($dtmfDigits == '2' &&  $current_call->first()->call_menu_selected == 2 && $current_call->first()->language == "Luganda"){
            $response = '<?xml version="1.0" encoding="UTF-8"?>';
			$response .= '<Response>';
			$response .= '<Dial record="true" sequential="true" phoneNumbers="+256706638494,agent1.farmercallcenter@ug.sip2.africastalking.com"/>';
			$response .= '</Dial>';
		}

		elseif ($dtmfDigits == '2' &&  $current_call->first()->call_menu_selected == 2 && $current_call->first()->language == "Luganda"){
            $response = '<?xml version="1.0" encoding="UTF-8"?>';
			$response .= '<Response>';
			$response .= '<Dial record="true" sequential="true" phoneNumbers="+256706638494,agent1.farmercallcenter@ug.sip2.africastalking.com"/>';
		$response .= '</Dial>';
			$response .= '</Response>';
		} 
		elseif ($dtmfDigits == '3' &&  $current_call->first()->call_menu_selected == 1){
            $response = '<?xml version="1.0" encoding="UTF-8"?>';
			$response .= '<Response>';
			$response .= '<Dial record="true" sequential="true" phoneNumbers="+256706638494,agent2.farmercallcenter@ug.sip2.africastalking.com"/>';
			$response .= '</Response>';
		} 

		elseif ($dtmfDigits == '4' &&  $current_call->first()->call_menu_selected == 1){
            $response = '<?xml version="1.0" encoding="UTF-8"?>';
			$response .= '<Response>';
			$response .= '<Dial record="true" sequential="true" phoneNumbers="+256706638494,agent3.farmercallcenter@ug.sip2.africastalking.com"/>';
			$response .= '</Response>';
		}

		elseif ($dtmfDigits == '5' &&  $current_call->first()->call_menu_selected == 1){
            $response = '<?xml version="1.0" encoding="UTF-8"?>';
			$response .= '<Response>';
			$response .= '<Dial record="true" sequential="true" phoneNumbers="+256706638494,agent3.farmercallcenter@ug.sip.africastalking.com"/>';
			$response .= '</Response>';
		} // End Luganda sub menu

		return $response;
	}
	

	public function base()
	{
        $config = Configuration::get()->first();
        // global $config;

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

		return $response;
	}


	public function unknownOption()
	{
		
        $config = Configuration::get()->first();
		// global $config;

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
	}

    
	public function update_details($current_call)
	{
        global $menu;
        global $current_call;
        global $language;
        global $call_state;
        global $recording_url;
        global $duration_in_seconds;
        global $agent_called;

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
	}
}



/*

Sandbox

Phone	Type	InBound	URLs	Actions
+256722123123	Regular	Yes	
Callback: http://app2.unffeict4farmers.org/api/voice
Events: http://app2.unffeict4farmers.org/api/voice-events

Callback
Delete
+256800209011	Regular	Yes	
Callback: https://app.unffeict4farmers.org/callcenter/voice/
Events: https://app.unffeict4farmers.org/callcenter/

Callback
Delete




Live server

+256312319003	Tollfree	Yes	
Callback: https://app.unffeict4farmers.org/callcenter/voice/
Events: N/A

+256800209003	Tollfree	Yes	
Callback: https://app.unffeict4farmers.org/callcenter/voice/
Events: N/A



 https://4b04-41-75-186-135.eu.ngrok.io/api/call_center_voice

"recordingUrl": "http://41.210.130.212:8080/e62bc0ae2203608af64424cdb390518d.mp3",









*/

