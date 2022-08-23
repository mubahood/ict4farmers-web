<?php

require 'vendor/autoload.php';
use AfricasTalking\SDK\AfricasTalking;
use App\Models\Call;
use App\Models\Configuration;


// Set your app credentials
$username = "MyAppUsername";
$apikey   = "MyAppAPIKey";

// Initialize the SDK
$AT       = new AfricasTalking($username, $apiKey);

// Get the voice service
$voice    = $AT->voice();

// Set your Africa's Talking phone number in international format
$from     = "+256778945859";

// Set the numbers you want to call to in a comma-separated list
$to       = "+256778945859";

try {
    // Make the call
    $results = $voice->call([
        'from' => $from,
        'to'   => $to
    ]);
    print_r($results);

} catch (Exception $e) {
    echo "Error: ".$e->getMessage();
}
