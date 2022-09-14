<?php
session_start();
if (isset($_SESSION['user']) && isset($_SESSION['loggedin'])) {
  $s_user = $_SESSION['user'];
  $loggedin = $_SESSION['loggedin'];
} else {
  header('location:index.php');
  exit;
}
?>
<?php
include "admin/includes/conn.php";
$sql = "SELECT * FROM `users` WHERE `id` = $s_user";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$r_sms = $row['messages'];
$sent = $row['sent'];

?>
<?php
require_once __DIR__ . '/admin/vendor/autoload.php';

\Telnyx\Telnyx::setApiKey('KEY017C47BCA50813F6922FDE104D44C37C_BKPhZJXT71vZw7V1v9Mq0f');



if (isset($_POST['to'])) {
  $to = mysqli_real_escape_string($conn, test_input(trim($_POST['to'])));
  $msg = test_input($_POST['msg']);

  $arr = explode(PHP_EOL, $to);
  $len = count($arr);


  $subscribers = [];

  if ($len > $r_sms) {
    echo "Your Remaining SMS has been ended. Please recharge your account. Contact Admin";
    exit();
  }

  // read the file to get phone number and API here
  $filename = "protected/.mazanlabeeb";
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
    if ($new_message = \Telnyx\Message::Create(['from' => $your_telnyx_number, 'to' => $destination_number, 'text' => $msg])) {
      echo "Message to $arr[$i] sent!<br>";
      // logs query
      $msg = mysqli_real_escape_string($conn, $msg);
      $sql_logs = "INSERT INTO `logs` (`id`, `from`, `to`, `msg`, `timestamp`) VALUES ('$s_user', '$your_telnyx_number', '$destination_number', '$msg', current_timestamp());";
      $query_logs = mysqli_query($conn, $sql_logs);

      $update = $r_sms - $len;
      $updates = $sent + $len;
      $sql2 = "UPDATE `users` SET `messages` = '$update' WHERE `users`.`id` = $s_user;";
      $sql3 = "UPDATE `users` SET `sent` = '$updates' WHERE `users`.`id` = $s_user;";
      $result2 = mysqli_query($conn, $sql2);
      $result3 = mysqli_query($conn, $sql3);
    }else{
      echo "An Error Occured! Please Contact Admin to resolve the problem!";
    }
  }
}





