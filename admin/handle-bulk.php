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
// EXCEL FILE CONTENT
require '../src/excel/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


// mysqli_stmt_get_warnings();

// Update the path below to your autoload.php, 
// see https://getcomposer.org/doc/01-basic-usage.md 
require_once 'vendor/autoload.php';
use Twilio\Rest\Client;


if(isset($_POST['submit'])){
    // $to = trim($_POST['to']);
    $file=$_FILES['doc']['tmp_name'];
	
	$ext=pathinfo($_FILES['doc']['name'],PATHINFO_EXTENSION);
	if($ext=='xlsx' or  $ext=='xls' or $ext=='csv'){
		

                $inputFileName = $file;

                /** Load $inputFileName to a Spreadsheet Object  **/
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
                $data = $spreadsheet->getActiveSheet()->toArray();
                $arr = [];
                $jumper = 0;
                foreach($data as $row){
                    if($jumper == 0){
                      $jumper = 1;
                    }else{
                      $id = "+".$row['0'];
                    array_push($arr,$id);
                    }                    
                }

		}
    $msg = $_POST['msg'];
    $len = count($arr);
    
    
$textarea = [];
  for ($i = 0; $i < $len; $i++) {
    array_push($textarea, $arr[$i]);
  }

}

?>

<!-- start html  -->


<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <link rel="stylesheet" href="../src/styles/dashboard.css">
  <title>Send single message</title>
  <script src="../src/js/jquery-3.6.0.min.js"></script>
  <link rel="icon" href="../favicon.ico">
</head>

<body>
  <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" id="main">

    <!-- smssendform -->

    <div class="chartjs-size-monitor">
      <div class="chartjs-size-monitor-expand">
        <div class=""></div>
      </div>
      <div class="chartjs-size-monitor-shrink">
        <div class=""></div>
      </div>
    </div>
    <div>
    </div>
    <div class="forM" style="max-width: 500px; margin:auto;">
      <!-- send form  -->
      <form style=" padding:14px" id="form" >


        <div class="form-floating" style="display: none !important;">
          <textarea style="height:80px;" class="form-control to" name="to" placeholder="Leave a comment here" id="floatingTextarea"><?php 
  foreach($textarea as $foo){
    echo $foo."\r";
  }
?></textarea>
          <label for="floatingTextarea">To</label>
        </div>
        <!-- <textarea placeholder="+12233441242 &#10;+11234567890 &#10;+19383432487 &#10;+13245234352 &#10;+13245234535" rows="5" name="to" id=""></textarea> -->

        <br>

        <div class="form-floating" style="display: none !important;">
          <textarea name="msg" style="height:150px;" class="form-control msgbox msgtext" placeholder="Leave a comment here" id="floatingTextarea"><?php 
          echo $msg;
?></textarea>
          <label for="floatingTextarea">Message</label>
          <span class="msg">Message : 0</span><span style="float:right;" class="msglen">Message Characters: 0</span>
        </div>
        <br>
        <input type="button" id="send" class="btn btn-dark" value="Click here to confirm sending">
      </form>
      <div class="logbox" style="display:none;">Total Messages Sent: <input type="text" value="0" id="sent" disabled /></div>
      <div class="log">
      </div>

    </div>




  </main>
  </div>
  </div>
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>

<script>
  function change() {
    var a = "Message Characters: ";
    var cont = $(".msgbox").val().trim().length;
    $(".msglen").html(a + cont);
    var msg = Math.ceil(cont / 160);
    $(".msg").html("Message : " + msg + " ");
    if (msg > 0)
      $(".msg").css("color", "green");
    else $(".msg").css("color", "black");
  }
  $(document).ready(function() {
    
    // sent bulk script
    // start blast
    $("#send").click(function chalo() {

      var msg = $(".msgtext").val();
      var to = $(".to").val().trim();
      var lines = to.split(/\r|\r\n|\n/);
      var count = lines.length;
      var sent = $("#sent").val();
      var to2 = lines[sent];
      if (sent < count) {
        $.ajax({
          url: 'handle-single.php',
          method: 'POST',

          data: {
            to: to2,
            msg: msg
          },
          success: function(data) {
            $(".log").prepend(data);
            $("#sent").val(Number(sent) + 1);
            $("#form").hide();
            $(".logbox").show();
            chalo();
          }

        });
      }
    });


    // count message size
    $(".msgbox").on("input", function() {
      change();
    });
  });
</script>
<?php