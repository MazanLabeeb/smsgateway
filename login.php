<?php
  require "admin/includes/conn.php";

  session_start();
  if(isset($_SESSION['user']) && isset($_SESSION['loggedin'])){
    header('location:index.php');
    exit();
  }


$invalidlogin = false;
if (isset($_POST["login"])) {
  $user = mysqli_real_escape_string($conn ,test_input($_POST['user']));
  $pass = mysqli_real_escape_string($conn, test_input($_POST['pass']));

  $sql = "SELECT * FROM `users` WHERE `user` = binary '$user' AND `pass` = binary '$pass'";
  $result = mysqli_query($conn,$sql);
  $count = mysqli_num_rows($result);
  if ($count>0) {
    $row = mysqli_fetch_assoc($result);
    echo "login";
    session_start();
    $_SESSION['loggedin'] = true;
    $_SESSION['user']  = $row['id'] ;
    header('location:index.php');
  } else {
    echo "no";
    $invalidlogin = true;
  }
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.88.1">
  <title>USER PANEL - LOGIN</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">



  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

  <!-- Favicons -->
  <link rel="apple-touch-icon" href="https://getbootstrap.com/docs/5.1/examples/sign-in//docs/5.1/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
  <link rel="icon" href="https://getbootstrap.com/docs/5.1/examples/sign-in//docs/5.1/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
  <link rel="icon" href="https://getbootstrap.com/docs/5.1/examples/sign-in//docs/5.1/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
  <link rel="manifest" href="https://getbootstrap.com/docs/5.1/examples/sign-in//docs/5.1/assets/img/favicons/manifest.json">
  <link rel="mask-icon" href="https://getbootstrap.com/docs/5.1/examples/sign-in//docs/5.1/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
  <link rel="icon" href="https://getbootstrap.com/docs/5.1/examples/sign-in//docs/5.1/assets/img/favicons/favicon.ico">
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
  <link href="src/styles/signin.css" rel="stylesheet">
</head>

<body class="text-center" style="background:black;">

  <main class="form-signin">
    <form method="post" action="">

      <h1 class="h5 mb-3 fw-normal text-primary" style="text-decoration:underline;">Gateway by Benmarting</h1>
      <h2 class="h3 mb-3 fw-normal text-white">Please enter Login Details to continue</h2>

      <div class="form-floating">
        <input type="text" name="user" class="form-control" id="floatingInput" placeholder="name@example.com">
        <label for="floatingInput">Username</label>
      </div>
      <div class="form-floating">
        <input type="password" name="pass" class="form-control" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Password</label>
      </div>

      <!-- <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div> -->
      <button class="w-100 btn btn-lg btn-primary" name="login" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
    </form>
  </main>



</body>

</html>
<?php
  if($invalidlogin=="true"){
    echo '<script>
    alert("Please Enter Valid Login Details!");
  </script>';
  }
?>