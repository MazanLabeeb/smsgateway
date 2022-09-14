<?php
session_start();
if (isset($_SESSION['mail']) && isset($_SESSION['loggedin'])) {
  $s_mail = $_SESSION['mail'];
  $loggedin = $_SESSION['loggedin'];
} else {
  header('location:admin/');
  exit;
}
?>

<?php
$page = "send.php";
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
  <title>Send messages in Bulk</title>
  <script src="../src/js/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="../favicon.ico">
</head>

<body>
  <?php
  include "includes/header.php";
  include "includes/sidebar.php";
  ?>

  <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" id="main">


    <div class="chartjs-size-monitor">
      <div class="chartjs-size-monitor-expand">
        <div class=""></div>
      </div>
      <div class="chartjs-size-monitor-shrink">
        <div class=""></div>
      </div>
    </div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Send</h1> Send bulk messages


    </div>
    <div>

    </div>
    <div class="forM" style="max-width: 500px; margin:auto;">
      <div style="padding-left:15px;">
        <a href="../src/template.xls" class="btn btn-success btn-sm mt-n5"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-download" viewBox="0 0 16 16">
            <path d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z" />
            <path d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708l3 3z" />
          </svg> Download Template file</a>
        <span class="text-success">Download Template Excel file here.</span>
      </div>

      <form method="post" action="handle-bulk.php" style=" padding:14px;padding-top:0px;" enctype="multipart/form-data">


        <div class="mb-3">
          <label for="formFileSm" class="form-label text-danger">Accepted file formats: xlsx, xls, csv</label>
          <input class="form-control form-control-sm" name="doc" id="formFileSm" type="file">
        </div>
        <!-- <textarea placeholder="+12233441242 &#10;+11234567890 &#10;+19383432487 &#10;+13245234352 &#10;+13245234535" rows="5" name="to" id=""></textarea> -->

        <div class="form-floating">
          <textarea name="msg" style="height:150px;" class="form-control msgbox" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
          <label for="floatingTextarea">Message</label>
          <span class="msg">Message : 0</span><span style="float:right;" class="msglen">Message Characters: 0</span>
        </div>

        <input type="submit" class="btn btn-dark mt-2" name="submit" value="Send">
      </form>
    </div>

  </main>
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>
<script>
  function change() {
    var a = "Message Characters: ";
    var cont = $(".msgbox").val().trim().length;
    $(".msglen").html(a + cont);
    var msg = Math.ceil(cont/160);
    $(".msg").html("Message : " + msg+ " ");
    if(msg>0)
      $(".msg").css("color","green");
      else   $(".msg").css("color","black");
  }
  $(document).ready(function() {
    $(".msgbox").on("input", function() {
      change();
    });
  });
</script>