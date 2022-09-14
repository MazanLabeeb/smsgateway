<?php
$page = "index.php";
session_start();
if (isset($_SESSION['mail']) && isset($_SESSION['loggedin'])) {
  $s_mail = $_SESSION['mail'];
  $loggedin = $_SESSION['loggedin'];
} else {
  header('location:login.php');
  exit;
}
?>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.84.0">
  <title>Bulk SMS Sender</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">



  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

  <!-- Favicons -->
  <link rel="icon" href="../favicon.ico">
  <meta name="theme-color" content="#7952b3">


  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="../src/styles/dashboard.css" rel="stylesheet">
  <style type="text/css">
    /* Chart.js */
    @keyframes chartjs-render-animation {
      from {
        opacity: .99
      }

      to {
        opacity: 1
      }
    }

    .chartjs-render-monitor {
      animation: chartjs-render-animation 1ms
    }

    .chartjs-size-monitor,
    .chartjs-size-monitor-expand,
    .chartjs-size-monitor-shrink {
      position: absolute;
      direction: ltr;
      left: 0;
      top: 0;
      right: 0;
      bottom: 0;
      overflow: hidden;
      pointer-events: none;
      visibility: hidden;
      z-index: -1
    }

    .chartjs-size-monitor-expand>div {
      position: absolute;
      width: 1000000px;
      height: 1000000px;
      left: 0;
      top: 0
    }

    .chartjs-size-monitor-shrink>div {
      position: absolute;
      width: 200%;
      height: 200%;
      left: 0;
      top: 0
    }
  </style>
</head>

<body>

  <?php include "includes/header.php"; ?>
  <?php include "includes/sidebar.php"; ?>
  <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" id="main">
    <?php
    // $users = 100;
    require "includes/conn.php";
    $sql = "SELECT * FROM `users`";
    $result = mysqli_query($conn, $sql);
    $users = mysqli_num_rows($result);
    $sent = 0;
    $total = [];
    if ($users > 0) {

      while ($row = mysqli_fetch_assoc($result)) {
        $total[] = $row['sent'];
      }
    }
    for ($i = 0; $i < count($total); $i++) {
      $sent += $total[$i];
    }

    $sql_admin = "SELECT * FROM `logs` WHERE `id` = 'admin'";
    $result_admin = mysqli_query($conn, $sql_admin);
    $sent_admin = mysqli_num_rows($result_admin);
    ?>

    <div class="chartjs-size-monitor">
      <div class="chartjs-size-monitor-expand">
        <div class=""></div>
      </div>
      <div class="chartjs-size-monitor-shrink">
        <div class=""></div>
      </div>
    </div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Dashboard</h1>

      <div class="btn-toolbar mb-2 mb-md-0">
      </div>
    </div>
    <div>
      <div class="row ">
        <!-- <div class="card bg-info text-white" style="width: 18rem;margin-right:15px ;margin-top:15px;">
          <div class="card-body">
            <h5 class="card-title">Total Balance remaining</h5>
            <h1><?php echo "$50"; ?></h1>
          </div>
        </div> -->

        <div class="card bg-primary text-white mx-auto" style="width: 18rem;margin-right:15px ;margin-top:15px;">
          <div class="card-body">
            <h5 class="card-title">Total Users</h5>
            <h1><?php echo $users; ?></h1>
          </div>
        </div>

        <div class="card bg-info text-white mx-auto" style="width: 18rem;margin-right:15px ;margin-top:15px;">
          <div class="card-body">
            <h5 class="card-title">Total SMS sent(by Gateway)</h5>
            <h1><?php echo $sent; ?></h1>
          </div>
        </div>
        <div class="card bg-secondary text-white mx-auto" style="width: 18rem;margin-right:15px ;margin-top:15px;">
          <div class="card-body">
            <h5 class="card-title">Total SMS sent(by Admin)</h5>
            <h1><?php echo $sent_admin; ?></h1>
          </div>
        </div>

        <br>
        <!-- display graphs here  -->
        <!-- DISPLAY GRAPHS SECTION STARTS HERE  -->
        <h3 class="mt-2 text-secondary">Graphs:</h3>
        <?php
        $sql_x = "SELECT * FROM `users`";
        $query_x = mysqli_query($conn, $sql_x);
        $count_x = mysqli_num_rows($query_x);
        if ($count_x > 0) {
          $arr_x = [];
          $arr_y = [];
          $arr_color = [];
          $colorlist = ["red", "green", "blue", "orange", "brown", "black", "grey", "yellow", "cyan"];
          while ($row_x = mysqli_fetch_assoc($query_x)) {
            array_push($arr_x, $row_x['user']);
            $id_graph = $row_x['id'];
            $sql_y = "SELECT * FROM `logs` WHERE `id` = '$id_graph'";
            $query_y = mysqli_query($conn, $sql_y);
            $count_y = mysqli_num_rows($query_y);
            array_push($arr_y, $count_y);

            $rand = rand(0, 8);
            array_push($arr_color, $colorlist[$rand]);
          }
          $arr_x = json_encode($arr_x);
          $arr_y = json_encode($arr_y);
          $arr_color = json_encode($arr_color);
        }
        ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
        <canvas id="myChart" style="width:100%;max-width:600px;"></canvas>

        <script>
          var xValues = <?php echo $arr_x ?>;
          var yValues =  <?php echo $arr_y ?>; 

          var barColors = <?php echo $arr_color; ?>;

          new Chart("myChart", {
            type: "bar",
            data: {
              labels: xValues,
              datasets: [{
                backgroundColor: barColors,
                data: yValues
              }]
            },
            options: {
              legend: {
                display: false
              },
              title: {
                display: true,
                text: "SMS sent by users"
              },
              scales: {
                yAxes: [{
                  scaleLabel: {
                    display: true,
                    labelString: 'Messages'
                  }
                }],
                xAxes: [{
                  scaleLabel: {
                    display: true,
                    labelString: 'Users'
                  }
                }]
              }
            }
          });
        </script>


      </div>





    </div>

    </div>
    </div>


  </main>
  </div>
  </div>


  <script src="https://getbootstrap.com/docs/5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>


</body>

</html>