<?php
	/* This file is part of Sign-up Page Sample.

    The Sign-up Page Sample is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    The Sign-up Page Sample is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with The Sign-up Page Sample.  If not, see <http://www.gnu.org/licenses/>.
	/* Work flow
	 * 1. User enters phone number.
	 * 2. API send authentication code.
	 * 3. User verifies code into form.
	 */

// It is important to download and include the "request_rest.php" file.
include "request_rest.php";

// File contains information for debugging.
include "info.php";

// Account information and validation.
// Replace $myUsername with the proper username and $myKey with the API key
// Get your free Trumpia API Key at http://api.trumpia.com
$apikey = $myKey;
$username = $myUsername;

// This function will send a text message with the authentication code
function putAuthentication($mobileNumber) {
	
	// Account information
	global $apikey, $username;
	
	// Generating the URL to search for a subscription
	$request_url = "http://api.trumpia.com/rest/v1/" . $username . "/authentication/sms";
	
	// Request variables
	$request_data = array(
		"mobile_number" => $mobileNumber,
		"country_code" => "1",
		"message" => "Thank you for joining! The verification code is: [\$code]",
		"char_type" => "1", // Value: 1 = numeric, 2 = alphanumeric
		"length" => "4", // Character length of code
		"valid_period" => "10" // Code will expire in X minutes (Range: 1-30)
		);

	// Creating a request
	$request_rest = new RestRequest();
	$request_rest->setRequestURL($request_url);
	$request_rest->setAPIKey($apikey);
	$request_rest->setRequestBody(json_encode($request_data));
	$request_rest->setMethod("PUT");
	$result = $request_rest->execute();
	$response_status = $result[0];
	$json_response_data = $result[1];
	
	// Decode the JSON response into a string
	$json_data = json_decode($json_response_data, true);
	// Store the request_id value. The request_id is used to check the status of the API request with GET Report.
	$request_id = $json_data['request_id'];
	
	// Send the request_id to the GET Report function.
	getReport($request_id);
	
	return;
}

// This function will verify the authentication code
function postAuthentication($auth_id, $code) {
	
	// Account information
	global $apikey, $username;
	
	// Setting up the date format. Update with your time zone.
	date_default_timezone_set('America/Los_Angeles');
	$date = date('Y-m-d H:i:s');
	
	// GET Report URL
	$request_url = "http://api.trumpia.com/rest/v1/" . $username . "/verification/sms";
	$request_url = $request_url . "/" . $auth_id;
	
	// Parameters and values for the request
	$request_data = array(
		"code" => $code,
		"request_date" => $date,
		);

	// Create new request
	$request_rest = new RestRequest();
	$request_rest->setRequestURL($request_url);
	$request_rest->setAPIKey($apikey);
	$request_rest->setRequestBody(json_encode($request_data));
	$request_rest->setMethod("POST");
	$result = $request_rest->execute();
	$response_status = $result[0];
	$json_response_data = $result[1];
	
	// decode json into string
	$json_data = json_decode($json_response_data, true);
	
	if(isset($json_data["request_id"])) {
		$request_id = $json_data["request_id"];
		getReport($request_id);
		
	} elseif(isset($json_data["status_code"])) {
		$status_code = $json_data["status_code"];
		
		if($status_code == "MREE2551") {
			errorAuth("Verification failed, please check verification code.");
		} elseif($status_code == "MRCE0000") {
			validAuth("Verification successful!");
		}
	}

	return;
}

// Get Report function will check the request_id and find the status of the API request.
// This function will also handle the error messages depending on the status_code.
function getReport($request_id) {

	// Account information
	global $apikey, $username;
	
	// Generating the URL for GET Report
	$request_url = "http://api.trumpia.com/rest/v1/" . $username . "/report/" . $request_id;
	
	// Creating a request
	$request_rest = new RestRequest();
	$request_rest->setRequestURL($request_url);
	$request_rest->setAPIKey($apikey);
	$request_rest->setMethod("GET");
	$result = $request_rest->execute();
	$response_status = $result[0];
	$json_response_data = $result[1];
		    
	// Decode the JSON response into a string.
	$json_data = json_decode($json_response_data, true);
	
	// Check to see if the "status_code" parameter exists in the JSON response.
	// Use the status_code to identify any issues.
	if(isset($json_data["status_code"])) {
		// Set status_code to current status_code response
		$status_code = $json_data["status_code"];
		
		// The system is still processing the request if the status code is MPCE4001
		// Continue to GET Report if status_code is in progress
		// Information on status codes can be found at: http://api.trumpia.com/docs/rest/status-code.php
		if($status_code == "MPCE4001"){ // Continue to GET Report if status_code is in progress
			sleep(1);
			getReport($request_id);
		
		// Status code MRCE0000 means the request has been processed
		// Store the auth_id and pass through session
		} elseif($status_code == "MRCE0000") {
			$auth_id = $json_data["auth_id"];
			$_SESSION["auth_id"] = $auth_id;
			alert("Message sent - please check your phone");
		} 
	}
	
	return $json_data;
}

// Javascript pop-up error message function
function alert($message) {
    echo "<script type='text/javascript'>if(!alert('$message'));</script>";
}

// Javascript pop-up error message function
function errorAuth($message) {
	// header( 'Location: verification.php' ) ;
	echo "<script type='text/javascript'>if(!alert('$message')){window.location.href = 'verification.php';}</script>";
}

// Javascript pop-up valid message function
function validAuth($message) {
	// header( 'Location: complete.php' ) ;
	echo "<script type='text/javascript'>if(!alert('$message')){window.location.href = 'complete.php';}</script>";
}

?>