<?php

include_once("include/config.php");
include_once("include/mailchimp/class.mailchimp.php");
include_once("include/helper-functions.php");

if(isset( $_POST['signup_email'] )){
  $email = htmlentities( $_POST['signup_email'] );

  switch($variant){

    case 'db':
      $con = @mysqli_connect($host, $username, $password, $database);

  		// Check connection
  		if (mysqli_connect_errno()) {
  			// Failed to connect to MySQL
        generate_response("Internal server error!", -1);
  		}
  		else{
  			$existing_signup  = @mysqli_query($con, "SELECT * FROM signups WHERE signup_email_address='$email'");

  			if(@mysqli_num_rows($existing_signup) < 1) {
  				$timestamp      = date('Y-m-d H:i:s');
  				$insert_signup  = @mysqli_query($con,"INSERT INTO signups (signup_email_address, signup_timestamp) VALUES ('$email','$timestamp')");

  				if($insert_signup) {
            generate_response("You have been signed up!", 1);
  				}
  				else {
            generate_response("Ooops, there has been a technical error!", -1);
  				}
  			}
  			else {
          generate_response("This email is already on list!", -1);
  			}
  		}

  		@mysqli_close($con);

      break;

    case 'mailchimp':
      $MailChimp = new MailChimp($api_key);

      $result = $MailChimp->post("lists/$list_id/members", [
        'email_address'   =>  $email,
        'status'          =>  'subscribed',
      ]);

      if( isset($result['id']) ) {
        generate_response("You have been signed up!", 1);
      }
      else if( isset($result['type']) ) {
        // Error info: $result['title'], $result['status'], $result['detail'], $result['errors']
        if($result['title'] === 'Member Exists'){
          generate_response($email . " is already a list member.", -1);
        } else {
          generate_response($result['detail'], -1);
        }
      }
      else {
        generate_response("Ooops, there has been a technical error!", -1);
      }

      break;
  }
}
