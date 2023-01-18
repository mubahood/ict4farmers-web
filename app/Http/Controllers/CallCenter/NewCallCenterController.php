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



        if ($call != null) {
            $is_new = false;
            if ($dtmfDigits != null) {
                if ($call->language == null) {
                    if ($dtmfDigits == 1) {
                        $call->language = 'English';
                        $call->save();
                        $resp = '<?xml version="1.0" encoding="UTF-8"?><Response>';
                        $resp .= '<Say>Please wait as we connect you to Swahili agent.</Say>';
                        $resp .= '<GetDigits timeout="30" numDigits="1">';
                        $resp .= '<Play url="' . $config->call_back_voice . '"></Play>';
                        $resp .= '</GetDigits>';
                        $resp .= '</Response>';
                        return $resp;
                    } else if ($dtmfDigits == 2) {
                        $call->language = 'Luganda';
                        $call->save();
                    } else if ($dtmfDigits == 3) {
                        $call->language = 'Runyakitara';
                        $call->save();
                        $resp = '<?xml version="1.0" encoding="UTF-8"?><Response>';
                        $resp .= '<Say>Please wait as we connect you to Runyakitara agent.</Say>';
                        $resp .= '</Response>';
                        return $resp;
                    } else if ($dtmfDigits == 4) {
                        $call->language = 'Swahili';
                        $call->save();

                        $resp = '<?xml version="1.0" encoding="UTF-8"?><Response>';
                        $resp .= '<Say>Please wait as we connect you to Swahili agent.</Say>';
                        $resp .= '</Response>';
                        return $resp;
                    }
                }
            }
        } else {
        }


        /* session_id
caller_phone_number

Full texts
id
created_at
updated_at
session_id
caller_phone_number
caller_country
caller_caller

caller_country
caller_caller
inquiry_category
agent_phone_number
recording_url
call_duration
caller_carrier */


        $call = new CallModel();
        $call->session_id = $r->sessionId;
        $call->caller_carrier = $r->callerCarrierName;
        $call->caller_phone_number = $r->callerNumber;
        $call->caller_country = $r->callerCountryCode;
        $call->save();

        $resp = '<?xml version="1.0" encoding="UTF-8"?><Response>';
        if ($is_new) {
            $resp .= '<Play url="' . $config->introduction . '"></Play>';
        } else {
            $resp .= '<Say>You entered a wrong selection. Please listen carefully and select again.</Say>';
        }

        $resp .= '<GetDigits timeout="30" numDigits="1">';
        $resp .= '<Play url="' . $config->call_back_voice . '"></Play>';
        $resp .= '</GetDigits>';
        $resp .= '</Response>';




        return $resp;
    }
}
