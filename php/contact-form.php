<?php

include_once("include/config.php");
include_once("include/helper-functions.php");

if( isset( $_POST['name'] ) && isset( $_POST['contact_email'] ) && isset( $_POST['message'] ) ){
  $name     = htmlentities( $_POST['name'] );
  $from     = htmlentities( $_POST['contact_email'] );
  $message  = htmlentities( $_POST['message'] );

	$subject  = "Message from " . $name;

	if ( mail($to, $subject, $message, $from) ) {
    generate_response('Sent!', 1);
	} else {
    generate_response('Error! Unable to send the message.', -1);
	}
}
