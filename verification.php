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
	
	<title>Verification Page</title>
	
</head>
<body>
	<?php
		include "authentication.php";
		// A session is required to store the auth_id value.
		// The auth_id is used to authenticate the users verification code.
		session_start();
		
		// Define variables for verification code and error message.
		$verifyCode = $vCodeErr = "";

		//  Data validation with PHP. Check the data after a form submit(POST)
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			// Check if the verification code is empty
			if (empty($_POST["verifyCode"])) {
				$vCodeErr = "Please enter the verification code";
			} else {
				$verifyCode = $_POST["verifyCode"];
			}
		}
		
		// Check if verifyCode as a value
		// Store the auth_id into the session and pass to POST Authenticate
		if(!(is_null($verifyCode) || empty($verifyCode))) {
			$auth_id = $_SESSION["auth_id"];
			postAuthentication($auth_id, $verifyCode);
		}

	?>
	
<div class="container">
		<center>
			<h2>Two-factor Verification Page</h2>		
			<p>Please enter the verification code.</p>
		</center>
	<form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <div class="form-group">
	    <label for="verifyCode" class="col-sm-2 control-label">Verification Code</label><span class="error"><?php echo $vCodeErr;?></span>
	    <div class="col-sm-10">
	      <input type="text" name="verifyCode" class="form-control" id="verifyCode" required>
	    </div>
	  </div>
	  <div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
	    </div>
	  </div>
	  <div><center><b>Summary Terms & Conditions:</b> Message and data rates may apply. Text STOP to opt out. For help, Text HELP.</center>
	</div>
	</form>
</div>
</body>