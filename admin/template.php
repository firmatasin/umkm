<?php
//Konfigurasi Halaman
$_halaman_judul_tab = 'Judul Tab';
$_halaman_judul_halaman = 'Judul Halaman';
$_halaman_judul_card = 'Judul Card';
$_halaman_footer_card = 'Footer Card';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $_halaman_judul_tab;?></title>
  <?php include('_part/_referensi.php');?>
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
    <?php include('_part/_navbar.php');?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
    <?php include('_part/_sidebar.php');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $_halaman_judul_halaman;?></h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><?php echo $_halaman_judul_card;?></h3>
        </div>
        <div class="card-body">
          <!-- ISI KONTEN -->
          <!-- /*ISI KONTEN -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <?php echo $_halaman_footer_card;?>
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include('_part/_footer.php');?>

</div>
<!-- ./wrapper -->

<?php include('_part/_script.php');?>
</body>
</html>
