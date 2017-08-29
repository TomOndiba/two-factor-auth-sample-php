<!-- This file is part of Sign-up Page Sample.

    The Sign-up Page Sample is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    The Sign-up Page Sample is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with The Sign-up Page Sample.  If not, see <http://www.gnu.org/licenses/>.  --> 
    
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
	<!-- Bootstrap framework -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"
			  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
			  crossorigin="anonymous"></script>
	<script src="js/bootstrap.min.js"></script> 
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=Cp1252">
	
	<title>Authentication Page</title>
	
</head>

<body>
	<?php
		include "authentication.php";
		// A session is required to store the auth_id value.
		// The auth_id is used to authenticate the users verification code.
		session_start();
		
		// Define variables for mobile number and error messages.
		$mobileNumber = $mNumberErr = "";
		
		//  Data validation with PHP. Check the data after a form submit(POST)
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
						
			// Mobile number data validation will check if it is a 10 digit number. No symbols such as "-", "(", ")", etc.
			if (empty($_POST["mobileNumber"])){
				$mNumberErr = "Mobile Number is required";
			} else {
				$mobileNumber = input($_POST["mobileNumber"]);
				// check if mobile number is digits
				if (!preg_match("/^\d{10}$/",$mobileNumber)) {
				$mNumberErr = "Please enter 10 digit mobile number"; 
				}
			}
		}
		
		// Strip data of special characters and tags
		function input($data) {
			$data = stripslashes(trim($data));
			return $data;
		}
			
		// Checks if mobile number is NOT NULL and empty and passes the value
		if(!(is_null($mobileNumber) || empty($mobileNumber))) {
			header("Location: verification.php");
			putAuthentication($mobileNumber);
		}
		
	?>

<div class="container">
		<center>
			<h2>Two-factor Authentication Page</h2>		
			<p>Use the form below to verify your mobile number.</p>
		</center>
	<form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <div class="form-group">
	    <label for="mobileNumber" class="col-sm-2 control-label">Mobile Number</label><span class="error"><?php echo $mNumberErr;?></span>
	    <div class="col-sm-10">
	      <input type="text" name="mobileNumber" class="form-control" id="mobileNumber" pattern="^\d{10}$" placeholder="5554443333" required>
	    </div>
	  </div>
	  <div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
	    </div>
	  </div>
	  <div><center><b>Summary Terms & Conditions:</b> By clicking submit, you agree to receive a text message to authenticate the phone number provided.
Message and data rates may apply. Text STOP to opt out. For help, Text HELP.</center>
	</div>
	</form>
</div>
</body>
</html>