<?php
 //  $servername = "server122.web-hosting.com";
 //  $username = "secvjesg_mazanlabeeb";
  // $password = "mazan labeeb";
  // $db = "secvjesg_bulk";
  

  
  
     $servername = "localhost";
     $username = "root";
     $password = "";
     $db = "bulk";

    $conn = mysqli_connect($servername,$username,$password,$db);
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }
    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>