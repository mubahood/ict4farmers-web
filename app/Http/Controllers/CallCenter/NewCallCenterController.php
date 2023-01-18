<?php

namespace App\Http\Controllers\CallCenter;

use App\Http\Controllers\Controller;
use AfricasTalking\SDK\AfricasTalking;
use App\Models\Attribute;
use App\Models\Call;
use App\Models\CallModel;
use App\Models\Configuration;
use Illuminate\Http\Request;


class NewCallCenterController extends Controller
{
    public function call_center_voice(Request $r)
    {
        $session_id = $r->sessionId;

        $call = CallModel::where('session_id', $session_id)->first();
        $config = Configuration::get()->first();
        $is_new = true;
        $dtmfDigits = $r->dtmfDigits;
        $recordingUrl = $r->recordingUrl;
        $dialDurationInSeconds = $r->dialDurationInSeconds;
        $dtmfDigits = ((int)($dtmfDigits));


        /* session_id
*/

        /* 
dialDurationInSeconds:6
destinationNumber:+256312319003
  
"recordingUrl": "http://41.210.130.212:8080/5d5e2457ca70ee2a65a3e1c3e23c1efc.mp3",
"callerCarrierName": "MTN",
"dialStartTime": "2023-01-18+20:05:25",
"sessionId": "ATVId_4ae09e41dc3fa616b1aa42c792d95805",
"status": "Success",
"callSessionState": "Completed",
"callerNumber": "+256783204665",
"callStartTime": "2023-01-18+20:04:52",
"direction": "Inbound",
"": "147.440",
"": "UGX",
"durationInSeconds": "39",
"isActive": "0"
*/

        if ($call != null) {

            $is_new = false;


            if ($dialDurationInSeconds != null && $recordingUrl != null && $r->dialDestinationNumber != null) {
                if (strlen($recordingUrl) > 3) {
                    $call->caller_country  = $r->callerCountryCode;
                    $call->agent_phone_number  = $r->dialDestinationNumber;
                    $call->recording_url  = $r->recordingUrl;
                    $call->call_duration  = $r->dialDurationInSeconds;
                    $call->amount  = $r->amount;
                    $call->currency  = $r->currencyCode;
                    $call->save();
                    $resp = '<?xml version="1.0" encoding="UTF-8"?><Response>';
                    $resp .= '<GetDigits timeout="30" numDigits="1">';
                    $resp .= '<Say>THANK YOU!.</Say>';
                    $resp .= '</GetDigits>';
                    $resp .= '</Response>';
                }
            }



            if ($dtmfDigits != null) {
                if ($call->language == null) {
                    if ($dtmfDigits == 1) {
                        $call->language = 'English';
                        $call->save();
                        $resp = '<?xml version="1.0" encoding="UTF-8"?><Response>';
                        $resp .= '<GetDigits timeout="30" numDigits="1">';
                        $resp .= '<Play url="' . asset('assets/audio/pwds/call_center/for_help_01.mp3') . '"></Play>';
                        $resp .= '</GetDigits>';
                        $resp .= '</Response>';
                        return $resp;
                    } else if ($dtmfDigits == 2) {
                        $call->language = 'Luganda';
                        $call->save();
                        $resp = '<?xml version="1.0" encoding="UTF-8"?><Response>';
                        $resp .= '<GetDigits timeout="30" numDigits="1">';
                        $resp .= '<Play url="' . asset('assets/audio/pwds/call_center/okwebuza_01.mp3') . '"></Play>';
                        $resp .= '</GetDigits>';
                        $resp .= '</Response>';
                        return $resp;
                    } else if ($dtmfDigits == 3) {
                        $call->language = 'Runyakitara';
                        $call->save();
                        $resp = '<?xml version="1.0" encoding="UTF-8"?><Response>';
                        $resp .= '<Say>Please wait as we connect you to Runyakitara agent.</Say>';
                        $resp .= '<Dial record="true" sequential="true" phoneNumbers="+256706638494,+256706638494,agent1.farmercallcenter@ug.sip2.africastalking.com"/>';
                        $resp .= '</Response>';
                        return $resp;
                    } else if ($dtmfDigits == 4) {
                        $call->language = 'Swahili';
                        $call->save();
                        $resp = '<?xml version="1.0" encoding="UTF-8"?><Response>';
                        $resp .= '<Dial record="true" sequential="true" phoneNumbers="+256706638494,+256706638494,agent1.farmercallcenter@ug.sip2.africastalking.com"/>';
                        $resp .= '</Response>';
                        return $resp;
                    }
                } else if ($dtmfDigits != null) {
                    if ($call->language == 'English') {
                        if ($dtmfDigits == 1) {
                            $call->inquiry_category = 'Coffee';
                            $call->save();
                            $resp = '<?xml version="1.0" encoding="UTF-8"?><Response>';
                            $resp .= '<Say>Please wait as we connect you to Coffee agent.</Say>';
                            $resp .= '<Dial record="true" sequential="true" phoneNumbers="+256706638494,+256706638494,agent1.farmercallcenter@ug.sip2.africastalking.com"/>';
                            $resp .= '</Response>';
                            return $resp;
                        } else  if ($dtmfDigits == 2) {
                            $call->inquiry_category = 'Farming';
                            $call->save();
                            $resp = '<?xml version="1.0" encoding="UTF-8"?><Response>';
                            $resp .= '<Say>Please wait as we connect you to Farming agent.</Say>';
                            $resp .= '<Dial record="true" sequential="true" phoneNumbers="+256706638494,+256706638494,agent1.farmercallcenter@ug.sip2.africastalking.com"/>';
                            $resp .= '</Response>';
                            return $resp;
                        }
                    } else if ($call->language == 'Luganda') {
                        if ($dtmfDigits == 1) {
                            $call->inquiry_category = 'Coffee';
                            $call->save();
                            $resp = '<?xml version="1.0" encoding="UTF-8"?><Response>';
                            $resp .= '<Say>Please wait as we connect you to Luganda Coffee agent.</Say>';
                            $resp .= '<Dial record="true" sequential="true" phoneNumbers="+256706638494,+256706638494,agent1.farmercallcenter@ug.sip2.africastalking.com"/>';
                            $resp .= '</Response>';
                            return $resp;
                        } else  if ($dtmfDigits == 2) {
                            $call->inquiry_category = 'Farming';
                            $call->save();
                            $resp = '<?xml version="1.0" encoding="UTF-8"?><Response>';
                            $resp .= '<Say>Please wait as we connect you to Luganda Farming agent.</Say>';
                            $resp .= '<Dial record="true" sequential="true" phoneNumbers="+256706638494,+256706638494,agent1.farmercallcenter@ug.sip2.africastalking.com"/>';
                            $resp .= '</Response>';
                            return $resp;
                        }
                    }
                }
            }
        } else {
        }





        $call = new CallModel();
        $call->session_id = $r->sessionId;
        $call->caller_carrier = $r->callerCarrierName;
        $call->caller_phone_number = $r->callerNumber;
        $call->caller_country = $r->callerCountryCode;
        $call->save();

        $resp = '<?xml version="1.0" encoding="UTF-8"?><Response>';
        if ($is_new) {
            $resp .= '<Play url="' . asset('assets/audio/pwds/call_center/intro_01.mp3') . '"></Play>';
        } else {
            $resp .= '<Say>You entered a wrong selection. Please listen carefully and select again.</Say>';
        }

        $resp .= '<GetDigits timeout="30" numDigits="1">';
        $resp .= '<Play url="' . asset('assets/audio/pwds/call_center/menu_selection_audio.mp3') . '"></Play>';
        $resp .= '</GetDigits>';
        $resp .= '</Response>';


        return $resp;
    }
}
