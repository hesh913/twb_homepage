<?php
  session_start();

  include_once("../include/helper-functions.php");

  $settings_file = dirname(dirname(__FILE__)) . "/include/config.php";
  $step          = isset($_POST['step']) ? $_POST['step'] : '';

  if(!empty($step)) {
    switch ($step) {

      case 'option':

        if( isset($_POST["variant"]) ) {
          $variant = $_POST["variant"];

          $_SESSION["settings"]["option"] = '$variant = "' . $variant . '";' . PHP_EOL;
        }
        else {
          generate_response("Choose a variant!", -1);
        }
        break;

      case 'db':

        if( isset($_POST) ) {
          $database_host		  = isset($_POST['database_host']) ? $_POST['database_host'] : "";
          $database_name		  = isset($_POST['database_name']) ? $_POST['database_name'] : "";
          $database_username	= isset($_POST['database_username']) ? $_POST['database_username'] : "";
          $database_password	= isset($_POST['database_password']) ? $_POST['database_password'] : "";

          $conn = @mysqli_connect($database_host, $database_username, $database_password, $database_name);

          if (!$conn) {
            generate_response("Connection failed: Check your credentials.", -1);
          }

          if ($conn->connect_error) {
            generate_response("Connection failed: " . $conn->connect_error, -1);
          } else {
              $sql = "CREATE TABLE signups (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                signup_email_address VARCHAR(250) NOT NULL,
                signup_timestamp timestamp NOT NULL
              )";

              if ($conn->query($sql) === TRUE) {
                $content = [
                  '$host = "' . $database_host . '";',
                  '$username = "' . $database_username . '";',
                  '$password = "' . $database_password . '";',
                  '$database = "' . $database_name . '";'
                ];

                $content = implode(PHP_EOL, $content);

                $_SESSION["settings"]["db"] = $content.PHP_EOL;

              } else {
                generate_response("Error creating table: " . $conn->error, -1);
              }

              $conn->close();
          }
        }

        break;

      case 'mailchimp':

        if( isset($_POST["list_id"]) && isset($_POST["api_key"]) ){
          $list_id = $_POST["list_id"];
          $api_key = $_POST["api_key"];

          $content = [
            '$list_id = "' . $list_id . '";',
            '$api_key = "' . $api_key . '";'
          ];

          $content = implode(PHP_EOL, $content);

          $_SESSION["settings"]["mailchimp"] = $content.PHP_EOL;

        } else {
          generate_response("List ID or API key cannot be empty!", -1);
        }

        break;

      case 'contact':

        if( isset($_POST["contact_email"]) && isset($_POST["contact_subject"]) ){
          $contact_email = $_POST["contact_email"];
          $contact_subject = $_POST["contact_subject"];

          $content = [
            '$to = "' . $contact_email . '";',
            '$subject = "' . $contact_subject . '";'
          ];

          $content = implode(PHP_EOL, $content);

          $_SESSION["settings"]["contact"] = $content.PHP_EOL;

        } else {
          generate_response("Contact email or subject cannot be empty!", -1);
        }

        break;

      case 'finish':

        create_settings_file($settings_file, $_SESSION["settings"]);

        break;
    }
  }
