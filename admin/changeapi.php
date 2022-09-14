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
$changed = false;
$page = "changeapi.php";
if (isset($_POST['change'])) {
    $sid = $_POST['from'];
    $token = $_POST['api'];

    
    $filename = "../protected/.mazanlabeeb";

    $fp = fopen($filename, 'w');
    fwrite($fp, 'from=' . $sid . "\n");
    fwrite($fp, 'api=' . $token . "\n");
    fclose($fp);

    $changed = true;
    // the content of 'data.txt' is now 123 and not 23!

}
$filename = "../protected/.mazanlabeeb";
// Open the file
$fp = @fopen($filename, 'r');

// Add each line to an array
if ($fp) {
    $array = explode("\n", fread($fp, filesize($filename)));
}
fclose($fp);

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
    <title>Change API</title>
    <link rel="icon" href="../favicon.ico">
</head>

<body>
    <?php
    include "includes/header.php";
    ?>
    <?php include "includes/sidebar.php"; ?>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" id="main">

        <!-- smssendform -->
        <div class="container mt-2 text-success" style="max-width: 450px;font-size:13px;">
        <?php
            if($changed){
                echo '<div class="alert alert-success" role="alert"  style="padding: 5px !important;">
                        Twilio API changed successfully!
                    </div>';
            }
        ?>
        <h5 style="text-decoration: underline;">Change your telynx account Details here:</h5>
        <form method="post" action="">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Your Purchased Phone Number</label>
                <input type="text" name="from" value="<?php echo substr($array[0], 5); ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Telynx API</label>
                <input type="text" name="api" value="<?php echo substr($array[1], 4); ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <button type="submit" name="change" class="btn btn-success btn-sm">Change</button>
        </form>
    </div>


      </main>
    </div>
  </div>
    
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>