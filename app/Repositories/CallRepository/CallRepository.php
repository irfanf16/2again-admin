<?php

namespace App\Repositories\CallRepository;

use App\Repositories\CallRepository\iCallRepository;
use Illuminate\Http\Request;
use Twilio\Http\Response;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VoiceGrant;
use Twilio\TwiML\VoiceResponse;
use Twilio\Jwt\Grants\VideoGrant;

class CallRepository implements iCallRepository{

    public function token(Request $request){
        $data = $request->all();

    	$twilioAccountSid = env("TWILIO_ACCOUNT_SID");
		$twilioApiKey = env("TWILIO_API_KEY_SID");
		$twilioApiSecret = env("TWILIO_API_KEY_SECRET");
        $push_sid   = env('TWILIO_PUSH_SID');

		// Required for Voice grant
		$outgoingApplicationSid = env("TWILIO_SID");
		// An identifier for your app - can be anything you'd like
		$identity = $data["identity"]; // Jack // Client name

		// Create access token, which we will serialize and send to the client
		$token = new AccessToken(
		    $twilioAccountSid,
		    $twilioApiKey,
		    $twilioApiSecret,
		    3600,
		    $identity
		);

		// Create Voice grant
		$voiceGrant = new VoiceGrant();
		$voiceGrant->setOutgoingApplicationSid($outgoingApplicationSid);
        // $voiceGrant->setPushCredentialSid($push_sid);

		// Optional: add to allow incoming calls
		$voiceGrant->setIncomingAllow(true);

		// Add grant to token
		$token->addGrant($voiceGrant);

		return response()->json([
			"identity" => $data['identity'],
			"token" => $token->toJWT()
		]);
    }

    public function voice(Request $request){

        $data = $request->all();
    	$response = new VoiceResponse();

    	// make sure you passing caller id from client side.
    	// Twilio.Device.connect(params); <----- in param object
		$dial = $response->dial('', ['callerId' => $data["outgoing_caller_id"]]);
		$client = $dial->client($request->To);

		// Sending custom parameters, We will use in client side
		$client->parameter([
            "name" => "outgoing_caller_id",
            "value" => $data["outgoing_caller_id"],
        ]);

        $client->parameter(['name' => 'caller_name', 'value' => $data['caller_name']]);
        $client->parameter(['name' => 'caller_image', 'value' => $data['caller_image']]);

       return $response;
    }

}
