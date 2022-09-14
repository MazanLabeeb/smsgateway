<?php
session_start();
if (isset($_SESSION['mail']) && isset($_SESSION['loggedin'])) {
  $s_mail = $_SESSION['mail'];
  $loggedin = $_SESSION['loggedin'];
} else {
  header('location:login.php');
  exit;
}

include "includes/conn.php";

require_once __DIR__ . '/vendor/autoload.php';

if (isset($_POST['to'])) {
  $to = mysqli_real_escape_string($conn,test_input(trim($_POST['to'])));
  $msg = test_input($_POST['msg']);

  $arr = explode(PHP_EOL, $to);
  $len = count($arr);

  // Define the list of subscribers
  $subscribers = [];

  // read the file to get phone number and API here
  $filename = "../protected/.mazanlabeeb";
  // Open the file
  $fp = @fopen($filename, 'r');

  // Add each line to an array
  if ($fp) {
    $array = explode("\n", fread($fp, filesize($filename)));
  }
  fclose($fp);
  $from = substr($array[0], 5);
  $api = substr($array[1], 4);
  // FILE READ COMPLETED
  for ($i = 0; $i < $len; $i++) {
    $subscribers[$i] = json_encode(['binding_type' => "sms", 'address' => "$arr[$i]"]);
    \Telnyx\Telnyx::setApiKey($api);
    $your_telnyx_number = $from;
    $destination_number = $arr[$i];
    if($new_message = \Telnyx\Message::Create(['from' => $your_telnyx_number, 'to' => $destination_number, 'text' => $msg])){
      $msg = mysqli_real_escape_string($conn,$msg);
      $sql_logs = "INSERT INTO `logs` (`id`, `from`, `to`, `msg`, `timestamp`) VALUES ('admin', '$your_telnyx_number', '$destination_number', '$msg', current_timestamp());";
      $query_logs = mysqli_query($conn,$sql_logs);
      // json_decode($new_message,true);
      echo "<pre>";
      echo $new_message."===</pre>";
      echo "Message to $arr[$i] sent!<br>";
    }
    else{
      echo "An Error Occured! Please Contact Admin to resolve the problem!";
      break;
    }
    
  }
}
