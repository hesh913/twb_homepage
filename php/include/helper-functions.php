<?php

header('Content-type: application/json');

function generate_response($message, $type){
  $response = array(
    "message"   => $message,
    "type"      => $type
  );

  echo json_encode($response);

  if($response['type'] === -1){
    die();
  }
}

function create_settings_file($file, $content) {
  $handle = NULL;
  $file_contents = '<?php'.PHP_EOL;

  $handle = @fopen($file, "w") or generate_response("Unable to create or open file!", -1);

  if(is_array($content)){
    foreach ($content as $key => $value) {
      $file_contents .= $value;
    }
  } else {
    $file_contents .= $content;
  }

  @fwrite($handle, $file_contents) or generate_response("Unable to write to file!", -1);
  @fclose($handle);
}
