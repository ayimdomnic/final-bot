<?php

// Report all errors except E_NOTICE
// This is the default value set in php.ini
error_reporting(E_ALL & ~E_NOTICE);

$VERIFY_TOKEN = 'V@r1@bl3';
$PAGE_ACCESS_TOKEN = 'EAAYCw0gPu9ABAHg631JZBg148qJzdCFYfoejEg21SJwOEHnGQ0Td98ZCl1YIRAvjoSbTneg9dnWC2LYI9Yhnt3fncZA8sZChRVREYoZCHTnpBJ5042cZBvNQ0qH0cxWXT22yiQgOhStAZBJIZCFKhRdEtekoZCah00kPB2NJNWPrm9AZDZD';

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];
if ($verify_token === $VERIFY_TOKEN) {
  	//If the Verify token matches, return the challenge.
  	echo $challenge;
}else {
	print "Hello World!";

	// **************************
	// Paste Step 8.txt Part A Here.
	// **************************
	//Step 8

//Part A  ******************************************************************
//Paste part A into index.php 

$input = json_decode(file_get_contents('php://input'), true);
	// Get the Senders Page Scoped ID
	$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
	// Get the message text sent
	$message = $input['entry'][0]['messaging'][0]['message']['text'];

	if(!empty($message)){
		if($message == 'image'){
			send_image_message($sender,'http://thecatapi.com/api/images/get?format=src&type=gif', $PAGE_ACCESS_TOKEN);
		}else{
			send_text_message($sender, "Cock Sure", $PAGE_ACCESS_TOKEN);
		}
	}



// END OF PART A  *********************************************************
}


// **************************
// Paste Step 8.txt Part B Here.
// **************************
//Part B  *****************************************************************
//Paste part B into index.php 


function send_message($access_token, $payload) {
	// Send/Recieve API
	$url = 'https://graph.facebook.com/v2.6/me/messages?access_token=' . $access_token;
	// Initiate the curl
	$ch = curl_init($url);
	// Set the curl to POST
	curl_setopt($ch, CURLOPT_POST, 1);
	// Add the json payload
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	// Set the header type to application/json
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	// SSL Settings
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// Send the request
	$result  = curl_exec($ch);
	//Return the result
	return $result;
}

function build_text_message_payload($sender, $message){
	// Build the json payload data
	$jsonData = '{
	    "recipient":{
	        "id":"' . $sender . '"
	    }, 
	    "message":{
	        "text": "'. $message .'"
	    }

	}';
	return $jsonData;
}

function send_text_message($sender, $message, $access_token){
	$jsonData = build_text_message_payload($sender, $message);
	$result = send_message($access_token, $jsonData);
	return $result;
}

// TODO: Step 9 - Complete this function
// https://developers.facebook.com/docs/messenger-platform/send-api-reference/image-attachment
function build_image_message_payload($sender, $image_url){
	// Build the json payload data
	return '';
}

function send_image_message($sender, $image_url, $access_token){
	$jsonData = build_image_message_payload($sender, $image_url);
	$result = send_message($access_token, $jsonData);
	return $result;
}



// END OF PART A  *******************************************************
