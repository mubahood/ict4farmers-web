
import os
import africastalking
from rest_framework import status
from rest_framework.decorators import api_view
from .models import Configurations
from django.http import HttpResponse
from unffeagents.models import Call


username = os.getenv('username', 'musa@8technologies.net')
api_key = os.getenv('api_key', 'fake')

africastalking.initialize(username, api_key)
sm = africastalking.SMS
airtime = africastalking.Airtime
payment = africastalking.Payment
voiceinstance = africastalking.Voice


@api_view(['GET', 'POST'])
def voice(request):
    session_id = request.data.get("sessionId", None)
    isActive = request.data.get("isActive", None)
    phone_number = request.data.get("callerNumber", None)
    direction = request.data.get("direction", None)
    agent_called = request.data.get("dialDestinationNumber", None)
    destination_number = request.data.get("destinationNumber", None)
    recording_url = request.data.get("recordingUrl", None)
    duration_in_seconds = request.data.get("durationInSeconds", None)
    currency_code = request.data.get("currencyCode", None)
    call_state = request.data.get("callSessionState", None)
    amount = request.data.get("amount", None)
    dtmfDigits = request.data.get("dtmfDigits", None)
    config = Configurations.objects.first()
    response = None
    menu=None
    language = None
  

    if dtmfDigits is None:
        
        #response = '<?xml version="1.0" encoding="UTF-8"?>'
        response = '<Response>'
        response += '<Play url="' + \
            request.build_absolute_uri(config.introduction.url)+'"/>'
        response += '<GetDigits timeout="30" numDigits="1">'
        response += '<Play url="' + \
            request.build_absolute_uri(config.call_back_voice.url)+'"/>'
        response += '</GetDigits>'
        response += '</Response>'

    #
        #getting the current call
    current_call=None
    try:
        current_call = Call.objects.get(session_id=session_id)
    except:
        current_call= None
    
    # check if you already save the call and skip saving it again
    try:
        if current_call is None:
            new_call = Call(session_id=session_id, phone=phone_number, call_type=direction, active=isActive, agent_phone=agent_called,call_menu_selected =1)
            new_call.save()
    except:
        print("No call yet") 
        


    if dtmfDigits == '1' and current_call.call_menu_selected == 1:
        response ='<Response>'
        response += '<GetDigits timeout="30" numDigits="1">'
        response += '<Play url="' +request.build_absolute_uri(config.help_in_english.url)+'"/>'
        response += '</GetDigits>'
        response += '</Response>'
        menu = 2
        language= "English"
      
      
  #English sub menu starts here
    if dtmfDigits == '1' and  current_call.call_menu_selected == 2 and current_call.language == "English":
        response = '<Response>'
        response += '<Dial record="true" sequential="true" phoneNumbers="+256774610022,+256789272217,agent1.farmercallcenter@ug.sip2.africastalking.com"/>'
        response += '</Response>'


    if dtmfDigits == '2' and  current_call.call_menu_selected == 2 and current_call.language == "English":
        response = '<Response>'
        response += '<Dial record="true" sequential="true" phoneNumbers="+256787969833,+256783784498,agent1.farmercallcenter@ug.sip2.africastalking.com"/>'
        response += '</Response>'


   # English sub menu ends here
   # Luganda menu
    elif dtmfDigits == '2' and current_call.call_menu_selected == 1:
        response ='<Response>'
        response += '<GetDigits timeout="30" numDigits="1">'
        response += '<Play url="' +request.build_absolute_uri(config.help_in_luganda.url)+'"/>'
        response += '</GetDigits>'
        response += '</Response>'
        menu = 2
        language="Luganda"

    if dtmfDigits == '1' and  current_call.call_menu_selected == 2 and current_call.language == "Luganda":   
        response = '<Response>'
        response += '<Dial record="true" sequential="true" phoneNumbers="+256773813709,+256789272217,agent1.farmercallcenter@ug.sip.africastalking.com"/>'
        response += '</Response>'
        print(response)
    
    if dtmfDigits == '2' and  current_call.call_menu_selected == 2 and current_call.language == "Luganda":   
        response = '<Response>'
        response += '<Dial record="true" sequential="true" phoneNumbers="+256772313512,+256772313512,agent1.farmercallcenter@ug.sip.africastalking.com"/>'
        response += '</Response>'
        print(response)

    elif dtmfDigits == '3' and current_call.call_menu_selected == 1:
        response = '<Response>'
        response += '<Dial record="true" sequential="true" phoneNumbers="+256774952449,+256783784498,agent2.farmercallcenter@ug.sip2.africastalking.com"/>'
        response += '</Response>'
        print("Agent 3 selected")

    elif dtmfDigits == '4' and current_call.call_menu_selected == 1:
        response = '<Response>'
        response += '<Dial record="true" sequential="true" phoneNumbers="+256772973970,+256783784498,agent3.farmercallcenter@ug.sip2.africastalking.com"/>'
        response += '</Response>'
        print("Agent 4 selected")

    elif dtmfDigits == '5' and current_call.call_menu_selected == 1:
        response = '<Response>'
        response += '<Dial record="true" sequential="true" phoneNumbers="+256782701885,+256784067089,agent3.farmercallcenter@ug.sip.africastalking.com"/>'
        response += '</Response>'
        print("Agent 5 selected")

    #updating the selected menu option of the current call
    print(menu, "This is the menu updated")
    if menu == 2:
        #try:
        current_call.call_menu_selected = 2
        current_call.language =language
        current_call.save()
        print("executed and saved the code")
        # except:
        #     print('Was unable to save')     
        
    # update call when its done
    if call_state == 'Completed':
        # update the call to record the voice
        # getting the current call
        try:
            current_call.recording_url = recording_url
            current_call.call_duration = duration_in_seconds
            current_call.agent_phone = agent_called
            current_call.save()
        except:
            pass

    return HttpResponse(response)
