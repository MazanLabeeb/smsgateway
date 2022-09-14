<?php
session_start();
if (isset($_SESSION['user']) && isset($_SESSION['loggedin'])) {
  $s_user = $_SESSION['user'];
  $loggedin = $_SESSION['loggedin'];
} else {
  header('location:login.php');
  exit;
}
?>

<?php
$page = "index.php";
?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.84.0">
  <title>Bulk SmS Sender</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">



  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

  <!-- Favicons -->
  <link rel="icon" href="favicon.ico">
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
  <link href="src/styles/dashboard.css" rel="stylesheet">
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
    </div>
    <div>

    </div>
    <?php
    include "admin/includes/conn.php";
    $sql = "SELECT * FROM `users` WHERE `id` = $s_user";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $r_user = $row['user'];
    $r_sms = $row['messages'];
    $r_sent = $row['sent'];
    echo "Welcome  <b class='text-danger'>$r_user</b>! Thanks for using our services. If you find any problem, please feel free to contact admin.";

    ?>
    <br>
    <br>
    <div class="d-flex flex-row">

      <div class="card bg-info text-white  " style="width: 18rem;margin-right:15px ;">
        <div class="card-body">
          <h5 class="card-title">Total SMS remaining</h5>
          <h1><?php echo $r_sms; ?></h1>
        </div>
      </div>

      <div class="card bg-primary text-white" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title">Total SMS sent</h5>
          <h1><?php echo $r_sent; ?></h1>
        </div>
      </div>
    </div>

    <!-- PIE GRAPH STARTS HERE  -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <canvas id="myChart" style="width:100%;max-width:600px"></canvas>

    <script>
      var xValues = ["Total sent", "Remaining SMS"];
      var yValues = [<?php echo "$r_sent , $r_sms"; ?>];
      var barColors = [
        "#0d6efd",
        "#00aba9"
      ];

      new Chart("myChart", {
        type: "pie",
        data: {
          labels: xValues,
          datasets: [{
            backgroundColor: barColors,
            data: yValues
          }]
        },
        options: {
          title: {
            display: true,
            text: "SMS Details"
          }
        }
      });
    </script>





  </main>
  </div>
  </div>


  <script src="https://getbootstrap.com/docs/5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
</body>

</html>