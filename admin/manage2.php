<?php
      session_start();
      if(isset($_SESSION['mail']) && isset($_SESSION['loggedin'])){
        $s_mail = $_SESSION['mail'];
        $loggedin = $_SESSION['loggedin'];
      }
      else{
        header('location:admin/');
        exit;
      }
?>

<?php
include "includes/conn.php";
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $sql3 = "DELETE FROM `users` WHERE `users`.`id` = $delete";
    $delete_result = mysqli_query($conn, $sql3);
    if($delete_result) echo "<b>Account Deleted Succesffully</b> ";
    echo '<!doctype html>
    <html lang="en">
      <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="refresh" content="5;url=manage.php"> 
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <link rel="icon" href="../favicon.ico">
        <title>Deleted</title>
      </head>
      <body>
        <br>
        Redirecting in 5 seconds...
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
      </body>
    </html>';
    exit();
}
if (isset($_POST['update'])) {
    $id2 = $_GET['id'];
    $user2 = $_POST['user'];
    $messages2 = $_POST['messages'];
    $pass2 = $_POST['pass'];
    $sql2 = "UPDATE `users` SET `user` = '$user2', `pass` = '$pass2', `messages` = '$messages2' WHERE `users`.`id` = $id2;  ";
    $result = mysqli_query($conn, $sql2);
    if($result) echo "Details updated";
}
if (isset($_GET['id'])) {
    
    $id = $_GET['id'];
    $sql = "SELECT * FROM `users` WHERE `id` = $id  ";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="styles/dashboard.css"> -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <title>Edit User Details!</title>
</head>

<body>
    <?php
    include "includes/header.php";
    ?>
    <div class="container" style="max-width: 400px;">
        <form class="text-primary" action="manage2.php?id=<?php echo $row['id']; ?>" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Unique id</label>
                <input type="text" value="<?php echo $row['id']; ?>" disabled name="id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Username</label>
                <input type="text" value="<?php echo $row['user']; ?>" name="user" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="text" value="<?php echo $row['pass']; ?>" name="pass" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">No. of Messages </label>
                <input type="number" value="<?php echo $row['messages']; ?>" placeholder="10000" name="messages" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>

            <button type="submit" name="update" class="btn btn-success btn-sm">Change Credentials</button>
        </form>
            <a href="manage2.php?delete=<?php echo $row['id']; ?>"> <button type="submit" name="update" class="btn btn-danger btn-sm mt-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
  <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
  <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
</svg> Delete this User</button></a>
<br>
<a href="manage.php"> <button type="submit" name="update" class="btn btn-primary btn-sm mt-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
  <path d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1z"/>
</svg>
</svg> Go back to Cpanel</button></a>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>