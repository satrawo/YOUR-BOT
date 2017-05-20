<?php

$access_token = "EAADe2JW07d4BAKtEMGXmhf75gES4WHly98Cv3rEYcaQYOcTsPl0NZAGqlNu8n2t2AwW7dD0O4MZAN91JrGfKdyYGrRKRY3PfNr4AzDoU0VIT1pWpXtob9f0LT5pS3ekfzmrDkIYWN7uFOuwD7AC62zGxKM1NSUZATqI566bZCQZDZD";

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'abc123') {
  echo $challenge;
}

$input = json_decode(file_get_contents('php://input'), true);
$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = $input['entry'][0]['messaging'][0]['message']['text'];
$message_to_reply = '';

/* Recieve the message */
if(preg_match('[time|current time|now]', strtolower($message))) {
	
	date_default_timezone_set("Asia/Bangkok");
	$date = date('m/d/Y h:i:s a', time());

	$message_to_reply = $date;

} 
else {
    $message_to_reply = 'Huh! what do you mean?';
}
//API Url
$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$access_token;
//Initiate cURL.
$ch = curl_init($url);
//The JSON data.
$jsonData = '{
	"setting_type":"greeting",
  	"greeting":{
    	"text":"Hi {{user_first_name}}, welcome to this bot."
  	}
    "recipient":{
        "id":"'.$sender.'"
    },
    "message":{
        "text":"'.$message_to_reply.'"
    }
}';
//Encode the array into JSON.
$jsonDataEncoded = $jsonData;

//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);

//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
//Execute the request
if(!empty($input['entry'][0]['messaging'][0]['message'])){
    $result = curl_exec($ch);
}
