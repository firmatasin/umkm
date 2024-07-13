<?php
session_start();
require_once "support/myfunction.php";

// Cek Login, terdaftar atau tidak
if (isset($_POST["login"])) {
  login($_POST["username"], $_POST["password"]); // Memanggil fungsi login dengan seluruh data POST
}

// Jika sudah login, arahkan ke halaman index.php
jump_if_login_sucess();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Log in</title>

  <?php include ('_part/_referensi.php'); ?>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <b>SENTRAL BAMBU BATIK BOWONGKULU</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">UMKM BAMBU BATIK</p>

        <form method="POST" action="#">
          <div class="form-floating mb-3">
          <label for="username">Username</label>
            <input class="form-control" name="username" id="username" type="text" placeholder="Username" />
            
          </div>
          <div class="form-floating mb-3">
          <label for="inputPassword">Password</label>
            <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Password" />
            
          </div>

          <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
            <button type="submit" class="btn btn-primary" name="login">Login</button>
          </div>
        </form>

      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <?php include ('_part/_script.php'); ?>
</body>

</html>