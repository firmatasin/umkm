<?php
?>
<!DOCTYPE html>
<html lang="en">
     
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UMKM</title>

    <style>
    .bg-main {
      background-image: url('bambu batik_5.jpg'); /* Pastikan path gambar sesuai */
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      height: 100vh; /* Tinggi halaman sesuai kebutuhan */
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: white; /* Warna teks */
    }
    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5); /* Opacity overlay */
    }
  </style>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="admin/dist/css/adminlte.min.css">
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="admin/login.php" class="nav-link">Admin Panel</a>
                        </li>
                    </ul>

                </div>

            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
<body>
  <nav class="navbar navbar-expand-md bg-black sticky-top border-bottom" data-bs-theme="black"></nav>
  <main class="bg-main position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center">
    <div class="overlay"></div> <!-- Overlay untuk efek gelap -->
    <div class="col-md-6 p-lg-5 mx-auto my-5">
      <h1 class="display-4 fw-bold">
        <b>SELAMAT DATANG</b>
      </h1>
      <h2 class="fw-normal text-white mb-3">
        Di Website UMKM Kerajinan Bambu Batik Kampung Bowongkulu 1
      </h2>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
      </div>
    </div>
  </main>
</body>
        <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- Default to the left -->
        <strong>Copyright &copy; 2021-2024 <a href="#">Firma Lasari Tasin | SI Polnustar</a>.</strong> All rights reserved.
    </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="admin/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="admin/dist/js/adminlte.min.js"></script>
</body>

</html>