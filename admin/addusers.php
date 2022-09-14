<?php
      session_start();
      if(isset($_SESSION['mail']) && isset($_SESSION['loggedin'])){
        $s_mail = $_SESSION['mail'];
        $loggedin = $_SESSION['loggedin'];
      }
      else{
        header('location:login.php');
        exit;
      }
?>
<?php
include "includes/conn.php";
$page = "addusers.php";
$success = 0;
if (isset($_POST['submit'])) {
    $user = mysqli_real_escape_string($conn, test_input($_POST['user']));
    $pass = mysqli_real_escape_string($conn, test_input($_POST['pass']));
    $messages = mysqli_real_escape_string($conn, test_input($_POST['messages']));

    if ($user == "" or $pass == "") {
        echo "Username and Password cannot be empty!";
        exit();
    }
    if (!is_numeric(($messages))) {
        echo "Please enter valid no. of Messages.";
        exit();
    }

    $sql = "SELECT * FROM `users` WHERE `user` = '$user'";
    $result = mysqli_query($conn, $sql);
    $already = mysqli_num_rows($result);
    if ($already > 0) {
        echo "Another user with the name <b>$user</b> already exists! ";
        exit();
    }

    $query = "INSERT INTO `users` (`id`, `user`, `pass`, `messages`, `timestamp`) VALUES (NULL, '$user', '$pass', '$messages', current_timestamp());";

    $result = mysqli_query($conn, $query);
    $success = 0;
    if ($result) $success = 1;
    else $success = 0;

    // echo $result.$alert;
    $log = "Following user has been added succesfully:<br>";
    $log .= "<b>User: </b>$user<br><b>Pass:</b> $pass<br><b>Messages:</b> $messages<hr>";
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="../src/styles/dashboard.css">
    <title>Add a User</title>
    <link rel="icon" href="../favicon.ico">
</head>

<body>
    <?php
    include "includes/header.php";
    include "includes/sidebar.php";
    ?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" id="main">


        <div class="container mt-2" style="max-width: 400px;" >
            <!-- alert boxes  -->
            <div id="success" class="alert alert-success alert-dismissible fade <?php if ($success == 1) echo "show";
                                                                                else echo "hide";  ?>" style="max-width:400px;padding: 7px!important;" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                <strong></strong> User Added Successfully!
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>


            <?php
            if ($success == 1)  echo $log;
            ?>
            <h5 class="text-primary">Add your users here and set their messages limit.</h5>
            <form class="text-primary" action="addusers.php" method="post">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="text" name="user" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="pass" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">No. of Messages </label>
                    <input type="number" placeholder="10000" name="messages" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>

                <button type="submit" name="submit" class="btn btn-success btn-sm">Add a user</button>
            </form>
        </div>




    </main>
    </div>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>